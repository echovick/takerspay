<?php
namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class UserCryptoOverview extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.admin.user-crypto-overview', [
            'cryptoWallets' => $this->user->wallets()->where('type', 'crypto')->get(),
            'fiatWallets'   => $this->user->wallets()->where('type', 'fiat')->get(),
            'orders'        => $this->user->orders()
                ->with('wallet')
                ->orderBy('created_at', 'desc')
                ->paginate(10),
        ]);
    }
}
