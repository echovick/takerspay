<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Livewire Component Registration
    |--------------------------------------------------------------------------
    |
    | List of custom Livewire components to be registered by the application.
    | This is particularly useful if you're using a custom namespace or path.
    |
    */

    'components' => [
        'admin.user-wallets-overview' => App\Http\Livewire\Admin\UserWalletsOverview::class,
        'admin.user-settings'         => App\Http\Livewire\Admin\UserSettings::class,
    ],
];
