<?php
namespace App\Providers;

use App\Http\Livewire\Admin\UserSettings;
use App\Http\Livewire\Admin\UserWalletsOverview;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Livewire::component('admin.user-wallets-overview', UserWalletsOverview::class);
        Livewire::component('admin.user-settings', UserSettings::class);
    }
}
