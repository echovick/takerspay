<div>
    <!-- NUBAN Wallet Section -->
    <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
        <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4">
            <h2 class="text-lg font-medium text-white">NUBAN Account</h2>
        </div>
        <div class="p-6">
            @if ($nubanWallet)
                <div class="flex flex-wrap lg:flex-nowrap gap-4">
                    <div
                        class="w-full lg:w-1/2 bg-gradient-to-br from-green-50 to-teal-50 rounded-lg p-5 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-8 -mb-8"></div>

                        <div class="relative">
                            <h3 class="text-base font-medium text-green-800 mb-4">Account Information</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Bank Name</p>
                                    <p class="text-base font-medium text-gray-800">{{ $nubanWallet->bank_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Account Number</p>
                                    <p class="text-base font-medium text-gray-800">{{ $nubanWallet->account_number }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Account Name</p>
                                    <p class="text-base font-medium text-gray-800">{{ $nubanWallet->account_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Currency</p>
                                    <p class="text-base font-medium text-gray-800">{{ $nubanWallet->currency }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-full lg:w-1/2 bg-gradient-to-br from-teal-50 to-teal-100 rounded-lg p-5 flex items-center justify-center">
                        <div class="text-center">
                            <p class="text-sm text-teal-800 mb-2">Current Balance</p>
                            <p class="text-4xl font-bold text-teal-700">{{ number_format($nubanWallet->balance, 2) }}
                                {{ $nubanWallet->currency }}</p>
                            <div class="mt-4 flex justify-center space-x-2">
                                <button class="px-3 py-1.5 bg-teal-600 hover:bg-teal-700 text-white text-sm rounded-md">
                                    Fund Account
                                </button>
                                <button
                                    class="px-3 py-1.5 bg-white text-teal-600 border border-teal-600 text-sm rounded-md">
                                    View Statement
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-gray-50 rounded-lg p-6 text-center">
                    <div class="mb-4">
                        <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No NUBAN Account Found</h3>
                    <p class="text-gray-600 mb-4">This user doesn't have a NUBAN account set up yet.</p>
                    <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-md">
                        Create NUBAN Account
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Bank Accounts Section -->
    <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
        <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4 flex justify-between items-center">
            <h2 class="text-lg font-medium text-white">Linked Bank Accounts</h2>
            <button class="px-3 py-1.5 bg-white/20 hover:bg-white/30 text-white text-sm rounded-md">
                Add Bank Account
            </button>
        </div>
        <div class="p-6">
            @if (count($bankAccounts) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($bankAccounts as $account)
                        <div
                            class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-3">
                                <div class="bg-green-100 p-2 rounded-full">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded-full">
                                    {{ $account->is_default ? 'Default' : 'Secondary' }}
                                </span>
                            </div>
                            <h3 class="text-base font-medium text-gray-900 mb-1">{{ $account->bank_name }}</h3>
                            <p class="text-sm text-gray-600 mb-3">{{ $account->account_number }}</p>
                            <p class="text-sm text-gray-600">Account Name</p>
                            <p class="text-base font-medium text-gray-800 mb-3">{{ $account->account_name }}</p>
                            <div class="flex justify-end space-x-2 mt-2">
                                <button class="text-gray-600 hover:text-gray-900">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </button>
                                <button class="text-red-600 hover:text-red-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                        </path>
                    </svg>
                    <p class="text-gray-600">No bank accounts have been linked to this user.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Transactions Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4">
                <h2 class="text-lg font-medium text-white">Recent Transactions</h2>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
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
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="h-8 w-8 rounded-full 
                                                {{ $transaction->transaction_type == 'deposit'
                                                    ? 'bg-green-100 text-green-700'
                                                    : ($transaction->transaction_type == 'withdrawal'
                                                        ? 'bg-red-100 text-red-700'
                                                        : 'bg-blue-100 text-blue-700') }}
                                                flex items-center justify-center">

                                                @if ($transaction->transaction_type == 'deposit')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                @elseif($transaction->transaction_type == 'withdrawal')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M20 12H4"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ ucfirst($transaction->transaction_type) }}</p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $transaction->transaction_reference }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p
                                            class="text-sm {{ $transaction->transaction_type == 'deposit' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $transaction->transaction_type == 'deposit' ? '+' : '-' }}
                                            ₦{{ number_format($transaction->amount, 2) }}
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $transaction->wallet->currency ?? '' }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full
                                            {{ $transaction->status == 'completed' || $transaction->status == 'success'
                                                ? 'bg-green-100 text-green-800'
                                                : ($transaction->status == 'pending'
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $transaction->created_at->format('M d, Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        No transactions found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>

        <!-- Support Tickets Section -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4 flex justify-between items-center">
                <h2 class="text-lg font-medium text-white">Support Tickets</h2>
                <button class="px-3 py-1.5 bg-white/20 hover:bg-white/30 text-white text-sm rounded-md">
                    Create Ticket
                </button>
            </div>
            <div class="p-6">
                @if (count($tickets) > 0)
                    <div class="space-y-3">
                        @foreach ($tickets as $ticket)
                            <div
                                class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
                                <div class="flex justify-between mb-2">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $ticket->subject }}</h3>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                        {{ $ticket->status == 'open'
                                            ? 'bg-red-100 text-red-800'
                                            : ($ticket->status == 'in-progress'
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : 'bg-green-100 text-green-800') }}">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mb-3">Created
                                    {{ $ticket->created_at->diffForHumans() }}</p>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $ticket->message }}</p>
                                <div class="flex justify-end mt-3">
                                    <a href="#"
                                        class="text-sm text-green-600 hover:text-green-800 font-medium">View
                                        Details</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if (count($tickets) > 5)
                        <div class="text-center mt-4">
                            <a href="#"
                                class="inline-flex items-center text-sm text-green-600 hover:text-green-800 font-medium">
                                View All Tickets
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z">
                            </path>
                        </svg>
                        <p class="text-gray-600">No support tickets have been created by this user.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
