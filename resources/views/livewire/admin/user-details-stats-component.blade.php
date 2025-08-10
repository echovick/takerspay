<div>
    <!-- User Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <!-- Crypto & Gift Card App Stats -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-2 rounded-full">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <h2 class="ml-3 text-lg font-medium text-white">Crypto & Gift Cards</h2>
                    </div>
                    <div class="text-white text-xs">
                        {{ $stats['wallets']['crypto']['exists'] ? 'Active' : 'Not Setup' }}
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Crypto Balance</p>
                        <p class="text-xl font-bold text-gray-800">
                            {{ number_format($stats['wallets']['crypto']['balance'], 8) }}
                            {{ $stats['wallets']['crypto']['currency'] }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Fiat Balance</p>
                        <p class="text-xl font-bold text-gray-800">
                            ${{ number_format($stats['wallets']['fiat']['balance'], 2) }}
                        </p>
                    </div>
                    <div class="col-span-2">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Orders</p>
                                <p class="text-xl font-bold text-gray-800">
                                    {{ number_format($stats['orders']['total']) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Success Rate</p>
                                <p class="text-xl font-bold text-green-600">{{ $stats['orders']['completion_rate'] }}%
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial App Stats -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-2 rounded-full">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>
                        <h2 class="ml-3 text-lg font-medium text-white">Financial Services</h2>
                    </div>
                    <div class="text-white text-xs">
                        {{ $stats['wallets']['nuban']['exists'] ? 'Active' : 'Not Setup' }}
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">NUBAN Balance</p>
                        <p class="text-xl font-bold text-gray-800">
                            ₦{{ number_format($stats['wallets']['nuban']['balance'], 2) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Transactions</p>
                        <p class="text-xl font-bold text-gray-800">{{ number_format($stats['transactions']['total']) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Bank Accounts</p>
                        <p class="text-xl font-bold text-gray-800">
                            {{ number_format($stats['support']['bank_accounts']) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Support Tickets</p>
                        <div class="flex items-center">
                            <p class="text-xl font-bold text-gray-800">
                                {{ number_format($stats['support']['tickets']) }}</p>
                            @if ($stats['support']['open_tickets'] > 0)
                                <span
                                    class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    {{ $stats['support']['open_tickets'] }} open
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <!-- Total Balance -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Balance</h3>
                    <p class="text-xl font-bold text-gray-900">
                        ₦{{ number_format($stats['wallets']['total_balance'], 2) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- KYC Status -->
        <div
            class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 border-l-4 {{ $stats['kyc']['verified'] ? 'border-green-500' : 'border-yellow-500' }}">
            <div class="flex items-center">
                <div class="{{ $stats['kyc']['verified'] ? 'bg-green-100' : 'bg-yellow-100' }} p-3 rounded-full">
                    <svg class="h-6 w-6 {{ $stats['kyc']['verified'] ? 'text-green-600' : 'text-yellow-600' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if ($stats['kyc']['verified'])
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        @endif
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">KYC Status</h3>
                    <p class="text-xl font-bold text-gray-900">
                        {{ $stats['kyc']['verified'] ? 'Verified' : 'Pending' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Order Success Rate -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Order Success</h3>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['orders']['completion_rate'] }}%</p>
                </div>
            </div>
        </div>

        <!-- Member Since -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 border-l-4 border-indigo-500">
            <div class="flex items-center">
                <div class="bg-indigo-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
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
