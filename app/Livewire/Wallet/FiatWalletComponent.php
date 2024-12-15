<?php

namespace App\Livewire\Wallet;

use App\Services\AssetService;
use App\Services\WalletService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FiatWalletComponent extends Component
{
    public $fiatWallets;
    public $fiatAssets;
    public $walletTypeId;
    public $selectedAccount;
    public $accountNumber;
    public $bankName;
    public $accountName;
    public $user;
    public $errorMsg = '';
    public $successMsg = '';

    protected AssetService $assetService;
    protected WalletService $walletService;

    public function boot(
        AssetService $assetService,
        WalletService $walletService
    ) {
        $this->user = Auth::user();
        $this->assetService = $assetService;
        $this->walletService = $walletService;
        $this->initialiseComponentData();
    }

    public function mount()
    {
        $this->initialiseComponentData();
    }

    public function initialiseComponentData()
    {
        $this->clearAlerts();
        $this->fiatWallets = $this->user->fiatWallets();
    }

    public function addBankAccount()
    {
        $data = [
            'user_id' => $this->user->id,
            'type' => 'fiat',
            'account_number' => $this->accountNumber,
            'bank_name' => $this->bankName,
            'account_name' => $this->accountName,
        ];
        try {
            $this->walletService->createNewUserWallet($this->user, $data);
            $this->initialiseComponentData();
            $this->clearAttributes();
            $this->successMsg = 'New Bank Account Created Successfully';
        } catch (\Exception $e) {
            $this->errorMsg = $e->getMessage();
        }
    }

    public function deleteWallet(string $walletId)
    {
        try {
            $this->walletService->deleteWallet($walletId);
            $this->initialiseComponentData();
            $this->successMsg = 'Bank Account Deleted Successfully';
        } catch (\Exception $e) {
            $this->errorMsg = $e->getMessage();
        }
    }

    public function selectWallet(string $walletId)
    {
        $this->selectedAccount = $this->walletService->getWallet($walletId);
        $this->accountNumber = $this->selectedAccount->account_number;
        $this->bankName = $this->selectedAccount->bank_name;
        $this->accountName = $this->selectedAccount->account_name;
    }

    public function updateBankAccount()
    {
        try {
            $this->walletService->updateWallet($this->selectedAccount->id, [
                'account_number' => $this->accountNumber,
                'bank_name' => $this->bankName,
                'account_name' => $this->accountName,
            ]);
            $this->initialiseComponentData();
            $this->clearAttributes();
            $this->successMsg = 'Crypto Wallet Updated Successfully Successfully';
        } catch (\Exception $e) {
            $this->errorMsg = $e->getMessage();
        }
    }

    public function clearAttributes()
    {
        $this->walletTypeId = '';
        $this->accountNumber = '';
        $this->bankName = '';
        $this->accountName = '';
    }

    public function clearAlerts()
    {
        $this->successMsg = '';
        $this->errorMsg = '';
    }

    public function render()
    {
        return view('livewire.wallet.fiat-wallet-component');
    }
}
