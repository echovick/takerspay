<?php
namespace App\Livewire\Admin;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class WalletStatsComponent extends Component
{
    public $totalWallets;
    public $cryptoWallets;
    public $fiatWallets;
    public $activeWallets;
    public $totalBalance;
    public $totalTransactions;
    public $transactionsToday;
    public $averageWalletBalance;

    protected $listeners = ['refreshWalletStats' => 'loadStats'];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        // Cache wallet stats for 5 minutes for performance
        $this->totalWallets = Cache::remember('wallet_stats.total', 300, function () {
            return Wallet::count();
        });

        $this->cryptoWallets = Cache::remember('wallet_stats.crypto', 300, function () {
            return Wallet::where('type', 'crypto')->count();
        });

        $this->fiatWallets = Cache::remember('wallet_stats.nuban', 300, function () {
            return Wallet::where('type', 'nuban')->count();
        });

        $this->activeWallets = Cache::remember('wallet_stats.active', 300, function () {
            return Wallet::where('status', 'active')->count();
        });

        $this->totalBalance = Cache::remember('wallet_stats.total_balance', 300, function () {
            return Wallet::sum('balance');
        });

        $this->totalTransactions = Cache::remember('wallet_stats.transactions', 300, function () {
            return Transaction::count();
        });

        $this->transactionsToday = Cache::remember('wallet_stats.transactions_today', 60, function () {
            return Transaction::whereDate('created_at', today())->count();
        });

        $this->averageWalletBalance = Cache::remember('wallet_stats.avg_balance', 300, function () {
            $activeWallets = Wallet::where('status', 'active')->count();
            if ($activeWallets > 0) {
                return Wallet::where('status', 'active')->avg('balance');
            }
            return 0;
        });
    }

    public function render()
    {
        return view('livewire.admin.wallet-stats-component');
    }
}
