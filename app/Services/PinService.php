<?php
namespace App\Services;

use App\Models\Pin;
use App\Models\User;

class PinService
{
    public function newUserPin(User $user, string $pin)
    {
        return Pin::create([
            'user_id' => $user->id,
            'pin' => $pin,
        ]);
    }
}
