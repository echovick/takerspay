<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Total Transactions Card -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-lg relative overflow-hidden">
        <div class="absolute h-full w-1 bg-blue-600 left-0 top-0"></div>
        <div class="p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Transactions</p>
                    <p class="text-xl font-bold text-gray-800">{{ number_format($totalTransactions) }}</p>
                    <div class="flex items-center mt-1 text-xs">
                        <span class="text-green-500 flex items-center mr-2">
                            <span class="inline-flex h-2 w-2 rounded-full bg-green-500 mr-1"></span>
                            {{ number_format($transactionsToday) }} today
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Volume Card -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-lg relative overflow-hidden">
        <div class="absolute h-full w-1 bg-green-600 left-0 top-0"></div>
        <div class="p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Volume</p>
                    <p class="text-xl font-bold text-gray-800">₦{{ number_format($totalVolume, 2) }}</p>
                    <div class="flex items-center mt-1 text-xs">
                        <span class="text-blue-500">Today: ₦{{ number_format($volumeToday, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Rate Card -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-lg relative overflow-hidden">
        <div class="absolute h-full w-1 bg-purple-600 left-0 top-0"></div>
        <div class="p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Success Rate</p>
                    <p class="text-xl font-bold text-gray-800">{{ number_format($successRate, 1) }}%</p>
                    <div class="flex items-center mt-1 text-xs space-x-2">
                        <span class="text-green-500">{{ number_format($successfulTransactions) }} success</span>
                        <span class="text-red-500">{{ number_format($failedTransactions) }} failed</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Types Card -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-lg relative overflow-hidden">
        <div class="absolute h-full w-1 bg-orange-600 left-0 top-0"></div>
        <div class="p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Transaction Types</p>
                    <p class="text-xl font-bold text-gray-800">₦{{ number_format($averageTransactionAmount, 2) }}</p>
                    <div class="flex items-center mt-1 text-xs space-x-2">
                        <span class="text-green-500">{{ number_format($creditTransactions) }} credits</span>
                        <span class="text-red-500">{{ number_format($debitTransactions) }} debits</span>
                    </div>
                    <div class="text-xs text-gray-500 mt-1">Average Amount</div>
                </div>
            </div>
        </div>
    </div>
</div>