<div>
    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-6">
        <div class="px-4 py-3 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-900">Transaction History</h2>
        </div>
        <div class="p-4">
            <div class="flex flex-col lg:flex-row gap-3">
                <!-- Search Input -->
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" wire:model.live="search" placeholder="Search by reference or description..."
                        class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <!-- Type Filter -->
                <select wire:model.live="typeFilter"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">All Types</option>
                    <option value="credit">Credit</option>
                    <option value="debit">Debit</option>
                </select>

                <!-- Status Filter -->
                <select wire:model.live="statusFilter"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">All Status</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed</option>
                    <option value="cancelled">Cancelled</option>
                </select>

                <!-- Date Filter -->
                <select wire:model.live="dateFilter"
                    class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">All Time</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                    <option value="year">This Year</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <!-- Table Controls -->
        <div class="px-4 py-3 border-b border-gray-100">
            <div class="flex justify-between items-center">
                <div class="flex gap-4 items-center">
                    <!-- Per Page -->
                    <select wire:model.live="perPage"
                        class="px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>
                </div>

                <div class="text-sm text-gray-600">
                    Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of
                    {{ $transactions->total() ?? 0 }} transactions
                </div>
            </div>
        </div>

        <!-- Mobile Card View for Small Screens -->
        <div class="sm:hidden">
            @forelse ($transactions as $index => $transaction)
                <div class="border-b border-gray-100 p-3">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <span class="text-xs text-gray-500">#{{ $transactions->firstItem() + $index }}</span>
                            <div class="font-medium text-sm text-gray-900 break-all">
                                {{ $transaction->transaction_reference }}</div>
                        </div>
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusColor($transaction->status) }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <span
                                class="text-xs text-gray-500">{{ $transaction->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="text-right">
                            <div
                                class="font-semibold text-sm {{ $this->getTypeColor($transaction->transaction_type) }}">
                                {{ $transaction->transaction_type === 'credit' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $transaction->wallet ? $transaction->wallet->currency : 'N/A' }}</div>
                        </div>
                    </div>
                    @if ($transaction->description)
                        <div class="mt-2 text-xs text-gray-600">
                            {{ Str::limit($transaction->transaction_description, 50) }}</div>
                    @endif
                </div>
            @empty
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No transactions found</h3>
                    <p class="mt-1 text-xs text-gray-500">This user has no transaction history.</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">S/N</th>
                        <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100"
                            wire:click="sortBy('reference')">
                            <div class="flex items-center">
                                Reference
                                @if ($sortBy === 'transaction_reference')
                                    @if ($sortDirection === 'asc')
                                        <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                    @else
                                        <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" />
                                        </svg>
                                    @endif
                                @endif
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100"
                            wire:click="sortBy('type')">
                            <div class="flex items-center">
                                Type
                                @if ($sortBy === 'transaction_type')
                                    @if ($sortDirection === 'asc')
                                        <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                    @else
                                        <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" />
                                        </svg>
                                    @endif
                                @endif
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100"
                            wire:click="sortBy('amount')">
                            <div class="flex items-center">
                                Amount
                                @if ($sortBy === 'amount')
                                    @if ($sortDirection === 'asc')
                                        <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                    @else
                                        <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" />
                                        </svg>
                                    @endif
                                @endif
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">Wallet</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Description</th>
                        <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100 w-40"
                            wire:click="sortBy('created_at')">
                            <div class="flex items-center">
                                Date
                                @if ($sortBy === 'created_at')
                                    @if ($sortDirection === 'asc')
                                        <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                    @else
                                        <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" />
                                        </svg>
                                    @endif
                                @endif
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $index => $transaction)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $transactions->firstItem() + $index }}
                            </th>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $transaction->transaction_reference }}</div>
                                @if ($transaction->transaction_response_object && isset($transaction->transaction_response_object['admin_action']))
                                    <div class="text-xs text-gray-500">Admin Transaction</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if ($transaction->transaction_type === 'credit')
                                        <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 mr-2 text-red-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 12H4"></path>
                                        </svg>
                                    @endif
                                    <span
                                        class="font-medium {{ $this->getTypeColor($transaction->transaction_type) }} capitalize">
                                        {{ $transaction->transaction_type }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium {{ $this->getTypeColor($transaction->transaction_type) }}">
                                    {{ $transaction->transaction_type === 'credit' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $transaction->wallet ? $transaction->wallet->currency : 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($transaction->wallet)
                                    <div class="text-sm text-gray-900 capitalize">{{ $transaction->wallet->type }}
                                        Wallet</div>
                                    <div class="text-xs text-gray-500">{{ $transaction->wallet->currency }}</div>
                                @else
                                    <span class="text-gray-500">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusColor($transaction->status) }}">
                                    <span
                                        class="h-1.5 w-1.5 mr-1.5 rounded-full {{ $this->getStatusDotColor($transaction->status) }}"></span>
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate"
                                    title="{{ $transaction->transaction_description }}">
                                    {{ Str::limit($transaction->transaction_description, 50) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 w-40">
                                <div class="font-medium text-gray-900">
                                    {{ $transaction->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $transaction->created_at->format('H:i:s') }}
                                </div>
                                <div class="text-xs text-gray-500">{{ $transaction->created_at->diffForHumans() }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center">
                                <div class="text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No transactions found</h3>
                                    <p class="mt-1 text-sm text-gray-500">This user has no transaction history matching
                                        your current filters.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
