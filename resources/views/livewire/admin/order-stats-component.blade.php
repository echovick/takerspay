<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Total Orders Card -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-lg relative overflow-hidden">
        <div class="absolute h-full w-1 bg-blue-600 left-0 top-0"></div>
        <div class="p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Orders</p>
                    <p class="text-xl font-bold text-gray-800">{{ number_format($totalOrders) }}</p>
                    <div class="flex items-center mt-1 text-xs">
                        <span class="text-green-500 flex items-center mr-2">
                            <span class="inline-flex h-2 w-2 rounded-full bg-green-500 mr-1"></span>
                            {{ number_format($completedOrders) }} completed
                        </span>
                        <span class="text-blue-500">+{{ number_format($todaysOrders) }} today</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Status Card -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-lg relative overflow-hidden">
        <div class="absolute h-full w-1 bg-orange-600 left-0 top-0"></div>
        <div class="p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pending Orders</p>
                    <p class="text-xl font-bold text-gray-800">{{ number_format($pendingOrders) }}</p>
                    <div class="flex items-center mt-1 text-xs space-x-2">
                        <span class="text-blue-500">{{ number_format($processingOrders) }} processing</span>
                        <span class="text-red-500">{{ number_format($canceledOrders) }} canceled</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Value Card -->
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
                    <p class="text-gray-500 text-sm font-medium">Total Value</p>
                    <p class="text-xl font-bold text-gray-800">₦{{ number_format($totalValue, 2) }}</p>
                    <div class="flex items-center mt-1 text-xs">
                        <span class="text-blue-500">Avg: ₦{{ number_format($averageOrderValue, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Types Card -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-lg relative overflow-hidden">
        <div class="absolute h-full w-1 bg-purple-600 left-0 top-0"></div>
        <div class="p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Asset Types</p>
                    <p class="text-xl font-bold text-gray-800">{{ number_format($cryptoOrders + $giftcardOrders) }}</p>
                    <div class="flex items-center mt-1 text-xs space-x-2">
                        <span class="text-blue-500">{{ number_format($cryptoOrders) }} crypto</span>
                        <span class="text-green-500">{{ number_format($giftcardOrders) }} giftcard</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>