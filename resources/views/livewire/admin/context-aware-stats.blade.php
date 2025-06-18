<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
    <!-- Users Stats Card - Always Visible -->
    <div class="bg-white border border-gray-100 shadow-md rounded-lg relative overflow-hidden">
        <div class="absolute h-full w-1 bg-blue-600 left-0 top-0"></div>
        <div class="p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Users</p>
                    <p class="text-xl font-bold text-gray-800">{{ number_format($stats['total_users'] ?? 0) }}</p>
                </div>
            </div>
        </div>
    </div>

    @if ($context === 'all' || $context === 'crypto')
        <!-- Crypto App Specific Stats -->
        <div class="bg-white border border-gray-100 shadow-md rounded-lg relative overflow-hidden">
            <div class="absolute h-full w-1 bg-indigo-600 left-0 top-0"></div>
            <div class="p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Orders</p>
                        <p class="text-xl font-bold text-gray-800">{{ number_format($stats['total_orders'] ?? 0) }}</p>
                        <div class="flex items-center mt-1">
                            <span class="text-xs text-orange-500 flex items-center">
                                <span class="inline-flex h-2 w-2 rounded-full bg-orange-500 mr-1"></span>
                                {{ number_format($stats['pending_orders'] ?? 0) }} pending
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 shadow-md rounded-lg relative overflow-hidden">
            <div class="absolute h-full w-1 bg-purple-600 left-0 top-0"></div>
            <div class="p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Crypto Wallets</p>
                        <p class="text-xl font-bold text-gray-800">
                            ₦{{ number_format($stats['crypto_wallet_balance'] ?? 0) }}</p>
                        <div class="flex items-center mt-1">
                            <span class="text-xs text-gray-500">
                                Fiat: ₦{{ number_format($stats['fiat_wallet_balance'] ?? 0) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($context === 'all' || $context === 'finance')
        <!-- Financial App Specific Stats -->
        <div class="bg-white border border-gray-100 shadow-md rounded-lg relative overflow-hidden">
            <div class="absolute h-full w-1 bg-green-600 left-0 top-0"></div>
            <div class="p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Transactions</p>
                        <p class="text-xl font-bold text-gray-800">
                            {{ number_format($stats['total_transactions'] ?? 0) }}</p>
                        <div class="flex items-center mt-1">
                            <span class="text-xs text-orange-500 flex items-center">
                                <span class="inline-flex h-2 w-2 rounded-full bg-orange-500 mr-1"></span>
                                {{ number_format($stats['pending_transactions'] ?? 0) }} pending
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 shadow-md rounded-lg relative overflow-hidden">
            <div class="absolute h-full w-1 bg-teal-600 left-0 top-0"></div>
            <div class="p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-teal-100 text-teal-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">NUBAN Balances</p>
                        <p class="text-xl font-bold text-gray-800">
                            ₦{{ number_format($stats['nuban_wallet_balance'] ?? 0) }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
