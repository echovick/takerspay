<?php
namespace App\Livewire\Admin;

use App\Models\BankAccount;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserFinanceOverview extends Component
{
    use WithPagination;

    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        $userId = $this->user->id;

        $transactions = Transaction::whereHas('wallet', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
            ->with('wallet')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $bankAccounts = BankAccount::where('user_id', $userId)->get();
        $tickets      = Ticket::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('livewire.admin.user-finance-overview', [
            'nubanWallet'  => $this->user->wallets()->where('type', 'nuban')->first(),
            'transactions' => $transactions,
            'bankAccounts' => $bankAccounts,
            'tickets'      => $tickets,
        ]);
    }
}
