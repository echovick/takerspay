<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersTableComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';
    public $assetFilter = 'all';
    public $typeFilter = 'all';
    public $dateFilter = 'all';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    
    protected $listeners = ['refreshOrders' => '$refresh', 'filtersUpdated' => 'updateFilters'];

    public function mount()
    {
        // Initialize component
    }

    public function updateFilters($filters)
    {
        $this->search = $filters['search'] ?? '';
        $this->statusFilter = $filters['statusFilter'] ?? '';
        $this->assetFilter = $filters['assetFilter'] ?? '';
        $this->typeFilter = $filters['typeFilter'] ?? '';
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingAssetFilter()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
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

    public function getOrders()
    {
        $query = Order::with(['user.metaData', 'assetInfo', 'wallet']);

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('reference', 'like', '%' . $this->search . '%')
                    ->orWhere('asset', 'like', '%' . $this->search . '%')
                    ->orWhere('trade_currency', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($userQuery) {
                        $userQuery->where('email', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('user.metaData', function ($metaQuery) {
                        $metaQuery->where('first_name', 'like', '%' . $this->search . '%')
                            ->orWhere('last_name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Apply status filter
        if ($this->statusFilter !== '' && $this->statusFilter !== 'all') {
            $query->where('transaction_status', $this->statusFilter);
        }

        // Apply asset filter
        if ($this->assetFilter !== '' && $this->assetFilter !== 'all') {
            $query->where('asset', $this->assetFilter);
        }

        // Apply type filter
        if ($this->typeFilter !== '' && $this->typeFilter !== 'all') {
            $query->where('type', $this->typeFilter);
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

    /**
     * Get order status with proper formatting and color
     */
    public function getOrderStatus(Order $order)
    {
        $status = $order->transaction_status;
        
        return [
            'status' => $status,
            'color' => match($status) {
                'completed' => 'green',
                'pending' => 'yellow',
                'processing', 'confirmed' => 'blue',
                'canceled' => 'red',
                default => 'gray'
            }
        ];
    }

    /**
     * Format order value for display
     */
    public function formatOrderValue(Order $order)
    {
        if ($order->naira_price) {
            return '₦' . number_format($order->naira_price, 2);
        } elseif ($order->dollar_price) {
            return '$' . number_format($order->dollar_price, 2);
        }
        return 'N/A';
    }

    public function render()
    {
        $orders = $this->getOrders();
        
        return view('livewire.admin.orders-table-component', [
            'orders' => $orders,
        ]);
    }
}
