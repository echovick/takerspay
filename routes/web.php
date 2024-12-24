<?php

use App\Http\Middleware\AdminUser;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Unguarded
Route::get('/', fn() => view('landing'))->name('landing');
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('forgot-password');
Route::get('/reset-password', fn() => view('auth.reset-password'))->name('reset-password');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', fn() => view('app.home'))->name('app.home');
    Route::get('/orders', fn() => view('app.all-orders'))->name('app.all-orders');
    Route::get('/wallets', fn() => view('app.wallets'))->name('app.wallets');
    Route::get('/order', fn() => view('app.order'))->name('app.order');
    Route::get('/settings', fn() => view('app.settings'))->name('app.settings');
    Route::get('/profile', fn() => view('app.profile'))->name('app.profile');

    Route::middleware([AdminUser::class])->prefix('tp-admin')->group(function () {
        Route::get('/', fn() => view('admin.dashboard'))->name('admin.dashboard');
        Route::get('/user-management', fn() => view('admin.user-management'))->name('admin.user-management');
        Route::get('/order-management', fn() => view('admin.order-management'))->name('admin.order-management');
        Route::get('/wallet-management', fn() => view('admin.wallet-management'))->name('admin.wallet-management');
        Route::get('/admin-management', fn() => view('admin.admin-management'))->name('admin.admin-management');
        Route::get('/asset-management', fn() => view('admin.asset-management'))->name('admin.asset-management');
        Route::get('/transaction-logs', fn() => view('admin.transaction-logs'))->name('admin.transaction-logs');
        Route::get('/reports', fn() => view('admin.reports'))->name('admin.reports');
        Route::get('/audit-trail', fn() => view('admin.audit-trail'))->name('admin.audit-trail');
        Route::get('/order', fn() => view('admin.order-detail'))->name('admin.order-details');
        Route::get('/settings', fn() => view('admin.settings'))->name('admin.settings');
    });
});

Route::get('/artisan/optimize', function () {
    Artisan::call('optimize:clear');
    return 'Application optimized successfully!';
});

Route::get('/artisan/storage-link', function () {
    Artisan::call('storage:link');
    return 'Symlink Created Successfully successfully!';
});

Route::get('/artisan/migrate', function () {
    Artisan::call('migrate');
    return 'Migrations executed successfully!';
});
