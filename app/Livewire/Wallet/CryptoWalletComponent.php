<?php

namespace App\Livewire\Wallet;

use App\Constants\AssetType;
use App\Services\AssetService;
use App\Services\WalletService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CryptoWalletComponent extends Component
{
    public $cryptoWallets;
    public $cryptoAssets;
    public $walletTypeId;
    public $selectedWallet;
    public $walletAddress;
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
        $this->cryptoWallets = $this->user->cryptoWallets();
        $this->cryptoAssets = $this->assetService->getAssets(AssetType::CRYPTO);
    }

    public function addCryptoWallet()
    {
        $data = [
            'user_id' => $this->user->id,
            'type' => 'crypto',
            'asset_id' => $this->walletTypeId,
            'crypto_wallet_number' => $this->walletAddress,
        ];
        try {
            $this->walletService->createNewUserWallet($this->user, $data);
            $this->initialiseComponentData();
            $this->clearAttributes();
            $this->successMsg = 'New Crypto Wallet Created Successfully';
        } catch (\Exception $e) {
            $this->errorMsg = $e->getMessage();
        }
    }

    public function deleteWallet(string $walletId)
    {
        try {
            $this->walletService->deleteWallet($walletId);
            $this->initialiseComponentData();
            $this->clearAttributes();
            $this->successMsg = 'Crypto Wallet Deleted Successfully';
        } catch (\Exception $e) {
            $this->errorMsg = $e->getMessage();
        }
    }

    public function selectWallet(string $walletId)
    {
        $this->selectedWallet = $this->walletService->getWallet($walletId);
        $this->walletTypeId = $this->selectedWallet?->asset_id;
        $this->walletAddress = $this->selectedWallet?->crypto_wallet_number;
    }

    public function updateCryptoWallet()
    {
        try {
            $this->walletService->updateWallet($this->selectedWallet->id, ['crypto_wallet_number' => $this->walletAddress]);
            $this->initialiseComponentData();
            $this->successMsg = 'Crypto Wallet Updated Successfully Successfully';
        } catch (\Exception $e) {
            $this->errorMsg = $e->getMessage();
        }
    }

    public function clearAttributes()
    {
        $this->walletTypeId = '';
        $this->walletAddress = '';
    }

    public function clearAlerts()
    {
        $this->successMsg = '';
        $this->errorMsg = '';
    }

    public function render()
    {
        return view('livewire.wallet.crypto-wallet-component');
    }
}
