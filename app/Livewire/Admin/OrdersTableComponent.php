<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;

class OrdersTableComponent extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Order::all();
    }

    public function render()
    {
        return view('livewire.admin.orders-table-component');
    }
}
