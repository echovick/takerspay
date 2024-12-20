<?php

namespace App\Livewire\Admin;

use App\Models\Asset;
use App\Traits\AlertMessageHelper;
use Livewire\Component;

class AssetsTableComponent extends Component
{
    use AlertMessageHelper;

    public $cryptoAssets;
    public $giftcards;
    public $name;
    public $slug;
    public $type;
    public $available_units;
    public $naira_buy_rate;
    public $naira_sell_rate;
    public $asset;

    public function mount()
    {
        $this->cryptoAssets = Asset::where('type', 'crypto')->get();
        $this->giftcards = Asset::where('type', 'giftcard')->get();
    }

    public function selectAsset(string $assetId)
    {
        $this->asset = Asset::find($assetId);
        $this->name = $this->asset->name;
        $this->slug = $this->asset->slug;
        $this->type = $this->asset->type;
        $this->available_units = $this->asset->available_units;
        $this->naira_buy_rate = $this->asset->naira_buy_rate;
        $this->naira_sell_rate = $this->asset->naira_sell_rate;
    }

    public function updateAsset()
    {
        $asset = Asset::find($this->asset->id);
        $asset->name = $this->name ?? $asset->name;
        $asset->slug = $this->slug ?? $asset->slug;
        $asset->type = $this->type ?? $asset->type;
        $asset->available_units = $this->available_units ?? $asset->available_units;
        $asset->naira_buy_rate = $this->naira_buy_rate ?? $asset->naira_buy_rate;
        $asset->naira_sell_rate = $this->naira_sell_rate ?? $asset->naira_sell_rate;
        $asset->save();
        $this->setMessage('successMsg', "Asset Updated Successfully");
    }

    public function deleteAsset(string $assetId)
    {
        $asset = Asset::find($assetId);
        $asset->delete();
        $this->setMessage('successMsg', "Asset Deleted Successfully");
    }

    public function createAsset()
    {
        $asset = new Asset();
        $asset->name = $this->name;
        $asset->slug = $this->slug;
        $asset->type = $this->type;
        $asset->available_units = $this->available_units;
        $asset->naira_buy_rate = $this->naira_buy_rate;
        $asset->naira_sell_rate = $this->naira_sell_rate;
        $asset->save();
        $this->setMessage('successMsg', "Asset Created Successfully");
    }

    public function render()
    {
        return view('livewire.admin.assets-table-component');
    }
}
