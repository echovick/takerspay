<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div class="flex justify-between items-center pb-4">
        <div class="flex gap-4 items-center">
            <!-- Date Filter -->
            <select wire:model.live="dateFilter" class="px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                <option value="all">All Time</option>
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
                <option value="year">This Year</option>
            </select>
            
            <!-- Per Page -->
            <select wire:model.live="perPage" class="px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
            </select>
        </div>
        
        <div class="text-sm text-gray-600">
            Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() ?? 0 }} orders
        </div>
    </div>
    
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    S/N
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('reference')">
                    <div class="flex items-center">
                        Order Reference
                        @if($sortBy === 'reference')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3">
                    Customer
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('type')">
                    <div class="flex items-center">
                        Type
                        @if($sortBy === 'type')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('asset')">
                    <div class="flex items-center">
                        Asset
                        @if($sortBy === 'asset')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('naira_price')">
                    <div class="flex items-center">
                        Amount
                        @if($sortBy === 'naira_price')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('created_at')">
                    <div class="flex items-center">
                        Date Created
                        @if($sortBy === 'created_at')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $index => $order)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $orders->firstItem() + $index }}
                    </th>
                    <td class="px-6 py-4">
                        <div class="font-mono text-sm text-blue-600">{{ $order->reference }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-medium text-sm mr-3">
                                @if($order->user && $order->user->metaData)
                                    @php
                                        $name = trim(($order->user->metaData->first_name ?? '') . ' ' . ($order->user->metaData->last_name ?? ''));
                                        if (!empty($name)) {
                                            $names = explode(' ', $name);
                                            $initials = strtoupper(substr($names[0], 0, 1));
                                            if (count($names) > 1) {
                                                $initials .= strtoupper(substr(end($names), 0, 1));
                                            }
                                        } else {
                                            $initials = strtoupper(substr($order->user->email, 0, 2));
                                        }
                                    @endphp
                                    {{ $initials }}
                                @else
                                    UN
                                @endif
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">
                                    {{ $order->user ? $order->user->email : 'N/A' }}
                                </div>
                                @if($order->user && $order->user->metaData)
                                    <div class="text-xs text-gray-500">
                                        {{ trim(($order->user->metaData->first_name ?? '') . ' ' . ($order->user->metaData->last_name ?? '')) ?: 'No name' }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($order->type)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $order->type === 'buy' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($order->type) }}
                            </span>
                        @else
                            <span class="text-gray-400">N/A</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($order->asset)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $order->asset === 'crypto' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ ucfirst($order->asset) }}
                            </span>
                        @else
                            <span class="text-gray-400">N/A</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">
                            {{ $this->formatOrderValue($order) }}
                        </div>
                        @if($order->asset_value)
                            <div class="text-xs text-gray-500">{{ number_format($order->asset_value, 2) }} {{ $order->trade_currency ?? 'Units' }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">
                            {{ $order->created_at->format('M d, Y') }}
                        </div>
                        <div class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @php $orderStatus = $this->getOrderStatus($order); @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $orderStatus['color'] === 'green' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $orderStatus['color'] === 'yellow' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $orderStatus['color'] === 'blue' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $orderStatus['color'] === 'red' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $orderStatus['color'] === 'gray' ? 'bg-gray-100 text-gray-800' : '' }}">
                            <span class="h-1.5 w-1.5 mr-1.5 rounded-full 
                                {{ $orderStatus['color'] === 'green' ? 'bg-green-500' : '' }}
                                {{ $orderStatus['color'] === 'yellow' ? 'bg-yellow-500' : '' }}
                                {{ $orderStatus['color'] === 'blue' ? 'bg-blue-500' : '' }}
                                {{ $orderStatus['color'] === 'red' ? 'bg-red-500' : '' }}
                                {{ $orderStatus['color'] === 'gray' ? 'bg-gray-500' : '' }}"></span>
                            {{ ucfirst($orderStatus['status']) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.order-details') }}?ref={{ $order->reference }}" 
                            class="text-blue-600 hover:text-blue-900 text-sm font-medium">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="px-6 py-8 text-center">
                        <div class="text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No orders found</h3>
                            <p class="mt-1 text-sm text-gray-500">No orders match your current filters.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $orders->links() }}
    </div>
</div>
