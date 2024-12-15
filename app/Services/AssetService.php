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
}
