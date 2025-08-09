@extends('layout.app')

@section('content')
    @include('admin.includes.nav-bar')
    @include('admin.includes.side-bar')

    @php
        $orderRef = request()->get('ref');
        $order = App\Models\Order::where('reference', $orderRef)->first();
    @endphp

    <!-- Main Content - Responsive for both Mobile and Desktop -->
    <main class="p-[25px] md:ml-60 pt-[100px] bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Page Header -->
            <div class="mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                    <div class="flex items-center space-x-3 mb-2 sm:mb-0">
                        <a href="{{ route('admin.order-management') }}" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <h1 class="text-xl md:text-2xl font-bold text-gray-900">
                            Order Details
                        </h1>
                        @if($order)
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
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                <span class="w-1.5 h-1.5 mr-1.5 bg-current rounded-full opacity-75"></span>
                                {{ ucfirst($order->transaction_status) }}
                            </span>
                        @endif
                    </div>
                    <div class="text-sm text-gray-600">
                        <span class="hidden sm:inline">Ref: {{ $orderRef }} • </span>
                        @if($order)
                            Ordered {{ $order->created_at->format('M d, Y') }}
                        @endif
                    </div>
                </div>
                <p class="text-sm text-gray-600">Manage order details and communications</p>
            </div>

            @if($order)
                <!-- Order Details Section -->
                <div class="mb-6">
                    <livewire:admin.order-detail-info-component :order="$order" />
                </div>

                <!-- Order Actions Section -->
                <div class="mb-6">
                    <livewire:admin.order-actions-component :order="$order" />
                </div>

                <!-- Order Communication Section -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-4 sm:px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-white/20 p-2 rounded-full">
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.001 8.001 0 01-7.7-6M3 12c0-4.418 3.582-8 8-8s8 3.582 8 8-3.582 8-8 8c-4.418 0-8-3.582-8-8z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h2 class="text-sm sm:text-lg font-medium text-white">Order Communication</h2>
                                    <p class="text-xs text-white/80 hidden sm:block">Chat and updates for this order</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-white/20 text-white">
                                    <span class="w-2 h-2 mr-1 bg-green-400 rounded-full animate-pulse"></span>
                                    Active
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Chat Container -->
                    <div class="relative">
                        <div class="h-[400px] sm:h-[500px] lg:h-[600px] overflow-y-auto bg-gray-50 p-3 sm:p-4">
                            <div class="max-w-none">
                                <livewire:orders.order-record />
                            </div>
                        </div>
                        
                        <!-- Chat Input Area (placeholder for future enhancement) -->
                        <div class="border-t border-gray-200 bg-white p-3 sm:p-4">
                            <div class="flex items-center space-x-2 sm:space-x-3">
                                <button type="button" class="flex-shrink-0 p-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                    </svg>
                                </button>
                                <div class="flex-1 relative">
                                    <input type="text" 
                                           placeholder="Type a message..." 
                                           class="w-full px-3 sm:px-4 py-2 pr-10 text-sm border border-gray-300 rounded-full focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50" 
                                           disabled>
                                    <button type="button" class="absolute right-2 top-1/2 transform -translate-y-1/2 p-1 text-gray-400">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m2-10a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <button type="button" class="flex-shrink-0 inline-flex items-center px-3 sm:px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" disabled>
                                    <svg class="h-4 w-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    <span class="hidden sm:inline">Send</span>
                                </button>
                            </div>
                            
                            <!-- Quick Actions -->
                            <div class="mt-3 flex flex-wrap gap-2">
                                <button type="button" class="inline-flex items-center px-2 sm:px-3 py-1 text-xs font-medium rounded-full text-indigo-600 bg-indigo-50 hover:bg-indigo-100">
                                    <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Approve Order
                                </button>
                                <button type="button" class="inline-flex items-center px-2 sm:px-3 py-1 text-xs font-medium rounded-full text-yellow-600 bg-yellow-50 hover:bg-yellow-100">
                                    <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Request Info
                                </button>
                                <button type="button" class="inline-flex items-center px-2 sm:px-3 py-1 text-xs font-medium rounded-full text-red-600 bg-red-50 hover:bg-red-100">
                                    <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cancel Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Order Not Found -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">Order not found</h3>
                    <p class="mt-1 text-sm text-gray-500">The order reference "{{ $orderRef }}" could not be found.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.order-management') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Back to Orders
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection