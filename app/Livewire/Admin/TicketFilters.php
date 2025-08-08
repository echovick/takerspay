<?php
namespace App\Livewire\Admin;

use App\Models\Ticket;
use Livewire\Component;

class TicketFilters extends Component
{
    public $search = '';
    public $statusFilter = '';
    public $dateFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function mount()
    {
        // Initialize component and dispatch initial filters
        $this->dispatchFilters();
    }

    protected function dispatchFilters()
    {
        $this->dispatch('filtersUpdated', [
            'search' => $this->search,
            'statusFilter' => $this->statusFilter,
            'dateFilter' => $this->dateFilter,
            'sortBy' => $this->sortBy,
            'sortDirection' => $this->sortDirection,
        ]);
    }

    public function updatedSearch()
    {
        $this->dispatchFilters();
    }

    public function updatedStatusFilter()
    {
        $this->dispatchFilters();
    }

    public function updatedDateFilter()
    {
        $this->dispatchFilters();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->dispatchFilters();
    }

    public function render()
    {
        return view('livewire.admin.ticket-filters');
    }
}