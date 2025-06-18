<?php
namespace App\Http\Livewire\Admin;

use App\Models\Transaction;
use App\Models\User;
use Livewire\Component;

class UserWalletsOverview extends Component
{
    public $user;
    public $fiatWallet;
    public $cryptoWallet;
    public $nubanWallet;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->loadWallets();
    }

    public function loadWallets()
    {
        $this->fiatWallet   = $this->user->wallets()->where('type', 'fiat')->first();
        $this->cryptoWallet = $this->user->wallets()->where('type', 'crypto')->first();
        $this->nubanWallet  = $this->user->wallets()->where('type', 'nuban')->first();
    }

    public function render()
    {
        $walletTransactions = Transaction::whereHas('wallet', function ($q) {
            $q->where('user_id', $this->user->id);
        })->latest()->take(10)->get();

        return view('livewire.admin.user-wallets-overview', [
            'walletTransactions' => $walletTransactions,
        ]);
    }
}
