<?php

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
});

Route::get('/artisan/optimize', function () {
    Artisan::call('optimize');
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
