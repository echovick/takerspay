<?php

namespace App\Livewire\Admin;

use App\Constants\AssetType;
use App\Models\Order;
use App\Traits\AlertMessageHelper;
use Livewire\Component;

class OrderDetail extends Component
{
    use AlertMessageHelper;

    public $order;
    public $status;
    public $cryptoWallets;
    public $bankAccounts;

    public function mount()
    {
        $orderId = request()->get('ref', '');
        if ($orderId) {
            $this->order = Order::where('reference', $orderId)->with('user.wallets')->first();
            
            if ($this->order && $this->order->user) {
                $this->cryptoWallets = $this->order->user->wallets()->where('type', 'crypto')->get();
                $this->bankAccounts = $this->order->user->wallets()->where('type', 'fiat')->get();
            }
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
