@extends('layout.app')

@section('content')
    @include('admin.includes.nav-bar')

    <!-- Sidebar -->
    @include('admin.includes.side-bar')

    <!-- Content Area -->
    <main class="p-4 md:ml-64 h-auto pt-20">
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile"
                        type="button" role="tab" aria-controls="profile" aria-selected="false">Account & Wallet
                        Settings</button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                        aria-controls="dashboard" aria-selected="false">Users Management</button>
                </li>
            </ul>
        </div>
        <div id="default-tab-content">
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel"
                aria-labelledby="profile-tab">
                {{-- Crypto Wallet Component --}}
                <livewire:wallet.crypto-wallet-component />

                {{-- Fiat Wallet Component --}}
                <livewire:wallet.fiat-wallet-component />
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel"
                aria-labelledby="dashboard-tab">
                <x-alerts.info-alert> Module Under Development! </x-alerts.info-alert>
            </div>
        </div>
    </main>
@endsection
