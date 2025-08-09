<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-4">
    <!-- Users Stats Card - Always Visible -->
    <div
        class="bg-white border border-gray-100 shadow-sm rounded-lg relative overflow-hidden hover:shadow-md transition-shadow">
        <div class="absolute h-full w-1 bg-blue-600 left-0 top-0"></div>
        <div class="p-3 sm:p-4">
            <div class="flex items-center">
                <div class="p-2 sm:p-3 rounded-full bg-blue-100 text-blue-600 mr-3 sm:mr-4 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-gray-500 text-xs sm:text-sm font-medium">Total Users</p>
                    <p class="text-lg sm:text-xl font-bold text-gray-800 truncate">
                        {{ number_format($stats['total_users'] ?? 0) }}</p>
                    <div class="flex flex-col sm:flex-row sm:items-center mt-1 text-xs gap-1 sm:gap-2">
                        <span class="text-green-500 flex items-center">
                            <span class="inline-flex h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full bg-green-500 mr-1"></span>
                            {{ number_format($stats['active_users'] ?? 0) }} active
                        </span>
                        <span class="text-blue-500">
                            +{{ number_format($stats['new_users_today'] ?? 0) }} today
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($context === 'all' || $context === 'crypto')
        <!-- Orders Stats Card -->
        <div
            class="bg-white border border-gray-100 shadow-sm rounded-lg relative overflow-hidden hover:shadow-md transition-shadow">
            <div class="absolute h-full w-1 bg-indigo-600 left-0 top-0"></div>
            <div class="p-3 sm:p-4">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 rounded-full bg-indigo-100 text-indigo-600 mr-3 sm:mr-4 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-gray-500 text-xs sm:text-sm font-medium">Orders</p>
                        <p class="text-lg sm:text-xl font-bold text-gray-800 truncate">
                            {{ number_format($stats['total_orders'] ?? 0) }}</p>
                        <div class="flex flex-col sm:flex-row sm:items-center mt-1 text-xs gap-1 sm:gap-2">
                            <span class="text-green-500 flex items-center">
                                <span
                                    class="inline-flex h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full bg-green-500 mr-1"></span>
                                {{ number_format($stats['completed_orders'] ?? 0) }} completed
                            </span>
                            <span class="text-orange-500 flex items-center">
                                <span
                                    class="inline-flex h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full bg-orange-500 mr-1"></span>
                                {{ number_format($stats['pending_orders'] ?? 0) }} pending
                            </span>
                        </div>
                        <div class="mt-1 text-xs text-gray-500">
                            +{{ number_format($stats['orders_today'] ?? 0) }} today
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assets Card -->
        <div
            class="bg-white border border-gray-100 shadow-sm rounded-lg relative overflow-hidden hover:shadow-md transition-shadow">
            <div class="absolute h-full w-1 bg-amber-600 left-0 top-0"></div>
            <div class="p-3 sm:p-4">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 rounded-full bg-amber-100 text-amber-600 mr-3 sm:mr-4 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-gray-500 text-xs sm:text-sm font-medium">Assets</p>
                        <p class="text-lg sm:text-xl font-bold text-gray-800 truncate">
                            {{ number_format($stats['total_assets'] ?? 0) }}</p>
                        <div class="flex flex-col sm:flex-row sm:items-center mt-1 text-xs gap-1 sm:gap-2">
                            <span class="text-green-500 flex items-center">
                                <span
                                    class="inline-flex h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full bg-green-500 mr-1"></span>
                                {{ number_format($stats['active_assets'] ?? 0) }} available
                            </span>
                            <span class="text-gray-500">
                                Avg: ₦{{ number_format($stats['avg_order_value'] ?? 0, 0) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($context === 'all' || $context === 'finance')
        <!-- Transactions Stats Card -->
        <div
            class="bg-white border border-gray-100 shadow-sm rounded-lg relative overflow-hidden hover:shadow-md transition-shadow">
            <div class="absolute h-full w-1 bg-green-600 left-0 top-0"></div>
            <div class="p-3 sm:p-4">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 rounded-full bg-green-100 text-green-600 mr-3 sm:mr-4 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-gray-500 text-xs sm:text-sm font-medium">Transactions</p>
                        <p class="text-lg sm:text-xl font-bold text-gray-800 truncate">
                            {{ number_format($stats['total_transactions'] ?? 0) }}</p>
                        <div class="flex flex-col sm:flex-row sm:items-center mt-1 text-xs gap-1 sm:gap-2">
                            <span class="text-green-500 flex items-center">
                                <span
                                    class="inline-flex h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full bg-green-500 mr-1"></span>
                                {{ number_format($stats['successful_transactions'] ?? 0) }} successful
                            </span>
                            <span class="text-orange-500 flex items-center">
                                <span
                                    class="inline-flex h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full bg-orange-500 mr-1"></span>
                                {{ number_format($stats['pending_transactions'] ?? 0) }} pending
                            </span>
                        </div>
                        <div class="mt-1 text-xs text-gray-500">
                            +{{ number_format($stats['transactions_today'] ?? 0) }} today
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction Volume Card -->
        <div
            class="bg-white border border-gray-100 shadow-sm rounded-lg relative overflow-hidden hover:shadow-md transition-shadow">
            <div class="absolute h-full w-1 bg-emerald-600 left-0 top-0"></div>
            <div class="p-3 sm:p-4">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 rounded-full bg-emerald-100 text-emerald-600 mr-3 sm:mr-4 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-gray-500 text-xs sm:text-sm font-medium">Transaction Volume</p>
                        <p class="text-lg sm:text-xl font-bold text-gray-800 truncate">
                            ₦{{ number_format($stats['total_transaction_volume'] ?? 0, 2) }}</p>
                        <div class="flex flex-col sm:flex-row sm:items-center mt-1 text-xs gap-1 sm:gap-2">
                            <span class="text-blue-500">
                                Avg: ₦{{ number_format($stats['avg_transaction_amount'] ?? 0, 2) }}
                            </span>
                            <span class="text-green-600">
                                Fees: ₦{{ number_format($stats['total_fees_collected'] ?? 0, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- NUBAN Balances Card -->
        <div
            class="bg-white border border-gray-100 shadow-sm rounded-lg relative overflow-hidden hover:shadow-md transition-shadow">
            <div class="absolute h-full w-1 bg-teal-600 left-0 top-0"></div>
            <div class="p-3 sm:p-4">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 rounded-full bg-teal-100 text-teal-600 mr-3 sm:mr-4 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-gray-500 text-xs sm:text-sm font-medium">NUBAN Balances</p>
                        <p class="text-lg sm:text-xl font-bold text-gray-800 truncate">
                            ₦{{ number_format($stats['nuban_wallet_balance'] ?? 0, 2) }}</p>
                        @if ($context === 'all')
                            <div class="mt-1 text-xs text-gray-500">
                                Total wallets: {{ number_format($stats['total_wallets'] ?? 0) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
