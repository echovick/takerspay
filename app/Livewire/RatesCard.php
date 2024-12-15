<?php

namespace App\Livewire;

use App\Constants\AssetType;
use App\Services\AssetService;
use Livewire\Component;

class RatesCard extends Component
{
    public $cryptoAssets;
    public $giftcardAssets;

    protected AssetService $assetService;

    public function boot(AssetService $assetService)
    {
        $this->assetService = $assetService;
    }

    public function mount()
    {
        $this->cryptoAssets = $this->assetService->getAssets(AssetType::CRYPTO);
        $this->giftcardAssets = $this->assetService->getAssets(AssetType::GIFT_CARD);
    }

    public function render()
    {
        return view('livewire.rates-card');
    }
}
