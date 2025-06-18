<div>
    <!-- Wallets Overview Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Fiat Wallet Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-indigo-100">
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4 border-b">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="ml-3 text-lg font-medium text-white">Fiat Wallet</h2>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @if ($fiatWallet)
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500">Balance</p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ number_format($fiatWallet->balance, 2) }} {{ $fiatWallet->currency ?? 'USD' }}
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Wallet ID</p>
                            <p class="text-sm font-mono text-gray-800">{{ $fiatWallet->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <p
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor"
                                    viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Active
                            </p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-6">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No fiat wallet</h3>
                        <p class="mt-1 text-sm text-gray-500">User doesn't have a fiat wallet yet.</p>
                        <div class="mt-4">
                            <button type="button"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create Fiat Wallet
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Crypto Wallet Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-purple-100">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4 border-b">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <h2 class="ml-3 text-lg font-medium text-white">Crypto Wallet</h2>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @if ($cryptoWallet)
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500">Balance</p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ number_format($cryptoWallet->balance, 2) }} {{ $cryptoWallet->currency ?? 'BTC' }}
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Wallet ID</p>
                            <p class="text-sm font-mono text-gray-800">{{ $cryptoWallet->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <p
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor"
                                    viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Active
                            </p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-6">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No crypto wallet</h3>
                        <p class="mt-1 text-sm text-gray-500">User doesn't have a crypto wallet yet.</p>
                        <div class="mt-4">
                            <button type="button"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                Create Crypto Wallet
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- NUBAN Wallet Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-green-100">
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4 border-b">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <h2 class="ml-3 text-lg font-medium text-white">NUBAN Wallet</h2>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @if ($nubanWallet)
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500">Balance</p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ number_format($nubanWallet->balance, 2) }} {{ $nubanWallet->currency ?? 'NGN' }}
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Wallet ID</p>
                            <p class="text-sm font-mono text-gray-800">{{ $nubanWallet->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <p
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor"
                                    viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Active
                            </p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-6">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No NUBAN wallet</h3>
                        <p class="mt-1 text-sm text-gray-500">User doesn't have a NUBAN wallet yet.</p>
                        <div class="mt-4">
                            <button type="button"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Create NUBAN Wallet
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Wallet Transactions -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Recent Wallet Transactions</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Wallet</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($walletTransactions as $transaction)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $transaction->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span
                                    class="px-2 py-1 text-xs rounded-full
                                    {{ $transaction->wallet->type == 'fiat' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                    {{ $transaction->wallet->type == 'crypto' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $transaction->wallet->type == 'nuban' ? 'bg-green-100 text-green-800' : '' }}">
                                    {{ ucfirst($transaction->wallet->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ ucfirst($transaction->transaction_type ?? $transaction->type) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if (in_array($transaction->transaction_type ?? $transaction->type, ['deposit', 'transfer_in']))
                                    <span class="text-green-600">+{{ number_format($transaction->amount, 2) }}</span>
                                @else
                                    <span class="text-red-600">-{{ number_format($transaction->amount, 2) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span
                                    class="px-2 py-1 text-xs rounded-full
                                    {{ $transaction->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $transaction->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $transaction->status == 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ ($transaction->transaction_date ?? $transaction->created_at)->format('M d, Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No recent transactions found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
