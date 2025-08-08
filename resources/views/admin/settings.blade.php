@extends('layout.app')

@section('content')
    @include('admin.includes.nav-bar')
    @include('admin.includes.side-bar')

    <!-- Main Content - Mobile Optimized -->
    <main class="p-[25px] md:ml-60 pt-[100px] bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Page Header - Simplified -->
            <div class="mb-6">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Settings</h1>
                <p class="text-sm text-gray-600 mt-1">Configure system settings and preferences</p>
            </div>

            <!-- Settings Tabs -->
            <div class="mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px overflow-x-auto whitespace-nowrap" aria-label="Tabs">
                            <button class="px-6 py-4 text-sm font-medium text-blue-600 border-b-2 border-blue-500">
                                Account & Wallet Settings
                            </button>
                            <button class="px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent">
                                Users Management
                            </button>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Settings Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Crypto Wallet Settings -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-900">Crypto Wallet Settings</h3>
                    </div>
                    <div class="p-4">
                        <livewire:wallet.crypto-wallet-component />
                    </div>
                </div>

                <!-- Fiat Wallet Settings -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-900">Fiat Wallet Settings</h3>
                    </div>
                    <div class="p-4">
                        <livewire:wallet.fiat-wallet-component />
                    </div>
                </div>

                <!-- System Configuration -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <h3 class="text-sm font-semibold text-gray-900">System Configuration</h3>
                        </div>
                        <div class="p-4">
                            <div class="text-center text-gray-500 py-8">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <p class="text-sm">System configuration settings will be displayed here</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection