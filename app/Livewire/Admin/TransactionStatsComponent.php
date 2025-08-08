<?php
namespace App\Livewire\Admin;

use App\Models\Transaction;
use App\Models\Wallet;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class TransactionStatsComponent extends Component
{
    public $totalTransactions;
    public $totalVolume;
    public $successfulTransactions;
    public $failedTransactions;
    public $creditTransactions;
    public $debitTransactions;
    public $transactionsToday;
    public $volumeToday;
    public $averageTransactionAmount;
    public $successRate;

    protected $listeners = ['refreshTransactionStats' => 'loadStats'];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        // Cache transaction stats for 5 minutes for performance
        $this->totalTransactions = Cache::remember('transaction_stats.total', 300, function() {
            return Transaction::count();
        });

        $this->totalVolume = Cache::remember('transaction_stats.volume', 300, function() {
            return Transaction::where('status', 'completed')->sum('amount');
        });

        $this->successfulTransactions = Cache::remember('transaction_stats.successful', 300, function() {
            return Transaction::where('status', 'completed')->count();
        });

        $this->failedTransactions = Cache::remember('transaction_stats.failed', 300, function() {
            return Transaction::where('status', 'failed')->count();
        });

        $this->creditTransactions = Cache::remember('transaction_stats.credit', 300, function() {
            return Transaction::where('transaction_type', 'credit')->where('status', 'completed')->count();
        });

        $this->debitTransactions = Cache::remember('transaction_stats.debit', 300, function() {
            return Transaction::where('transaction_type', 'debit')->where('status', 'completed')->count();
        });

        // Today's stats
        $this->transactionsToday = Cache::remember('transaction_stats.today_count', 60, function() {
            return Transaction::whereDate('created_at', today())->count();
        });

        $this->volumeToday = Cache::remember('transaction_stats.today_volume', 60, function() {
            return Transaction::whereDate('created_at', today())
                             ->where('status', 'completed')
                             ->sum('amount');
        });

        // Calculate average transaction amount
        $this->averageTransactionAmount = Cache::remember('transaction_stats.average', 300, function() {
            $completed = Transaction::where('status', 'completed');
            return $completed->count() > 0 ? $completed->avg('amount') : 0;
        });

        // Calculate success rate
        $this->successRate = Cache::remember('transaction_stats.success_rate', 300, function() {
            $total = Transaction::count();
            if ($total > 0) {
                return ($this->successfulTransactions / $total) * 100;
            }
            return 0;
        });
    }

    public function render()
    {
        return view('livewire.admin.transaction-stats-component');
    }
}