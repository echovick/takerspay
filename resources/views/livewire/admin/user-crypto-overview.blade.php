<div>
    <!-- Wallet Balances Section -->
    <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
            <h2 class="text-lg font-medium text-white">Wallet Balances</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Crypto Wallets -->
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg p-4">
                    <h3 class="text-base font-medium text-indigo-800 mb-3">Crypto Wallets</h3>
                    @forelse($cryptoWallets as $wallet)
                        <div class="bg-white rounded-lg p-3 mb-2 shadow-sm">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-800">
                                        {{ $wallet->asset->name ?? 'Crypto Wallet' }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ Str::limit($wallet->crypto_wallet_number ?? 'No wallet address', 20) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-indigo-700">
                                        {{ number_format($wallet->balance, 8) }}</p>
                                    <p class="text-xs text-gray-500">{{ $wallet->currency }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg p-3 text-center">
                            <p class="text-gray-500">No crypto wallets found</p>
                        </div>
                    @endforelse
                </div>

                <!-- Fiat Wallets -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4">
                    <h3 class="text-base font-medium text-purple-800 mb-3">Fiat Wallets</h3>
                    @forelse($fiatWallets as $wallet)
                        <div class="bg-white rounded-lg p-3 mb-2 shadow-sm">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $wallet->currency }} Wallet</p>
                                    <p class="text-xs text-gray-500 mt-1">Fiat Balance</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-purple-700">
                                        {{ number_format($wallet->balance, 2) }}</p>
                                    <p class="text-xs text-gray-500">{{ $wallet->currency }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg p-3 text-center">
                            <p class="text-gray-500">No fiat wallets found</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4 flex justify-between items-center">
            <h2 class="text-lg font-medium text-white">Crypto & Gift Card Orders</h2>
            <div>
                <select
                    class="bg-white/20 text-white text-sm rounded-lg px-3 py-1.5 border-0 focus:ring-2 focus:ring-white/50">
                    <option value="all">All Orders</option>
                    <option value="buy">Buy Orders</option>
                    <option value="sell">Sell Orders</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
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
                                Value</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700">
                                            {{ strtoupper(substr($order->asset, 0, 2)) }}
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $order->asset }}</p>
                                            <p class="text-xs text-gray-500">{{ $order->reference }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{ $order->type == 'buy' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($order->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->asset_value }} {{ $order->trade_currency ?? '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ₦{{ number_format($order->naira_price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full
                                        {{ $order->transaction_status == 'completed'
                                            ? 'bg-green-100 text-green-800'
                                            : ($order->transaction_status == 'pending'
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($order->transaction_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('M d, Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No crypto or gift card orders found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
