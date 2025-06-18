@extends('layout.app')

@section('content')
    <!-- Add Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    @include('admin.includes.nav-bar')

    <!-- Sidebar -->
    @include('admin.includes.side-bar')

    @php

        $userId = request()->segment(3);
        $user = App\Models\User::find($userId);
        $kycStatus = $user->metaData->kycVerified ?? 'Not Verified';

        // Get wallet information by type
        $fiatWallet = $user->wallets()->where('type', 'fiat')->first();
        $cryptoWallet = $user->wallets()->where('type', 'crypto')->first();
        $nubanWallet = $user->wallets()->where('type', 'nuban')->first();

        // Count app-specific data
        $cryptoOrderCount = $user->orders()->count();
        $transactionCount = App\Models\Transaction::whereHas('wallet', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->count();

        $bankAccountCount = App\Models\BankAccount::where('user_id', $userId)->count();
        $ticketCount = App\Models\Ticket::where('user_id', $userId)->count();

        // Get current active tab
        $activeTab = request()->get('tab', 'overview');
    @endphp

    <!-- Modal Backdrop -->
    <div id="modal-backdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 z-40 hidden"></div>
    <!-- Mobile-optimized Content Area with web compatibility -->
    <main class="p-2 md:p-4 md:ml-64 h-auto pt-20 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="container mx-auto max-w-7xl">
            <!-- User Details Header - Redesigned -->
            <div class="bg-white rounded-xl shadow-lg mb-8 overflow-hidden animate__animated animate__fadeIn">
                <!-- Header with proper sizing and styling -->
                <div class="relative overflow-hidden">
                    <!-- Background with proper gradient and height -->
                    <div class="h-40 bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600">
                        <!-- Decorative elements properly positioned -->
                        <div class="absolute top-5 right-10 h-24 w-24 rounded-full bg-white opacity-10"></div>
                        <div class="absolute bottom-5 left-20 h-32 w-32 rounded-full bg-white opacity-5"></div>
                        <div class="absolute -bottom-16 -right-8 h-48 w-48 rounded-full bg-indigo-500 opacity-10"></div>
                    </div>

                    <!-- User avatar with proper styling and positioning -->
                    <div class="absolute left-8 -bottom-10">
                        <div class="rounded-xl bg-white p-1.5 shadow-lg ring-4 ring-white/50">
                            <div
                                class="h-20 w-20 md:h-24 md:w-24 rounded-lg bg-gradient-to-tr from-blue-500 to-indigo-600 flex items-center justify-center overflow-hidden">
                                @php
                                    // Generate initials from user's name
$firstName = $user->metaData?->first_name ?? '';
$lastName = $user->metaData?->last_name ?? '';

// Default to email if name not available
if (empty($firstName) && empty($lastName)) {
    $parts = explode('@', $user->email ?? '');
    $nameFromEmail = $parts[0] ?? '';
    $nameParts = preg_split('/[^a-zA-Z0-9]/', $nameFromEmail);
    $firstName = $nameParts[0] ?? '';
    $lastName = $nameParts[count($nameParts) - 1] ?? '';
}

// Get the first letter of first name and last name
$firstInitial = strtoupper(substr($firstName, 0, 1));
$lastInitial = strtoupper(substr($lastName, 0, 1));

// Combine the initials
$initials = $firstInitial . $lastInitial;

// If we couldn't get 2 initials, use first 2 letters of whatever we have
                                    if (strlen($initials) < 2) {
                                        $initials = strtoupper(substr($firstName . $lastName . $user->email, 0, 2));
                                    }
                                @endphp
                                <span class="text-white text-2xl md:text-3xl font-bold">{{ $initials }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Content section with proper spacing -->
                <div class="pt-14 pb-6 px-8">
                    <div class="flex flex-col lg:flex-row lg:items-end justify-between">
                        <!-- User info with proper spacing and responsive layout -->
                        <div class="ml-0 md:ml-20">
                            <div class="flex flex-wrap items-center gap-3">
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $user->metaData?->first_name }}
                                    {{ $user->metaData?->last_name }}</h1>

                                <!-- Status badge with proper styling -->
                                @if ($kycStatus == 'Verified')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        <svg class="h-2.5 w-2.5 mr-1.5 text-green-500" fill="currentColor"
                                            viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Verified
                                    </span>
                                @elseif($kycStatus == 'Pending')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        <svg class="h-2.5 w-2.5 mr-1.5 text-yellow-500" fill="currentColor"
                                            viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Pending
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                        <svg class="h-2.5 w-2.5 mr-1.5 text-gray-500" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Not Verified
                                    </span>
                                @endif
                            </div>

                            <!-- User metadata with better responsive layout -->
                            <div class="flex flex-wrap gap-y-2 gap-x-4 mt-3">
                                <div class="inline-flex items-center text-sm text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $user->email }}
                                </div>
                                <div class="inline-flex items-center text-sm text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Joined {{ $user->created_at->format('M d, Y') }}
                                </div>
                                <div class="inline-flex items-center text-sm text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                    ID: {{ $user->id }}
                                </div>
                            </div>
                        </div>

                        <!-- Action buttons with better styling -->
                        <div class="mt-4 lg:mt-0 flex flex-wrap gap-2">
                            <button type="button" id="open-deposit-modal"
                                class="inline-flex items-center px-3.5 py-2 text-sm font-medium rounded-lg text-white bg-indigo-600 shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Deposit
                            </button>
                            <button type="button" id="open-withdraw-modal"
                                class="inline-flex items-center px-3.5 py-2 text-sm font-medium rounded-lg text-white bg-emerald-600 shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Withdraw
                            </button>
                            <button type="button" id="open-transfer-modal"
                                class="inline-flex items-center px-3.5 py-2 text-sm font-medium rounded-lg text-white bg-blue-600 shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                                Transfer
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- App Context Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 animate__animated animate__fadeIn animate__delay-1s">
                <!-- Crypto & Gift Card App Card -->
                <div class="bg-white rounded-lg shadow-md border border-indigo-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4 border-b">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-white/20 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h2 class="ml-3 text-lg font-medium text-white">Crypto & Gift Card App</h2>
                            </div>
                            <a href="{{ route('admin.user-details', ['id' => $user->id, 'tab' => 'crypto']) }}"
                                class="text-white text-sm hover:underline">
                                View Details
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Crypto Wallet Balance</p>
                                <p class="text-xl font-bold text-gray-800">
                                    {{ $cryptoWallet ? number_format($cryptoWallet->balance, 2) . ' ' . ($cryptoWallet->currency ?? 'BTC') : '0.00 BTC' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Fiat Wallet Balance</p>
                                <p class="text-xl font-bold text-gray-800">
                                    {{ $fiatWallet ? number_format($fiatWallet->balance, 2) . ' ' . ($fiatWallet->currency ?? 'USD') : '0.00 USD' }}
                                </p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm font-medium text-gray-500">Orders</p>
                                <p class="text-xl font-bold text-gray-800">{{ number_format($cryptoOrderCount) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial App Card -->
                <div class="bg-white rounded-lg shadow-md border border-green-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4 border-b">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-white/20 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                <h2 class="ml-3 text-lg font-medium text-white">Financial App</h2>
                            </div>
                            <a href="{{ route('admin.user-details', ['id' => $user->id, 'tab' => 'finance']) }}"
                                class="text-white text-sm hover:underline">
                                View Details
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">NUBAN Wallet Balance</p>
                                <p class="text-xl font-bold text-gray-800">
                                    {{ $nubanWallet ? number_format($nubanWallet->balance, 2) . ' ' . ($nubanWallet->currency ?? 'NGN') : '0.00 NGN' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Transactions</p>
                                <p class="text-xl font-bold text-gray-800">{{ number_format($transactionCount) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Bank Accounts</p>
                                <p class="text-xl font-bold text-gray-800">{{ number_format($bankAccountCount) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Support Tickets</p>
                                <p class="text-xl font-bold text-gray-800">{{ number_format($ticketCount) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="bg-white rounded-lg shadow-md mb-6 animate__animated animate__fadeIn animate__delay-2s">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px overflow-x-auto whitespace-nowrap" aria-label="Tabs">
                        <a href="{{ route('admin.user-details', ['id' => $user->id, 'tab' => 'overview']) }}"
                            class="px-6 py-4 text-sm font-medium {{ $activeTab == 'overview' ? 'text-indigo-600 border-b-2 border-indigo-500' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent' }}">
                            Overview
                        </a>
                        <a href="{{ route('admin.user-details', ['id' => $user->id, 'tab' => 'crypto']) }}"
                            class="px-6 py-4 text-sm font-medium {{ $activeTab == 'crypto' ? 'text-indigo-600 border-b-2 border-indigo-500' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent' }}">
                            Crypto & Gift Cards
                        </a>
                        <a href="{{ route('admin.user-details', ['id' => $user->id, 'tab' => 'finance']) }}"
                            class="px-6 py-4 text-sm font-medium {{ $activeTab == 'finance' ? 'text-indigo-600 border-b-2 border-indigo-500' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent' }}">
                            Financial App
                        </a>
                        <a href="{{ route('admin.user-details', ['id' => $user->id, 'tab' => 'wallets']) }}"
                            class="px-6 py-4 text-sm font-medium {{ $activeTab == 'wallets' ? 'text-indigo-600 border-b-2 border-indigo-500' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent' }}">
                            Wallets
                        </a>
                        <a href="{{ route('admin.user-details', ['id' => $user->id, 'tab' => 'settings']) }}"
                            class="px-6 py-4 text-sm font-medium {{ $activeTab == 'settings' ? 'text-indigo-600 border-b-2 border-indigo-500' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent' }}">
                            Settings
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="animate__animated animate__fadeIn animate__delay-3s">
                <!-- Content based on active tab -->
                @if ($activeTab == 'overview')
                    <!-- Overview content -->
                    <livewire:admin.user-overview :user="$user" />
                @elseif($activeTab == 'crypto')
                    <!-- Crypto & Gift Card App content -->
                    <livewire:admin.user-crypto-overview :user="$user" />
                @elseif($activeTab == 'finance')
                    <!-- Financial App content -->
                    <livewire:admin.user-finance-overview :user="$user" />
                @elseif($activeTab == 'wallets')
                    <!-- Wallets content -->
                    <livewire:admin.user-wallets-overview :user="$user" />
                @elseif($activeTab == 'settings')
                    <!-- Settings content -->
                    <livewire:admin.user-settings :user="$user" />
                @endif
            </div>

            <!-- Legacy content below - to be removed after Livewire components are created -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 animate__animated animate__fadeIn animate__delay-1s"
                style="display: none;">
                <div
                    class="bg-white rounded-lg shadow-md p-5 border-l-4 border-indigo-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="bg-indigo-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Wallet Balance</h3>
                            <p class="text-xl font-bold text-gray-900">
                                {{ $fiatWallet ? number_format($fiatWallet->balance, 2) . ' ' . ($fiatWallet->currency ?? 'USD') : '0.00 USD' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-lg shadow-md p-5 border-l-4 border-green-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">KYC Status</h3>
                            <p class="text-xl font-bold text-gray-900">{{ $kycStatus }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-lg shadow-md p-5 border-l-4 border-purple-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="bg-purple-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Member Since</h3>
                            <p class="text-xl font-bold text-gray-900">{{ $user->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- JavaScript for Modal and Livewire Integration -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal control elements
            const modalBackdrop = document.getElementById('modal-backdrop');
            const depositModal = document.getElementById('deposit-modal');
            const withdrawModal = document.getElementById('withdraw-modal');
            const transferModal = document.getElementById('transfer-modal');

            // Buttons to open modals
            const depositBtn = document.getElementById('open-deposit-modal');
            const withdrawBtn = document.getElementById('open-withdraw-modal');
            const transferBtn = document.getElementById('open-transfer-modal');

            // All close buttons
            const closeButtons = document.querySelectorAll('.close-modal');

            // Livewire event handling for successful operations
            window.addEventListener('wallet-operation-completed', event => {
                closeAllModals();

                // Optionally scroll to the success message
                if (document.getElementById('success-message')) {
                    document.getElementById('success-message').scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });

            // Open deposit modal
            depositBtn.addEventListener('click', function() {
                // Scroll to Livewire component's deposit form
                const depositForm = document.querySelector('[wire\\:submit\\.prevent="deposit"]');
                if (depositForm) {
                    depositForm.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });

            // Open transfer modal
            transferBtn.addEventListener('click', function() {
                // Scroll to Livewire component's transfer form
                const transferForm = document.querySelector('[wire\\:submit\\.prevent="transfer"]');
                if (transferForm) {
                    transferForm.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });

            // Close any open modal when clicking close buttons
            closeButtons.forEach(function(button) {
                button.addEventListener('click', closeAllModals);
            });

            // Close modals when clicking backdrop
            modalBackdrop.addEventListener('click', closeAllModals);

            // Function to close all modals
            function closeAllModals() {
                modalBackdrop.classList.add('hidden');
                depositModal.classList.add('hidden');
                withdrawModal.classList.add('hidden');
                transferModal.classList.add('hidden');
            }
        });
    </script>
@endsection
