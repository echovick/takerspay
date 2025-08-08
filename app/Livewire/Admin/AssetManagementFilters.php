<?php
namespace App\Livewire\Admin;

use App\Models\Asset;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AssetManagementFilters extends Component
{
    public $search = '';
    public $typeFilter = '';
    public $availabilityFilter = '';
    public $showAddAssetModal = false;
    
    // Add Asset Form Properties
    public $name = '';
    public $slug = '';
    public $type = '';
    public $available_units = '';
    public $naira_buy_rate = '';
    public $naira_sell_rate = '';

    public function mount()
    {
        // Initialize component and dispatch initial filters
        $this->dispatchFilters();
    }

    protected function dispatchFilters()
    {
        $this->dispatch('filtersUpdated', [
            'search' => $this->search,
            'typeFilter' => $this->typeFilter,
            'availabilityFilter' => $this->availabilityFilter
        ]);
    }

    public function updatedSearch()
    {
        $this->dispatchFilters();
    }

    public function updatedTypeFilter()
    {
        $this->dispatchFilters();
    }

    public function updatedAvailabilityFilter()
    {
        $this->dispatchFilters();
    }

    public function openAddAssetModal()
    {
        $this->showAddAssetModal = true;
        $this->resetForm();
    }

    public function closeAddAssetModal()
    {
        $this->showAddAssetModal = false;
        $this->resetForm();
    }

    protected function resetForm()
    {
        $this->name = '';
        $this->slug = '';
        $this->type = '';
        $this->available_units = '';
        $this->naira_buy_rate = '';
        $this->naira_sell_rate = '';
        $this->resetValidation();
    }

    public function updatedName()
    {
        // Auto-generate slug from name
        $this->slug = \Illuminate\Support\Str::slug($this->name);
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:assets,name',
            'slug' => 'required|string|max:255|unique:assets,slug',
            'type' => 'required|in:crypto,giftcard',
            'available_units' => 'required|numeric|min:0',
            'naira_buy_rate' => 'required|numeric|min:0',
            'naira_sell_rate' => 'required|numeric|min:0',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'name' => 'Asset Name',
            'slug' => 'Asset Slug',
            'type' => 'Asset Type',
            'available_units' => 'Available Units',
            'naira_buy_rate' => 'Naira Buy Rate',
            'naira_sell_rate' => 'Naira Sell Rate',
        ];
    }

    public function createAsset()
    {
        $this->validate();

        try {
            // Create the asset
            Asset::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'type' => $this->type,
                'available_units' => $this->available_units,
                'naira_buy_rate' => $this->naira_buy_rate,
                'naira_sell_rate' => $this->naira_sell_rate,
            ]);

            // Close modal and reset form
            $this->closeAddAssetModal();

            // Refresh the assets table and stats
            $this->dispatch('refreshAssets');
            $this->dispatch('refreshAssetStats');

            // Clear cache to ensure fresh data
            \Illuminate\Support\Facades\Cache::forget('asset_stats.total');
            \Illuminate\Support\Facades\Cache::forget('asset_stats.crypto');
            \Illuminate\Support\Facades\Cache::forget('asset_stats.giftcard');
            \Illuminate\Support\Facades\Cache::forget('asset_stats.active');
            \Illuminate\Support\Facades\Cache::forget('asset_stats.orders');
            \Illuminate\Support\Facades\Cache::forget('asset_stats.rates');
            \Illuminate\Support\Facades\Cache::forget('asset_stats.recent');

            // Show success message
            session()->flash('success', 'Asset created successfully!');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create asset. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.admin.asset-management-filters');
    }
}