<div>
    <!-- Order Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Order Information Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-2 rounded-full">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <h2 class="ml-3 text-lg font-medium text-white">Order Information</h2>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Reference</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $order->reference }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Type</p>
                            <p class="text-sm font-semibold text-gray-900 capitalize">{{ $order->type ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Asset</p>
                            <p class="text-sm font-semibold text-gray-900 capitalize">{{ $order->asset ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Asset Value</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $order->asset_value ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    @if($order->asset === 'giftcard' && $order->trade_currency)
                        <div>
                            <p class="text-sm font-medium text-gray-500">Gift Card Currency</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $order->trade_currency }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Financial Details Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-2 rounded-full">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="ml-3 text-lg font-medium text-white">Financial Details</h2>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Amount (USD)</p>
                        <p class="text-xl font-bold text-green-600">${{ number_format($order->dollar_price ?? 0, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Amount (NGN)</p>
                        <p class="text-xl font-bold text-green-600">₦{{ number_format($order->naira_price ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User & Status Information -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Customer Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <div class="flex items-center mb-4">
                <div class="bg-indigo-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-900">Customer</h3>
                    <p class="text-sm text-gray-500">Order customer details</p>
                </div>
            </div>
            <div class="space-y-3">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email</p>
                    <p class="text-sm font-medium text-gray-900">{{ $order->user->email ?? 'N/A' }}</p>
                </div>
                @if($order->user && $order->user->metaData)
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</p>
                        <p class="text-sm font-medium text-gray-900">
                            {{ trim(($order->user->metaData->first_name ?? '') . ' ' . ($order->user->metaData->last_name ?? '')) ?: 'Not provided' }}
                        </p>
                    </div>
                @endif
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.user-details', $order->user->id) }}" 
                   class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    View user profile
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Order Status -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-900">Current Status</h3>
                    <p class="text-sm text-gray-500">Order processing status</p>
                </div>
            </div>
            <div class="space-y-3">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status</p>
                    @php 
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'processing' => 'bg-blue-100 text-blue-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'confirmed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                            'canceled' => 'bg-red-100 text-red-800',
                        ];
                        $statusColor = $statusColors[$order->transaction_status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium {{ $statusColor }}">
                        {{ ucfirst($order->transaction_status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <div class="flex items-center mb-4">
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-900">Timeline</h3>
                    <p class="text-sm text-gray-500">Important dates</p>
                </div>
            </div>
            <div class="space-y-3">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Date Ordered</p>
                    <p class="text-sm font-medium text-gray-900">{{ $order->created_at->format('M d, Y H:i') }}</p>
                </div>
                @if($order->confirmed_at)
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Date Confirmed</p>
                        <p class="text-sm font-medium text-gray-900">{{ $order->confirmed_at }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>