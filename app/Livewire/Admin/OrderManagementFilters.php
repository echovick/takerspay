<?php
namespace App\Livewire\Admin;

use Livewire\Component;

class OrderManagementFilters extends Component
{
    public $search = '';
    public $statusFilter = '';
    public $assetFilter = '';
    public $typeFilter = '';

    public function mount()
    {
        // Initialize component
    }

    public function updatedSearch()
    {
        $this->dispatch('filtersUpdated', [
            'search' => $this->search,
            'statusFilter' => $this->statusFilter,
            'assetFilter' => $this->assetFilter,
            'typeFilter' => $this->typeFilter
        ]);
    }

    public function updatedStatusFilter()
    {
        $this->dispatch('filtersUpdated', [
            'search' => $this->search,
            'statusFilter' => $this->statusFilter,
            'assetFilter' => $this->assetFilter,
            'typeFilter' => $this->typeFilter
        ]);
    }

    public function updatedAssetFilter()
    {
        $this->dispatch('filtersUpdated', [
            'search' => $this->search,
            'statusFilter' => $this->statusFilter,
            'assetFilter' => $this->assetFilter,
            'typeFilter' => $this->typeFilter
        ]);
    }

    public function updatedTypeFilter()
    {
        $this->dispatch('filtersUpdated', [
            'search' => $this->search,
            'statusFilter' => $this->statusFilter,
            'assetFilter' => $this->assetFilter,
            'typeFilter' => $this->typeFilter
        ]);
    }

    public function exportOrders()
    {
        // Export functionality can be implemented later
        session()->flash('info', 'Export functionality will be available soon.');
    }

    public function render()
    {
        return view('livewire.admin.order-management-filters');
    }
}