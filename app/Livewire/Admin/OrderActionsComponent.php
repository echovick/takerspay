<?php
namespace App\Livewire\Admin;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class OrderActionsComponent extends Component
{
    public $order;
    public $newStatus;

    protected $listeners = ['refreshOrderActions' => '$refresh'];

    public function mount(Order $order)
    {
        $this->order     = $order;
        $this->newStatus = $order->transaction_status;
    }

    public function updateOrderStatus()
    {
        $this->validate([
            'newStatus' => 'required|in:pending,processing,completed,confirmed,canceled',
        ]);

        try {
            $this->order->update(['transaction_status' => $this->newStatus]);

            session()->flash('success', 'Order status updated successfully to ' . ucfirst($this->newStatus));
            $this->dispatch('refreshOrderActions');

        } catch (\Exception $e) {
            Log::error('Failed to update order status: ' . $e->getMessage());
            session()->flash('error', 'Failed to update order status. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.admin.order-actions-component');
    }
}
