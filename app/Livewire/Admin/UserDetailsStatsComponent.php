<?php
namespace App\Livewire\Admin;

use App\Models\BankAccount;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class UserDetailsStatsComponent extends Component
{
    public $user;

    protected $listeners = ['refreshUserStats' => '$refresh'];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function getUserStats()
    {
        $cacheKey = "user_details_stats.{$this->user->id}";

        return Cache::remember($cacheKey, 30, function () {
            $wallets = $this->user->wallets;

            // Get wallet balances by type
            $cryptoWallet = $wallets->where('type', 'crypto')->first();
            $fiatWallet   = $wallets->where('type', 'fiat')->first();
            $nubanWallet  = $wallets->where('type', 'nuban')->first();

            // Calculate totals
            $totalWalletBalance = $wallets->sum('balance');
            $totalTransactions  = Transaction::whereHas('wallet', function ($q) {
                $q->where('user_id', $this->user->id);
            })->count();

            $totalOrders     = $this->user->orders()->count();
            $completedOrders = $this->user->orders()
                ->where('transaction_status', 'completed')
                ->count();

            $pendingOrders = $this->user->orders()
                ->where('transaction_status', 'pending')
                ->count();

            $bankAccountCount = BankAccount::where('user_id', $this->user->id)->count();
            $ticketCount      = Ticket::where('user_id', $this->user->id)->count();
            $openTicketCount  = Ticket::where('user_id', $this->user->id)->where('status', 'Open')->count();

            // KYC Status
            $kycStatus = $this->user->metaData->status ?? 'inactive';

            return [
                'wallets'      => [
                    'crypto'        => [
                        'balance'  => $cryptoWallet ? $cryptoWallet->balance : 0,
                        'currency' => $cryptoWallet ? $cryptoWallet->currency : 'BTC',
                        'exists'   => (bool) $cryptoWallet,
                    ],
                    'fiat'          => [
                        'balance'  => $fiatWallet ? $fiatWallet->balance : 0,
                        'currency' => $fiatWallet ? $fiatWallet->currency : 'USD',
                        'exists'   => (bool) $fiatWallet,
                    ],
                    'nuban'         => [
                        'balance'  => $nubanWallet ? $nubanWallet->balance : 0,
                        'currency' => $nubanWallet ? $nubanWallet->currency : 'NGN',
                        'exists'   => (bool) $nubanWallet,
                    ],
                    'total_balance' => $totalWalletBalance,
                ],
                'orders'       => [
                    'total'           => $totalOrders,
                    'completed'       => $completedOrders,
                    'pending'         => $pendingOrders,
                    'completion_rate' => $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100, 1) : 0,
                ],
                'transactions' => [
                    'total' => $totalTransactions,
                ],
                'support'      => [
                    'bank_accounts' => $bankAccountCount,
                    'tickets'       => $ticketCount,
                    'open_tickets'  => $openTicketCount,
                ],
                'kyc'          => [
                    'status'   => $kycStatus,
                    'verified' => $kycStatus === 'active',
                ],
            ];
        });
    }

    public function render()
    {
        $stats = $this->getUserStats();

        return view('livewire.admin.user-details-stats-component', [
            'stats' => $stats,
        ]);
    }
}
