<?php

namespace App\Listeners;

use App\Events\NewUserCreated;
use App\Models\User;
use App\Models\UserMetaData;

class SetupUserAccount
{
    public User $user;

    /**
     * Create the event listener.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the event.
     */
    public function handle(NewUserCreated $event): void
    {
        // Create User Meta Data
        $user = $event->user;
        UserMetaData::create(['user_id' => $user->id, 'tag' => 'user' . $user->id]);
    }
}
