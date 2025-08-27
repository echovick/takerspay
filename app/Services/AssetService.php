<?php
namespace App\Services;

use App\Constants\AssetType;
use App\Models\Asset;

class AssetService
{
    public function getAssets(AssetType $type = null, bool $activeOnly = true)
    {
        $query = Asset::query();
        
        if ($activeOnly) {
            $query->where('is_active', true);
        }
        
        if ($type) {
            $query->where('type', $type);
        }
        
        return $query->get();
    }

    public function getAsset(string $assetId, AssetType $type = null): ?Asset
    {
        if(isset($type)){
            return Asset::where('id', $assetId)->where('type', $type)->first();
        }
        return Asset::find($assetId);
    }
}
