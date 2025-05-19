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
        $wallet = $user->wallet ?? null;
        $kycStatus = $user->kyc_status ?? 'Not Verified';
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white drop-shadow"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
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
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $user->name }}</h1>

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

            <!-- Quick Stats Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 animate__animated animate__fadeIn animate__delay-1s">
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
                                {{ $wallet ? number_format($wallet->balance, 2) . ' ' . ($wallet->currency ?? 'USD') : '0.00 USD' }}
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

            <!-- Personal Information Card -->
            <div
                class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 mb-6 overflow-hidden border border-gray-100 animate__animated animate__fadeIn">
                <div class="bg-gradient-to-r from-gray-50 to-indigo-50 border-b border-gray-200">
                    <div class="px-4 py-5 sm:px-6 flex items-center">
                        <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Personal Information</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">User profile and contact details.</p>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Full name</dt>
                            <dd class="mt-1 text-base font-semibold text-gray-900">{{ $user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email address</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone number</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $user->phone ?? 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Registration date</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $user->created_at->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">User ID</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $user->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">KYC Status</dt>
                            <dd class="mt-1 text-base text-gray-900">
                                @if ($kycStatus == 'Verified')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor"
                                            viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Verified
                                    </span>
                                @elseif($kycStatus == 'Pending')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor"
                                            viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Pending
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-gray-400" fill="currentColor"
                                            viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Not Verified
                                    </span>
                                @endif
                            </dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wallet Details Card -->
            <div
                class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 mb-6 overflow-hidden border border-gray-100 animate__animated animate__fadeIn animate__delay-1s">
                <div class="bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200">
                    <div class="px-4 py-5 sm:px-6 flex items-center">
                        <div class="bg-blue-100 p-2 rounded-lg mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Wallet Details</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">User's wallet information and balance.</p>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    @if ($wallet)
                        <div class="flex flex-col md:flex-row md:items-center mb-6">
                            <div
                                class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg p-4 md:p-6 shadow-lg flex-1 md:mr-6 mb-4 md:mb-0 transform transition-all duration-500 hover:scale-105 relative overflow-hidden">
                                <div
                                    class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white bg-opacity-10 rounded-full">
                                </div>
                                <div
                                    class="absolute bottom-0 left-0 -mb-4 -ml-4 w-16 h-16 bg-white bg-opacity-10 rounded-full">
                                </div>
                                <p class="text-white text-opacity-80 text-sm mb-1 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Current Balance
                                </p>
                                <p
                                    class="text-white text-2xl md:text-3xl font-bold animate__animated animate__pulse animate__infinite animate__slower">
                                    {{ number_format($wallet->balance, 2) }} {{ $wallet->currency ?? 'USD' }}</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 flex-1">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Wallet ID</p>
                                    <p class="mt-1 text-base font-mono text-gray-900">{{ $wallet->id }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Currency</p>
                                    <p class="mt-1 text-base text-gray-900">{{ $wallet->currency ?? 'USD' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Last Transaction</p>
                                    <p class="mt-1 text-base text-gray-900">
                                        {{ $wallet->updated_at->format('M d, Y H:i') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Status</p>
                                    <p
                                        class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor"
                                            viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Active
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity Section -->
                        <div>
                            <h4 class="text-base font-medium text-gray-900 mb-4">Recent Wallet Activity</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Type</th>
                                            <th
                                                class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Amount</th>
                                            <th
                                                class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Date</th>
                                            <th
                                                class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($wallet->transactions()->latest()->take(5)->get() as $transaction)
                                            <tr>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ ucfirst($transaction->type) }}
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    @if ($transaction->type == 'deposit')
                                                        <span
                                                            class="text-green-600">+{{ number_format($transaction->amount, 2) }}
                                                            {{ $wallet->currency }}</span>
                                                    @else
                                                        <span
                                                            class="text-red-600">-{{ number_format($transaction->amount, 2) }}
                                                            {{ $wallet->currency }}</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $transaction->created_at->format('M d, Y H:i') }}
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                    @if ($transaction->status == 'completed')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Completed
                                                        </span>
                                                    @elseif($transaction->status == 'pending')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            Pending
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            Failed
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-4 py-3 text-sm text-gray-500 text-center">No
                                                    recent transactions found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                    View all transactions <span aria-hidden="true">→</span>
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-6">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No wallet found</h3>
                            <p class="mt-1 text-sm text-gray-500">This user doesn't have a wallet yet.</p>
                            <div class="mt-6">
                                <button type="button"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Create wallet
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Transaction History Section -->
            <div
                class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 mb-6 overflow-hidden border border-gray-100 animate__animated animate__fadeIn animate__delay-2s">
                <div class="bg-gradient-to-r from-gray-50 to-green-50 border-b border-gray-200">
                    <div class="px-4 py-5 sm:px-6 flex items-center">
                        <div class="bg-green-100 p-2 rounded-lg mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Transaction History</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Complete history of user transactions.</p>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <!-- Transaction Filter and Search -->
                    <div class="flex flex-col md:flex-row md:items-center mb-6 space-y-3 md:space-y-0 md:space-x-4">
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="search" id="search"
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Search transactions...">
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <select id="transaction-type" name="transaction-type"
                                class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">All Types</option>
                                <option value="deposit">Deposits</option>
                                <option value="withdrawal">Withdrawals</option>
                                <option value="transfer">Transfers</option>
                            </select>
                            <select id="transaction-status" name="transaction-status"
                                class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">All Status</option>
                                <option value="completed">Completed</option>
                                <option value="pending">Pending</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                    </div>

                    <!-- Transaction Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Transaction ID</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    // Placeholder data - replace with actual user transactions in production
                                    $transactions = [
                                        [
                                            'id' => 'TRX12345',
                                            'type' => 'deposit',
                                            'amount' => 500.0,
                                            'status' => 'completed',
                                            'date' => '2023-10-12 14:32',
                                            'description' => 'Bank deposit',
                                        ],
                                        [
                                            'id' => 'TRX12346',
                                            'type' => 'withdrawal',
                                            'amount' => 200.0,
                                            'status' => 'pending',
                                            'date' => '2023-10-10 09:15',
                                            'description' => 'ATM withdrawal',
                                        ],
                                        [
                                            'id' => 'TRX12347',
                                            'type' => 'transfer',
                                            'amount' => 150.0,
                                            'status' => 'completed',
                                            'date' => '2023-10-05 16:45',
                                            'description' => 'Transfer to John Doe',
                                        ],
                                        [
                                            'id' => 'TRX12348',
                                            'type' => 'deposit',
                                            'amount' => 1000.0,
                                            'status' => 'completed',
                                            'date' => '2023-09-28 11:22',
                                            'description' => 'PayPal deposit',
                                        ],
                                        [
                                            'id' => 'TRX12349',
                                            'type' => 'withdrawal',
                                            'amount' => 300.0,
                                            'status' => 'failed',
                                            'date' => '2023-09-25 13:10',
                                            'description' => 'Failed withdrawal attempt',
                                        ],
                                    ];
                                @endphp

                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $transaction['id'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $transaction['type'] == 'deposit' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $transaction['type'] == 'withdrawal' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $transaction['type'] == 'transfer' ? 'bg-blue-100 text-blue-800' : '' }}">
                                                {{ ucfirst($transaction['type']) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if ($transaction['type'] == 'deposit')
                                                <span
                                                    class="text-green-600">+${{ number_format($transaction['amount'], 2) }}</span>
                                            @elseif($transaction['type'] == 'withdrawal' || $transaction['type'] == 'transfer')
                                                <span
                                                    class="text-red-600">-${{ number_format($transaction['amount'], 2) }}</span>
                                            @else
                                                <span>${{ number_format($transaction['amount'], 2) }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $transaction['status'] == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $transaction['status'] == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $transaction['status'] == 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($transaction['status']) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $transaction['date'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button type="button"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">View</button>
                                            @if ($transaction['status'] == 'pending')
                                                <button type="button"
                                                    class="text-green-600 hover:text-green-900 mr-3">Approve</button>
                                                <button type="button"
                                                    class="text-red-600 hover:text-red-900">Cancel</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 mt-4">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </a>
                            <a href="#"
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </a>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing <span class="font-medium">1</span> to <span class="font-medium">5</span>
                                    of
                                    <span class="font-medium">20</span> results
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                    aria-label="Pagination">
                                    <a href="#"
                                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Previous</span>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <a href="#" aria-current="page"
                                        class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        1
                                    </a>
                                    <a href="#"
                                        class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        2
                                    </a>
                                    <a href="#"
                                        class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        3
                                    </a>
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                        ...
                                    </span>
                                    <a href="#"
                                        class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        8
                                    </a>
                                    <a href="#"
                                        class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        9
                                    </a>
                                    <a href="#"
                                        class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        10
                                    </a>
                                    <a href="#"
                                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Next</span>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Crypto Orders Section -->
            <div
                class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 mb-6 overflow-hidden border border-gray-100 animate__animated animate__fadeIn animate__delay-3s">
                <div class="bg-gradient-to-r from-gray-50 to-purple-50 border-b border-gray-200">
                    <div class="px-4 py-5 sm:px-6 flex items-center">
                        <div class="bg-purple-100 p-2 rounded-lg mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Crypto Orders</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Active and past crypto trading orders.</p>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <!-- Tabs -->
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <button type="button"
                                class="border-purple-500 text-purple-600 whitespace-nowrap py-4 px-3 border-b-2 font-medium text-sm flex items-center transition-all duration-300 hover:bg-purple-50 rounded-t-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                Active Orders
                            </button>
                            <button type="button"
                                class="border-transparent text-gray-500 hover:text-purple-600 hover:border-purple-300 whitespace-nowrap py-4 px-3 border-b-2 font-medium text-sm flex items-center transition-all duration-300 hover:bg-purple-50 rounded-t-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Past Orders
                            </button>
                        </nav>
                    </div>

                    <!-- Active Orders Table -->
                    <div class="mt-6 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Asset</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Price</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    // Placeholder data - replace with actual user crypto orders in production
                                    $cryptoOrders = [
                                        [
                                            'id' => 'ORD98765',
                                            'asset' => 'BTC',
                                            'type' => 'buy',
                                            'amount' => 0.25,
                                            'price' => 58432.5,
                                            'status' => 'pending',
                                            'date' => '2023-10-12 14:32',
                                        ],
                                        [
                                            'id' => 'ORD98766',
                                            'asset' => 'ETH',
                                            'type' => 'sell',
                                            'amount' => 2.5,
                                            'price' => 3211.75,
                                            'status' => 'processing',
                                            'date' => '2023-10-11 09:15',
                                        ],
                                        [
                                            'id' => 'ORD98767',
                                            'asset' => 'USDT',
                                            'type' => 'buy',
                                            'amount' => 1000,
                                            'price' => 1.0,
                                            'status' => 'pending',
                                            'date' => '2023-10-10 16:45',
                                        ],
                                    ];
                                @endphp

                                @foreach ($cryptoOrders as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full 
                                                    {{ $order['asset'] == 'BTC' ? 'bg-gradient-to-br from-orange-400 to-orange-500' : '' }} 
                                                    {{ $order['asset'] == 'ETH' ? 'bg-gradient-to-br from-indigo-400 to-indigo-500' : '' }}
                                                    {{ $order['asset'] == 'USDT' ? 'bg-gradient-to-br from-green-400 to-green-500' : '' }}
                                                    {{ !in_array($order['asset'], ['BTC', 'ETH', 'USDT']) ? 'bg-gradient-to-br from-gray-400 to-gray-500' : '' }}
                                                    shadow-inner p-1 transform transition-all duration-300 hover:scale-110">
                                                    <span
                                                        class="text-sm font-bold text-white">{{ $order['asset'] }}</span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $order['asset'] }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">Order ID: {{ $order['id'] }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $order['type'] == 'buy' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($order['type']) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order['amount'] }} {{ $order['asset'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            ${{ number_format($order['price'], 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $order['status'] == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $order['status'] == 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $order['status'] == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $order['status'] == 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($order['status']) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order['date'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button type="button"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">View</button>
                                            <button type="button" class="text-red-600 hover:text-red-900">Cancel</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 text-center">
                        <button type="button"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-md text-white bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View All Crypto Orders
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Deposit Modal -->
    <div id="deposit-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Deposit Funds</h3>
                    <button type="button" class="close-modal text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <form class="px-6 py-4">
                <div class="mb-4">
                    <label for="deposit-amount" class="block text-sm font-medium text-gray-700">Amount</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" name="deposit-amount" id="deposit-amount"
                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                            placeholder="0.00" step="0.01" min="0">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">USD</span>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="deposit-method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                    <select id="deposit-method" name="deposit-method"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="bank">Bank Transfer</option>
                        <option value="card">Credit/Debit Card</option>
                        <option value="crypto">Cryptocurrency</option>
                        <option value="paypal">PayPal</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="deposit-description" class="block text-sm font-medium text-gray-700">Description</label>
                    <div class="mt-1">
                        <textarea id="deposit-description" name="deposit-description" rows="3"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            placeholder="Enter a description for this transaction"></textarea>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 -mx-6 -mb-4 mt-4 flex justify-end">
                    <button type="button"
                        class="close-modal bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                        Cancel
                    </button>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Deposit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Withdraw Modal -->
    <div id="withdraw-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Withdraw Funds</h3>
                    <button type="button" class="close-modal text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <form class="px-6 py-4">
                <div class="mb-4">
                    <label for="withdraw-amount" class="block text-sm font-medium text-gray-700">Amount</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" name="withdraw-amount" id="withdraw-amount"
                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                            placeholder="0.00" step="0.01" min="0">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">USD</span>
                        </div>
                    </div>
                    @if ($wallet)
                        <p class="mt-1 text-sm text-gray-500">Available balance: ${{ number_format($wallet->balance, 2) }}
                        </p>
                    @endif
                </div>
                <div class="mb-4">
                    <label for="withdraw-method" class="block text-sm font-medium text-gray-700">Withdrawal Method</label>
                    <select id="withdraw-method" name="withdraw-method"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="bank">Bank Transfer</option>
                        <option value="card">Credit/Debit Card</option>
                        <option value="crypto">Cryptocurrency</option>
                        <option value="paypal">PayPal</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="withdraw-account" class="block text-sm font-medium text-gray-700">Account Details</label>
                    <div class="mt-1">
                        <input type="text" name="withdraw-account" id="withdraw-account"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            placeholder="Enter account details for withdrawal">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="withdraw-description" class="block text-sm font-medium text-gray-700">Description</label>
                    <div class="mt-1">
                        <textarea id="withdraw-description" name="withdraw-description" rows="2"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            placeholder="Enter a description for this transaction"></textarea>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 -mx-6 -mb-4 mt-4 flex justify-end">
                    <button type="button"
                        class="close-modal bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                        Cancel
                    </button>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        Withdraw
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Transfer Modal -->
    <div id="transfer-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Transfer Funds</h3>
                    <button type="button" class="close-modal text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <form class="px-6 py-4">
                <div class="mb-4">
                    <label for="recipient-email" class="block text-sm font-medium text-gray-700">Recipient
                        Email/ID</label>
                    <div class="mt-1">
                        <input type="text" name="recipient-email" id="recipient-email"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            placeholder="Enter recipient's email or ID">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="transfer-amount" class="block text-sm font-medium text-gray-700">Amount</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" name="transfer-amount" id="transfer-amount"
                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                            placeholder="0.00" step="0.01" min="0">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">USD</span>
                        </div>
                    </div>
                    @if ($wallet)
                        <p class="mt-1 text-sm text-gray-500">Available balance: ${{ number_format($wallet->balance, 2) }}
                        </p>
                    @endif
                </div>
                <div class="mb-4">
                    <label for="transfer-description" class="block text-sm font-medium text-gray-700">Description</label>
                    <div class="mt-1">
                        <textarea id="transfer-description" name="transfer-description" rows="2"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            placeholder="Enter a description for this transfer"></textarea>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 -mx-6 -mb-4 mt-4 flex justify-end">
                    <button type="button"
                        class="close-modal bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                        Cancel
                    </button>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Transfer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Modal Functionality -->
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

            // Open deposit modal
            depositBtn.addEventListener('click', function() {
                modalBackdrop.classList.remove('hidden');
                depositModal.classList.remove('hidden');
            });

            // Open withdraw modal
            withdrawBtn.addEventListener('click', function() {
                modalBackdrop.classList.remove('hidden');
                withdrawModal.classList.remove('hidden');
            });

            // Open transfer modal
            transferBtn.addEventListener('click', function() {
                modalBackdrop.classList.remove('hidden');
                transferModal.classList.remove('hidden');
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
