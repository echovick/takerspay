<?php
namespace App\Services;

use App\Models\User;
use App\Models\Wallet;

class WalletService
{
    public function createNewUserWallet(User $user, array $params): Wallet
    {
        if (isset($params['asset_id']) && $this->hasCyptoWallet($user, $params['asset_id'])) {
            throw new \Exception('You can not save mutiple wallets of the same type');
        }
        return Wallet::create($params);
    }

    public function hasCyptoWallet(User $user, string $assetId): bool
    {
        return Wallet::where('user_id', $user->id)->where('asset_id', $assetId)->exists();
    }

    public function deleteWallet(string $walletId): mixed
    {
        return Wallet::where('id', $walletId)->delete();
    }

    public function getWallet(string $walletId): ?Wallet
    {
        return Wallet::find($walletId);
    }

    public function updateWallet(string $walletId, array $params): mixed
    {
        return Wallet::where('id', $walletId)->update($params);
    }
}
