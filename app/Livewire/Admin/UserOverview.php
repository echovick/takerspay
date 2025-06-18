<?php
namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class UserOverview extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.admin.user-overview', [
            'cryptoWallets'      => $this->user->wallets()->where('type', 'crypto')->get(),
            'fiatWallets'        => $this->user->wallets()->where('type', 'fiat')->get(),
            'nubanWallets'       => $this->user->wallets()->where('type', 'nuban')->get(),
            'recentOrders'       => $this->user->orders()->orderBy('created_at', 'desc')->limit(5)->get(),
            'recentTransactions' => \App\Models\Transaction::whereHas('wallet', function ($q) {
                $q->where('user_id', $this->user->id);
            })->orderBy('created_at', 'desc')->limit(5)->get(),
        ]);
    }
}
