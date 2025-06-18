<?php
namespace App\Livewire\Admin;

use App\Models\Ticket;
use Livewire\Component;

class TicketSummary extends Component
{
    public array $tickets = [];

    public function mount()
    {
        $this->loadTickets();
    }

    protected function loadTickets()
    {
        $this->tickets = Ticket::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin.ticket-summary');
    }
}
