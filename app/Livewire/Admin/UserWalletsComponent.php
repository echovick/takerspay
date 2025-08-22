<?php
namespace App\Livewire\Admin;

use App\Models\Wallet;
use Livewire\Component;
use Livewire\WithPagination;

class UserWalletsComponent extends Component
{
    use WithPagination;

    public $activeTab     = 'fiat';
    public $search        = '';
    public $typeFilter    = '';
    public $statusFilter  = '';
    public $perPage       = 10;
    public $sortBy        = 'created_at';
    public $sortDirection = 'desc';

    // Credit/Debit Modal Properties
    public $showTransactionModal   = false;
    public $selectedWallet         = null;
    public $transactionType        = '';
    public $transactionAmount      = '';
    public $transactionDescription = '';

    protected $listeners = ['filtersUpdated' => 'updateFilters', 'refreshWallets' => '$refresh'];

    public function mount()
    {
        \Log::info('UserWalletsComponent: Component mounted', [
            'initial_active_tab' => $this->activeTab,
            'initial_per_page' => $this->perPage,
            'user_id' => auth()->id(),
            'session_id' => session()->getId()
        ]);
    }

    public function setActiveTab($tab)
    {
        \Log::info('UserWalletsComponent: setActiveTab called', [
            'previous_tab' => $this->activeTab,
            'new_tab' => $tab,
            'session_id' => session()->getId()
        ]);
        
        $this->activeTab = $tab;
        $this->resetPage();
        
        \Log::info('UserWalletsComponent: Tab changed successfully', [
            'current_tab' => $this->activeTab
        ]);
    }

    public function updateFilters($filters)
    {
        $this->search       = $filters['search'] ?? '';
        $this->typeFilter   = $filters['typeFilter'] ?? '';
        $this->statusFilter = $filters['statusFilter'] ?? '';
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy        = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function getWallets()
    {
        \Log::info('UserWalletsComponent: getWallets called', [
            'active_tab' => $this->activeTab,
            'search' => $this->search,
            'type_filter' => $this->typeFilter,
            'status_filter' => $this->statusFilter,
            'sort_by' => $this->sortBy,
            'sort_direction' => $this->sortDirection,
            'per_page' => $this->perPage
        ]);

        $query = Wallet::with(['user.metaData', 'asset']);

        // Filter by active tab
        if ($this->activeTab === 'crypto') {
            $query->where('type', 'crypto');
            \Log::info('UserWalletsComponent: Filtering for crypto wallets');
        } elseif ($this->activeTab === 'fiat') {
            $query->where('type', 'nuban');
            \Log::info('UserWalletsComponent: Filtering for nuban wallets');
        }

        // Apply search filter
        if (! empty($this->search)) {
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

        $results = $query->paginate($this->perPage);
        
        // Log detailed wallet data for debugging
        $walletsData = [];
        foreach ($results->take(3) as $wallet) { // Log first 3 wallets for inspection
            $walletsData[] = [
                'id' => $wallet->id,
                'type' => $wallet->type,
                'status' => $wallet->status,
                'user_id' => $wallet->user_id,
                'has_user' => !is_null($wallet->user),
                'has_user_metadata' => !is_null($wallet->user) && !is_null($wallet->user->metaData),
                'has_asset' => !is_null($wallet->asset),
                'balance' => $wallet->balance,
                'currency' => $wallet->currency,
                'account_number' => $wallet->account_number,
                'crypto_wallet_number' => $wallet->crypto_wallet_number
            ];
        }

        \Log::info('UserWalletsComponent: getWallets results', [
            'total_results' => $results->total(),
            'current_page_count' => $results->count(),
            'has_results' => $results->count() > 0,
            'first_wallet_id' => $results->count() > 0 ? $results->first()->id : null,
            'sql_query' => $query->toSql(),
            'sql_bindings' => $query->getBindings(),
            'sample_wallets_data' => $walletsData
        ]);

        return $results;
    }

    public function openTransactionModal($walletId, $type)
    {
        \Log::info('UserWalletsComponent: openTransactionModal called', [
            'wallet_id' => $walletId,
            'transaction_type' => $type,
            'active_tab' => $this->activeTab,
            'user_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'session_id' => session()->getId()
        ]);

        try {
            $this->selectedWallet = Wallet::with(['user.metaData', 'asset'])->findOrFail($walletId);
            
            \Log::info('UserWalletsComponent: Wallet found successfully', [
                'wallet_id' => $walletId,
                'wallet_type' => $this->selectedWallet->type,
                'wallet_status' => $this->selectedWallet->status,
                'user_id' => $this->selectedWallet->user_id,
                'balance' => $this->selectedWallet->balance
            ]);

            $this->transactionType      = $type;
            $this->showTransactionModal = true;
            $this->resetTransactionForm();

            \Log::info('UserWalletsComponent: Modal state updated', [
                'showTransactionModal' => $this->showTransactionModal,
                'transactionType' => $this->transactionType
            ]);

        } catch (\Exception $e) {
            \Log::error('UserWalletsComponent: Error opening transaction modal', [
                'wallet_id' => $walletId,
                'transaction_type' => $type,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            session()->flash('error', 'Failed to open transaction modal: ' . $e->getMessage());
        }
    }

    public function closeTransactionModal()
    {
        $this->showTransactionModal = false;
        $this->selectedWallet       = null;
        $this->resetTransactionForm();
    }

    protected function resetTransactionForm()
    {
        $this->transactionAmount      = '';
        $this->transactionDescription = '';
        $this->resetValidation();
    }

    public function processTransaction()
    {
        \Log::info('UserWalletsComponent: processTransaction called', [
            'transaction_amount' => $this->transactionAmount,
            'transaction_type' => $this->transactionType,
            'transaction_description' => $this->transactionDescription,
            'selected_wallet_id' => $this->selectedWallet ? $this->selectedWallet->id : null,
            'show_modal' => $this->showTransactionModal
        ]);

        $this->validate([
            'transactionAmount'      => 'required|numeric|min:0.01',
            'transactionDescription' => 'required|string|max:255',
        ], [], [
            'transactionAmount'      => 'Amount',
            'transactionDescription' => 'Description',
        ]);

        \Log::info('UserWalletsComponent: Validation passed');

        try {
            $wallet        = $this->selectedWallet;
            $amount        = (float) $this->transactionAmount;
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
                'amount'                  => $amount,
                'currency'                => 'NGN',
                'status'                  => 'completed',
                'balance_before'          => $balanceBefore,
                'balance_after'           => $balanceAfter,
                'transaction_reference'   => strtoupper($this->transactionType) . '-' . strtoupper(uniqid()),
                'transaction_type'        => $this->transactionType,
                'transaction_description' => $this->transactionDescription,
                'transaction_date'        => now(),
            ]);

            // Close modal
            $this->closeTransactionModal();

            // Refresh stats
            $this->dispatch('refreshWalletStats');

            // Clear cache
            $this->clearWalletCache();

            $actionText = $this->transactionType === 'credit' ? 'credited' : 'debited';
            session()->flash('success', "Wallet successfully {$actionText} with ₦" . number_format($amount, 2));

            \Log::info('UserWalletsComponent: Transaction completed successfully', [
                'wallet_id' => $wallet->id,
                'amount' => $amount,
                'action' => $actionText,
                'new_balance' => $balanceAfter
            ]);

        } catch (\Exception $e) {
            \Log::error('UserWalletsComponent: Transaction failed', [
                'wallet_id' => $this->selectedWallet ? $this->selectedWallet->id : null,
                'amount' => $this->transactionAmount,
                'type' => $this->transactionType,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            session()->flash('error', 'Transaction failed. Please try again.');
        }
    }

    public function toggleWalletStatus($walletId)
    {
        try {
            $wallet    = Wallet::findOrFail($walletId);
            $newStatus = $wallet->status === 'active' ? 'inactive' : 'active';
            $wallet->update(['status' => $newStatus]);

            $this->dispatch('refreshWalletStats');
            $this->clearWalletCache();

            session()->flash('success', "Wallet status changed to {$newStatus}");
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update wallet status.');
        }
    }

    public function editWallet($walletId)
    {
        try {
            $wallet = Wallet::findOrFail($walletId);
            // For now, we'll just show a success message
            // In a full implementation, this would open an edit modal
            session()->flash('success', 'Edit functionality - Coming soon!');
            
            \Log::info('UserWalletsComponent: Edit wallet requested', [
                'wallet_id' => $walletId,
                'wallet_type' => $wallet->type
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to edit wallet.');
            \Log::error('UserWalletsComponent: Edit wallet failed', [
                'wallet_id' => $walletId,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function deleteWallet($walletId)
    {
        try {
            $wallet = Wallet::findOrFail($walletId);
            
            // Check if wallet has any transactions before deleting
            if ($wallet->transactions()->count() > 0) {
                session()->flash('error', 'Cannot delete wallet with existing transactions.');
                return;
            }
            
            $wallet->delete();
            
            $this->dispatch('refreshWalletStats');
            $this->clearWalletCache();
            
            session()->flash('success', 'Crypto wallet deleted successfully.');
            
            \Log::info('UserWalletsComponent: Wallet deleted successfully', [
                'wallet_id' => $walletId,
                'wallet_type' => $wallet->type
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete wallet.');
            \Log::error('UserWalletsComponent: Delete wallet failed', [
                'wallet_id' => $walletId,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function clearWalletCache()
    {
        \Illuminate\Support\Facades\Cache::forget('wallet_stats.total');
        \Illuminate\Support\Facades\Cache::forget('wallet_stats.crypto');
        \Illuminate\Support\Facades\Cache::forget('wallet_stats.nuban');
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
