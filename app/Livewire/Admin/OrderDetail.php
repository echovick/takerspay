<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Traits\AlertMessageHelper;
use Livewire\Component;

class OrderDetail extends Component
{
    use AlertMessageHelper;

    public $order;
    public $status;

    public function mount()
    {
        $orderId = $_GET['ref'] ?? '';
        if ($orderId) {
            $this->order = Order::where('reference', $orderId)->first();
        }
    }

    public function updateStatus()
    {
        if ($this->order) {
            $this->order->transaction_status = $this->status;
            $this->order->save();
            $this->setMessage('successMsg', 'Order status updated successfully');
        }
    }

    public function render()
    {
        return view('livewire.admin.order-detail');
    }
}
