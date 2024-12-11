<div class="w-full max-w p-4 bg-white border border-gray-200 rounded-lg sm:p-8 dark:bg-gray-800 dark:border-gray-700">
    <div class="flex items-center justify-between mb-4">
        <h5 class="text-md font-bold leading-none text-gray-900 dark:text-white">Order History</h5>
        <a href="{{ route('app.all-orders') }}"
            class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
            View all
        </a>
    </div>
    <div class="flow-root">
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
            @if ($recentOrders->count() > 0)
                @foreach ($recentOrders as $order)
                <li class="py-3 sm:py-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            @if ($order->asset == 'crypto')
                                <img class="w-8 h-8 rounded-full" src="{{ asset('assets/imgs/crypto-icon.png') }}" alt="Neil image">
                            @else
                                <img class="w-8 h-8 rounded-full" src="{{ asset('assets/imgs/giftcard-icon.png') }}" alt="Neil image">
                            @endif
                        </div>
                        <div class="flex-1 min-w-0 ms-4">
                            <a href="{{ route('app.order').'?ref='.$order->reference }}" class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                {{ ucwords($order->asset) }} {{ ucwords($order->type) }} Order
                            </a>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                @php
                                    $transactionDate = \Carbon\Carbon::parse($order->created_at)->format('l, F j, Y');
                                @endphp
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            &#8358;{{ number_format($order->naira_price,2) ?? 0 }}
                        </div>
                    </div>
                </li>
                @endforeach
            @else
                <small>You've not made any order yet, click the plus sign to start</small>
            @endif
        </ul>
    </div>
</div>
