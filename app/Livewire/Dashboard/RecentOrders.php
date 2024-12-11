<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecentOrders extends Component
{
    public $recentOrders;

    public function mount()
    {
        $user = Auth::user();
        $this->resetActiveOrderSession();
        $this->recentOrders = $user->orders()->orderBy('created_at', 'desc')->limit(10)->get();
    }

    private function resetActiveOrderSession()
    {
        if (session()->has('orderId')) {
            session()->forget('orderId');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.recent-orders');
    }
}
