<?php
namespace App\Services;

use App\Constants\AssetType;
use App\Models\Asset;

class AssetService
{
    public function getAssets(AssetType $type = null)
    {
        if (!$type) {
            return Asset::all();
        }
        return Asset::where('type', $type)->get();
    }

    public function getAsset(string $assetId, AssetType $type = null): ?Asset
    {
        if(isset($type)){
            return Asset::where('id', $assetId)->where('type', $type)->first();
        }
        return Asset::find($assetId);
    }
}
