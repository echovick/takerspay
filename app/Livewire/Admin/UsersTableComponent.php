<?php
namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class UsersTableComponent extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::where('role', 'user')->with('wallets')->get();

        // Calculate account balance for each user
        foreach ($this->users as $user) {
            $user->account_balance = $this->calculateUserBalance($user);
        }
    }

    /**
     * Calculate the total balance for a user from all their wallets
     */
    protected function calculateUserBalance(User $user)
    {
        $totalBalance = 0;

        // Sum up balances from user wallets (if there's a balance field)
        foreach ($user->wallets as $wallet) {
            // If wallet has a balance field, add it to the total
            if (isset($wallet->balance)) {
                $totalBalance += $wallet->balance;
            }
        }

        return $totalBalance;
    }

    public function render()
    {
        return view('livewire.admin.users-table-component');
    }
}
