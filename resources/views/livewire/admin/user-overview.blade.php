<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Activity Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200 px-6 py-4">
            <h2 class="text-lg font-medium text-gray-900">Recent Activity</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse(array_merge($recentOrders->toArray(), $recentTransactions->toArray()) as $activity)
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <div class="flex items-center">
                            <div
                                class="h-10 w-10 rounded-full {{ isset($activity['asset']) ? 'bg-gradient-to-tr from-indigo-500 to-purple-600' : 'bg-gradient-to-tr from-green-500 to-teal-600' }} flex items-center justify-center text-white font-bold text-xs">
                                {{ isset($activity['asset']) ? 'OR' : 'TX' }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">
                                    @if (isset($activity['asset']))
                                        {{ ucfirst($activity['type']) }} order for {{ $activity['asset'] }}
                                    @else
                                        {{ $activity['transaction_description'] ?? ($activity['transaction_type'] ?? 'Transaction') }}
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($activity['created_at'])->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium">
                                @if (isset($activity['naira_price']))
                                    ₦{{ number_format($activity['naira_price'], 2) }}
                                @else
                                    ₦{{ number_format($activity['amount'] ?? 0, 2) }}
                                @endif
                            </p>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                {{ (isset($activity['transaction_status']) ? $activity['transaction_status'] : $activity['status'] ?? '') ===
                                    'success' ||
                                (isset($activity['transaction_status']) ? $activity['transaction_status'] : $activity['status'] ?? '') === 'completed'
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst(isset($activity['transaction_status']) ? $activity['transaction_status'] : $activity['status'] ?? 'pending') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <p class="text-gray-500">No recent activities found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Wallet Summary Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200 px-6 py-4">
            <h2 class="text-lg font-medium text-gray-900">Wallet Summary</h2>
        </div>
        <div class="p-6">
            <!-- Crypto Wallets -->
            @if (count($cryptoWallets) > 0)
                <div class="mb-4">
                    <h3 class="text-base font-medium text-gray-700 mb-2 flex items-center">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span>
                        Crypto Wallets
                    </h3>
                    <div class="space-y-3">
                        @foreach ($cryptoWallets as $wallet)
                            <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                                <div>
                                    <p class="text-sm font-medium">{{ $wallet->asset->name ?? 'Crypto Wallet' }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $wallet->crypto_wallet_number ?? 'No wallet address' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold">{{ number_format($wallet->balance, 8) }}
                                        {{ $wallet->currency }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Fiat Wallets -->
            @if (count($fiatWallets) > 0)
                <div class="mb-4">
                    <h3 class="text-base font-medium text-gray-700 mb-2 flex items-center">
                        <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
                        Fiat Wallets
                    </h3>
                    <div class="space-y-3">
                        @foreach ($fiatWallets as $wallet)
                            <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                                <div>
                                    <p class="text-sm font-medium">{{ $wallet->currency }} Wallet</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold">{{ number_format($wallet->balance, 2) }}
                                        {{ $wallet->currency }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- NUBAN Wallets -->
            @if (count($nubanWallets) > 0)
                <div>
                    <h3 class="text-base font-medium text-gray-700 mb-2 flex items-center">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        NUBAN Accounts
                    </h3>
                    <div class="space-y-3">
                        @foreach ($nubanWallets as $wallet)
                            <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                                <div>
                                    <p class="text-sm font-medium">{{ $wallet->bank_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $wallet->account_number }} •
                                        {{ $wallet->account_name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold">{{ number_format($wallet->balance, 2) }}
                                        {{ $wallet->currency }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (count($cryptoWallets) == 0 && count($fiatWallets) == 0 && count($nubanWallets) == 0)
                <div class="text-center py-4">
                    <p class="text-gray-500">No wallets found for this user.</p>
                </div>
            @endif
        </div>
    </div>
</div>
