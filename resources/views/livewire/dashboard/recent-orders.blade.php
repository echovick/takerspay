<div class="w-full max-w p-4 bg-white border border-gray-200 rounded-lg sm:p-8 dark:bg-gray-800 dark:border-gray-700">
    <div class="flex items-center justify-between mb-4">
        <h5 class="text-md font-bold leading-none text-gray-1000 dark:text-white">Order History</h5>
        <a href="{{ route('app.all-orders') }}"
            class="text-sm font-medium text-primary-1010 hover:underline dark:text-blue-500">
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
                                    <img class="w-8 h-8 rounded-full" src="{{ asset('assets/imgs/crypto-icon.png') }}"
                                        alt="Crypto image">
                                @else
                                    <img class="w-8 h-8 rounded-full" src="{{ asset('assets/imgs/giftcard-icon.png') }}"
                                        alt="Giftcard image">
                                @endif
                            </div>
                            <div class="flex-1 min-w-0 ms-4">
                                <a href="{{ route('app.order') . '?ref=' . $order->reference }}"
                                    class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ ucwords($order->asset) }} {{ ucwords($order->type) }} Order
                                    @switch($order->transaction_status)
                                        @case('pending')
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-xs font-medium mx-3 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">Pending</span>
                                        @break

                                        @case('completed')
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">Completed</span>
                                        @break

                                        @case('canceled')
                                            <span
                                                class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">Cancelled</span>
                                        @break

                                        @case('confirmed')
                                            <span
                                                class="bg-purple-100 text-purple-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-purple-400 border border-purple-400">Confirmed</span>
                                        @break

                                        @default
                                    @endswitch
                                </a>
                                <p class="text-xs text-gray-500 truncate dark:text-gray-400">
                                    @php
                                        $transactionDate = \Carbon\Carbon::parse($order->created_at)->format(
                                            'l, F j, Y',
                                        );
                                    @endphp
                                    {{ $transactionDate }}
                                </p>
                            </div>
                            @php
                                $assetValue =
                                    $order?->type == 'buy'
                                        ? $order?->asset_value * $order?->assetInfo?->naira_buy_rate
                                        : $order?->asset_value * $order?->assetInfo?->naira_sell_rate;
                            @endphp
                            <div
                                class="inline-flex text-sm items-center text-base font-semibold text-gray-900 dark:text-white">
                                &#8358;{{ number_format($assetValue, 2) ?? 0 }}
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
