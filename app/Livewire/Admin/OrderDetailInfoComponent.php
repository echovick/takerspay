<?php
namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;

class OrderDetailInfoComponent extends Component
{
    public $order;

    public function mount(Order $order)
    {
        $this->order = $order;
    }

    public function render()
    {
        return view('livewire.admin.order-detail-info-component');
    }
}