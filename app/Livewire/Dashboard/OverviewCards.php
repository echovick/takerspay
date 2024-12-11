<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OverviewCards extends Component
{
    public $data;

    public function mount()
    {
        $user = Auth::user();
        $this->data['pendingOrders'] = $user->orders->where('transaction_status', 'pending');
        $this->data['completedOrders'] = $user->orders->where('transaction_status', 'completed');
    }

    public function render()
    {
        return view('livewire.dashboard.overview-cards');
    }
}
