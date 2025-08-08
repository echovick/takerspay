<?php
namespace App\Livewire\Admin;

use App\Models\Wallet;
use App\Models\User;
use App\Models\Asset;
use Illuminate\Validation\Rule;
use Livewire\Component;

class WalletManagementFilters extends Component
{
    public $search = '';
    public $typeFilter = '';
    public $statusFilter = '';
    public $showCreateWalletModal = false;
    
    // Create Wallet Form Properties
    public $selectedUserId = '';
    public $walletType = '';
    public $selectedAssetId = '';
    public $initialBalance = '';
    public $bankName = '';
    public $accountName = '';

    public function mount()
    {
        // Initialize component and dispatch initial filters
        $this->dispatchFilters();
    }

    protected function dispatchFilters()
    {
        $this->dispatch('filtersUpdated', [
            'search' => $this->search,
            'typeFilter' => $this->typeFilter,
            'statusFilter' => $this->statusFilter
        ]);
    }

    public function updatedSearch()
    {
        $this->dispatchFilters();
    }

    public function updatedTypeFilter()
    {
        $this->dispatchFilters();
    }

    public function updatedStatusFilter()
    {
        $this->dispatchFilters();
    }

    public function openCreateWalletModal()
    {
        $this->showCreateWalletModal = true;
        $this->resetForm();
    }

    public function closeCreateWalletModal()
    {
        $this->showCreateWalletModal = false;
        $this->resetForm();
    }

    protected function resetForm()
    {
        $this->selectedUserId = '';
        $this->walletType = '';
        $this->selectedAssetId = '';
        $this->initialBalance = '';
        $this->bankName = '';
        $this->accountName = '';
        $this->resetValidation();
    }

    protected function rules()
    {
        $rules = [
            'selectedUserId' => 'required|exists:users,id',
            'walletType' => 'required|in:crypto,fiat',
            'initialBalance' => 'required|numeric|min:0',
        ];

        if ($this->walletType === 'crypto') {
            $rules['selectedAssetId'] = 'required|exists:assets,id';
        } else {
            $rules['bankName'] = 'required|string|max:255';
            $rules['accountName'] = 'required|string|max:255';
        }

        return $rules;
    }

    protected function validationAttributes()
    {
        return [
            'selectedUserId' => 'User',
            'walletType' => 'Wallet Type',
            'selectedAssetId' => 'Asset',
            'initialBalance' => 'Initial Balance',
            'bankName' => 'Bank Name',
            'accountName' => 'Account Name',
        ];
    }

    public function createWallet()
    {
        $this->validate();

        try {
            $user = User::with('metaData')->findOrFail($this->selectedUserId);
            
            $walletData = [
                'user_id' => $this->selectedUserId,
                'type' => $this->walletType,
                'balance' => $this->initialBalance,
                'status' => 'active',
                'currency' => 'NGN',
                'assigned_at' => now(),
            ];

            if ($this->walletType === 'crypto') {
                $asset = Asset::findOrFail($this->selectedAssetId);
                $walletData['asset_id'] = $this->selectedAssetId;
                $walletData['crypto_wallet_number'] = $this->generateCryptoWalletNumber($asset->slug);
            } else {
                $walletData['bank_name'] = $this->bankName ?: 'FundsPadi';
                $walletData['account_name'] = $this->accountName;
                $walletData['account_number'] = $this->generateAccountNumber();
            }

            // Create the wallet
            $wallet = Wallet::create($walletData);

            // Log initial transaction if balance > 0
            if ($this->initialBalance > 0) {
                $wallet->transactions()->create([
                    'amount' => $this->initialBalance,
                    'currency' => 'NGN',
                    'status' => 'completed',
                    'balance_before' => 0,
                    'balance_after' => $this->initialBalance,
                    'transaction_reference' => 'INIT-' . strtoupper(uniqid()),
                    'transaction_type' => 'credit',
                    'transaction_description' => 'Initial wallet funding by admin',
                    'transaction_date' => now(),
                ]);
            }

            // Close modal and reset form
            $this->closeCreateWalletModal();

            // Refresh the wallets table and stats
            $this->dispatch('refreshWallets');
            $this->dispatch('refreshWalletStats');

            // Clear cache to ensure fresh data
            $this->clearWalletCache();

            // Show success message
            $firstName = $user->metaData->first_name ?? '';
            $lastName = $user->metaData->last_name ?? '';
            $userName = trim($firstName . ' ' . $lastName) ?: $user->email;
            session()->flash('success', 'Wallet created successfully for ' . $userName . '!');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create wallet. Please try again.');
        }
    }

    private function generateCryptoWalletNumber($assetSlug)
    {
        return strtoupper($assetSlug) . '-' . substr(md5(uniqid(mt_rand(), true)), 0, 8);
    }

    private function generateAccountNumber()
    {
        return '22' . str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
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
        $users = User::with('metaData')
            ->select('id', 'email')
            ->get()
            ->map(function ($user) {
                $firstName = $user->metaData->first_name ?? '';
                $lastName = $user->metaData->last_name ?? '';
                $user->display_name = trim($firstName . ' ' . $lastName) ?: $user->email;
                return $user;
            })
            ->sortBy('display_name');

        $assets = Asset::where('type', 'crypto')->select('id', 'name', 'slug')->orderBy('name')->get();

        return view('livewire.admin.wallet-management-filters', [
            'users' => $users,
            'assets' => $assets,
        ]);
    }
}