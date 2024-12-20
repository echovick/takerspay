<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;

class RecentOrders extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Order::latest()->take(10)->get();
    }

    public function render()
    {
        return view('livewire.admin.recent-orders');
    }
}
