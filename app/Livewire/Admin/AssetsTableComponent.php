<?php

namespace App\Livewire\Admin;

use App\Models\Asset;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class AssetsTableComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $typeFilter = '';
    public $availabilityFilter = '';
    public $dateFilter = 'all';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    
    // Edit Asset Modal Properties
    public $showEditModal = false;
    public $editingAsset = null;
    public $editName = '';
    public $editSlug = '';
    public $editType = '';
    public $editAvailableUnits = '';
    public $editNairaBuyRate = '';
    public $editNairaSellRate = '';
    
    protected $listeners = ['refreshAssets' => '$refresh', 'filtersUpdated' => 'updateFilters'];

    public function mount()
    {
        // Initialize component
    }

    public function updateFilters($filters)
    {
        $this->search = $filters['search'] ?? '';
        $this->typeFilter = $filters['typeFilter'] ?? '';
        $this->availabilityFilter = $filters['availabilityFilter'] ?? '';
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingAvailabilityFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function getAssets()
    {
        $query = Asset::query();

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%')
                    ->orWhere('type', 'like', '%' . $this->search . '%');
            });
        }

        // Apply type filter
        if ($this->typeFilter !== '' && $this->typeFilter !== 'all') {
            $query->where('type', $this->typeFilter);
        }

        // Apply availability filter
        if ($this->availabilityFilter !== '' && $this->availabilityFilter !== 'all') {
            if ($this->availabilityFilter === 'available') {
                $query->where('available_units', '>', 0);
            } elseif ($this->availabilityFilter === 'unavailable') {
                $query->where('available_units', '<=', 0);
            }
        }

        // Apply date filter
        if ($this->dateFilter !== 'all') {
            switch ($this->dateFilter) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->where('created_at', '>=', now()->subWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;
                case 'year':
                    $query->where('created_at', '>=', now()->subYear());
                    break;
            }
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function editAsset($assetId)
    {
        $this->editingAsset = Asset::findOrFail($assetId);
        $this->editName = $this->editingAsset->name;
        $this->editSlug = $this->editingAsset->slug;
        $this->editType = $this->editingAsset->type;
        $this->editAvailableUnits = $this->editingAsset->available_units;
        $this->editNairaBuyRate = $this->editingAsset->naira_buy_rate;
        $this->editNairaSellRate = $this->editingAsset->naira_sell_rate;
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingAsset = null;
        $this->resetEditForm();
        $this->resetValidation();
    }

    protected function resetEditForm()
    {
        $this->editName = '';
        $this->editSlug = '';
        $this->editType = '';
        $this->editAvailableUnits = '';
        $this->editNairaBuyRate = '';
        $this->editNairaSellRate = '';
    }

    public function updatedEditName()
    {
        // Auto-generate slug from name during edit
        $this->editSlug = \Illuminate\Support\Str::slug($this->editName);
    }

    public function updateAsset()
    {
        $this->validate([
            'editName' => 'required|string|max:255|unique:assets,name,' . $this->editingAsset->id,
            'editSlug' => 'required|string|max:255|unique:assets,slug,' . $this->editingAsset->id,
            'editType' => 'required|in:crypto,giftcard',
            'editAvailableUnits' => 'required|numeric|min:0',
            'editNairaBuyRate' => 'required|numeric|min:0',
            'editNairaSellRate' => 'required|numeric|min:0',
        ], [], [
            'editName' => 'Asset Name',
            'editSlug' => 'Asset Slug',
            'editType' => 'Asset Type',
            'editAvailableUnits' => 'Available Units',
            'editNairaBuyRate' => 'Naira Buy Rate',
            'editNairaSellRate' => 'Naira Sell Rate',
        ]);

        try {
            $this->editingAsset->update([
                'name' => $this->editName,
                'slug' => $this->editSlug,
                'type' => $this->editType,
                'available_units' => $this->editAvailableUnits,
                'naira_buy_rate' => $this->editNairaBuyRate,
                'naira_sell_rate' => $this->editNairaSellRate,
            ]);

            $this->closeEditModal();
            $this->dispatch('refreshAssetStats');

            // Clear cache
            \Illuminate\Support\Facades\Cache::forget('asset_stats.total');
            \Illuminate\Support\Facades\Cache::forget('asset_stats.crypto');
            \Illuminate\Support\Facades\Cache::forget('asset_stats.giftcard');
            \Illuminate\Support\Facades\Cache::forget('asset_stats.active');
            \Illuminate\Support\Facades\Cache::forget('asset_stats.orders');
            \Illuminate\Support\Facades\Cache::forget('asset_stats.rates');

            session()->flash('success', 'Asset updated successfully!');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update asset. Please try again.');
        }
    }

    public function deleteAsset($assetId)
    {
        try {
            // Check if asset is being used in orders
            $ordersCount = Order::where('asset_id', $assetId)->count();
            
            if ($ordersCount > 0) {
                session()->flash('error', "Cannot delete this asset. It's being used in {$ordersCount} order(s).");
                return;
            }

            Asset::findOrFail($assetId)->delete();
            
            $this->dispatch('refreshAssetStats');

            // Clear cache
            \Illuminate\Support\Facades\Cache::forget('asset_stats.total');
            \Illuminate\Support\Facades\Cache::forget('asset_stats.crypto');
            \Illuminate\Support\Facades\Cache::forget('asset_stats.giftcard');
            \Illuminate\Support\Facades\Cache::forget('asset_stats.active');
            \Illuminate\Support\Facades\Cache::forget('asset_stats.orders');
            \Illuminate\Support\Facades\Cache::forget('asset_stats.rates');

            session()->flash('success', 'Asset deleted successfully!');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete asset. Please try again.');
        }
    }

    /**
     * Get asset availability status with color coding
     */
    public function getAvailabilityStatus(Asset $asset)
    {
        if ($asset->available_units > 100) {
            return ['status' => 'In Stock', 'color' => 'green'];
        } elseif ($asset->available_units > 0) {
            return ['status' => 'Low Stock', 'color' => 'yellow'];
        } else {
            return ['status' => 'Out of Stock', 'color' => 'red'];
        }
    }

    /**
     * Get orders count for an asset
     */
    public function getAssetOrdersCount(Asset $asset)
    {
        return Order::where('asset_id', $asset->id)->count();
    }

    /**
     * Calculate profit margin
     */
    public function getProfitMargin(Asset $asset)
    {
        if ($asset->naira_buy_rate > 0) {
            return (($asset->naira_buy_rate - $asset->naira_sell_rate) / $asset->naira_buy_rate) * 100;
        }
        return 0;
    }

    public function render()
    {
        $assets = $this->getAssets();
        
        return view('livewire.admin.assets-table-component', [
            'assets' => $assets,
        ]);
    }
}
