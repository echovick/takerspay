<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderHistory extends Component
{
    public $data;

    public function boot()
    {
        $this->data['history'] = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.order-history');
    }
}
