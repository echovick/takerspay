<?php

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
