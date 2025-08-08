<?php

namespace App\Livewire\Admin;

use App\Models\Wallet;
use App\Models\User;
use App\Models\Asset;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class UserWalletsComponent extends Component
{
    use WithPagination;

    public $activeTab = 'crypto';
    public $search = '';
    public $typeFilter = '';
    public $statusFilter = '';
    public $perPage = 10;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    
    // Credit/Debit Modal Properties
    public $showTransactionModal = false;
    public $selectedWallet = null;
    public $transactionType = '';
    public $transactionAmount = '';
    public $transactionDescription = '';

    protected $listeners = ['filtersUpdated' => 'updateFilters', 'refreshWallets' => '$refresh'];

    public function mount()
    {
        // Initialize component
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function updateFilters($filters)
    {
        $this->search = $filters['search'] ?? '';
        $this->typeFilter = $filters['typeFilter'] ?? '';
        $this->statusFilter = $filters['statusFilter'] ?? '';
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function getWallets()
    {
        $query = Wallet::with(['user.metaData', 'asset']);

        // Filter by active tab
        if ($this->activeTab === 'crypto') {
            $query->where('type', 'crypto');
        } else {
            $query->where('type', 'fiat');
        }

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->whereHas('user', function ($userQuery) {
                    $userQuery->where('email', 'like', '%' . $this->search . '%')
                             ->orWhereHas('metaData', function ($metaQuery) {
                                 $metaQuery->where('first_name', 'like', '%' . $this->search . '%')
                                          ->orWhere('last_name', 'like', '%' . $this->search . '%');
                             });
                })
                ->orWhere('crypto_wallet_number', 'like', '%' . $this->search . '%')
                ->orWhere('account_number', 'like', '%' . $this->search . '%')
                ->orWhere('bank_name', 'like', '%' . $this->search . '%')
                ->orWhere('account_name', 'like', '%' . $this->search . '%');
            });
        }

        // Apply type filter (this is redundant with tab filtering but kept for consistency)
        if ($this->typeFilter !== '' && $this->typeFilter !== 'all') {
            $query->where('type', $this->typeFilter);
        }

        // Apply status filter
        if ($this->statusFilter !== '' && $this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Apply sorting
        if ($this->sortBy === 'user_name') {
            $query->join('users', 'wallets.user_id', '=', 'users.id')
                  ->leftJoin('user_meta_data', 'users.id', '=', 'user_meta_data.user_id')
                  ->orderBy('user_meta_data.first_name', $this->sortDirection)
                  ->select('wallets.*');
        } else {
            $query->orderBy($this->sortBy, $this->sortDirection);
        }

        return $query->paginate($this->perPage);
    }

    public function openTransactionModal($walletId, $type)
    {
        $this->selectedWallet = Wallet::with(['user.metaData', 'asset'])->findOrFail($walletId);
        $this->transactionType = $type;
        $this->showTransactionModal = true;
        $this->resetTransactionForm();
    }

    public function closeTransactionModal()
    {
        $this->showTransactionModal = false;
        $this->selectedWallet = null;
        $this->resetTransactionForm();
    }

    protected function resetTransactionForm()
    {
        $this->transactionAmount = '';
        $this->transactionDescription = '';
        $this->resetValidation();
    }

    public function processTransaction()
    {
        $this->validate([
            'transactionAmount' => 'required|numeric|min:0.01',
            'transactionDescription' => 'required|string|max:255',
        ], [], [
            'transactionAmount' => 'Amount',
            'transactionDescription' => 'Description',
        ]);

        try {
            $wallet = $this->selectedWallet;
            $amount = (float) $this->transactionAmount;
            $balanceBefore = $wallet->balance;

            // Calculate new balance
            if ($this->transactionType === 'credit') {
                $balanceAfter = $balanceBefore + $amount;
            } else {
                if ($balanceBefore < $amount) {
                    session()->flash('error', 'Insufficient balance for debit transaction.');
                    return;
                }
                $balanceAfter = $balanceBefore - $amount;
            }

            // Update wallet balance
            $wallet->update(['balance' => $balanceAfter]);

            // Create transaction record
            $wallet->transactions()->create([
                'amount' => $amount,
                'currency' => 'NGN',
                'status' => 'completed',
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'transaction_reference' => strtoupper($this->transactionType) . '-' . strtoupper(uniqid()),
                'transaction_type' => $this->transactionType,
                'transaction_description' => $this->transactionDescription,
                'transaction_date' => now(),
            ]);

            // Close modal
            $this->closeTransactionModal();

            // Refresh stats
            $this->dispatch('refreshWalletStats');

            // Clear cache
            $this->clearWalletCache();

            $actionText = $this->transactionType === 'credit' ? 'credited' : 'debited';
            session()->flash('success', "Wallet successfully {$actionText} with ₦" . number_format($amount, 2));

        } catch (\Exception $e) {
            session()->flash('error', 'Transaction failed. Please try again.');
        }
    }

    public function toggleWalletStatus($walletId)
    {
        try {
            $wallet = Wallet::findOrFail($walletId);
            $newStatus = $wallet->status === 'active' ? 'inactive' : 'active';
            $wallet->update(['status' => $newStatus]);

            $this->dispatch('refreshWalletStats');
            $this->clearWalletCache();

            session()->flash('success', "Wallet status changed to {$newStatus}");
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update wallet status.');
        }
    }

    private function clearWalletCache()
    {
        \Illuminate\Support\Facades\Cache::forget('wallet_stats.total');
        \Illuminate\Support\Facades\Cache::forget('wallet_stats.crypto');
        \Illuminate\Support\Facades\Cache::forget('wallet_stats.fiat');
        \Illuminate\Support\Facades\Cache::forget('wallet_stats.active');
        \Illuminate\Support\Facades\Cache::forget('wallet_stats.total_balance');
        \Illuminate\Support\Facades\Cache::forget('wallet_stats.transactions');
        \Illuminate\Support\Facades\Cache::forget('wallet_stats.avg_balance');
    }

    public function render()
    {
        $wallets = $this->getWallets();
        
        return view('livewire.admin.user-wallets-component', [
            'wallets' => $wallets,
        ]);
    }
}
