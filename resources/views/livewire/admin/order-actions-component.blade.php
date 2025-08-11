<div>
    <!-- Action Buttons and Status Update -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-900">Order Actions</h2>
        </div>
        <div class="p-6">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Status Update Section -->
                <div class="flex-1">
                    <div class="mb-4">
                        <label for="orderStatus" class="block text-sm font-medium text-gray-700 mb-2">
                            Update Order Status
                        </label>
                        <div class="flex gap-3">
                            <select wire:model="newStatus" id="orderStatus" 
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="canceled">Canceled</option>
                            </select>
                            <button wire:click="updateOrderStatus" 
                                class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <span wire:loading.remove wire:target="updateOrderStatus">Update</span>
                                <span wire:loading wire:target="updateOrderStatus">Updating...</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons Section -->
                <div class="flex-1">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Quick Actions
                        </label>
                        <div class="flex flex-wrap gap-3">
                            <!-- User Profile Button -->
                            <a href="{{ route('admin.user-details', $order->user->id) }}" 
                               class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg text-indigo-600 bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                User Profile
                            </a>

                            <!-- User Wallets Button -->
                            <button type="button" onclick="showUserWalletsModal()" 
                                class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg text-blue-600 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                User Wallets
                            </button>

                            <!-- Export Button -->
                            <button type="button" onclick="exportOrderDetails()" 
                                class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg text-green-600 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Export
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session()->has('success'))
        <div class="mt-4 bg-green-500 text-white px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="mt-4 bg-red-500 text-white px-4 py-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- User Wallets Modal (Simple placeholder) -->
    <div id="userWalletsModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">User Wallets</h3>
                    <button onclick="hideUserWalletsModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @if($order->user && $order->user->wallets)
                        @foreach($order->user->wallets as $wallet)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h4 class="font-medium text-gray-900 capitalize">{{ $wallet->type }} Wallet</h4>
                                        <p class="text-sm text-gray-500">{{ $wallet->currency }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">{{ number_format($wallet->balance, 8) }}</p>
                                        <p class="text-xs text-gray-500">{{ $wallet->status }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 text-center">No wallets found for this user.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function showUserWalletsModal() {
            document.getElementById('userWalletsModal').classList.remove('hidden');
            document.getElementById('userWalletsModal').classList.add('flex');
        }
        
        function hideUserWalletsModal() {
            document.getElementById('userWalletsModal').classList.add('hidden');
            document.getElementById('userWalletsModal').classList.remove('flex');
        }
        
        function exportOrderDetails() {
            // Placeholder for export functionality
            alert('Export functionality would be implemented here');
        }
    </script>
</div>