<div>
    <form class="max-w mx-auto mb-4">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="search" id="default-search"
                class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search Past Orders..." />
        </div>
    </form>

    <div
        class="w-full max-w p-4 bg-white border border-gray-200 rounded-lg sm:p-8 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full">
            <div class="grid max-w grid-cols-3 gap-1 p-1 mx-auto mb-3 bg-gray-100 rounded-lg dark:bg-gray-600"
                role="group">
                <button type="button"
                    class="px-5 py-1.5 text-xs font-medium text-white bg-blue-900 dark:bg-gray-300 dark:text-gray-900 rounded-lg">
                    Pending
                </button>
                <button type="button"
                    class="px-5 py-1.5 text-xs font-medium text-gray-900 hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700 rounded-lg">
                    Completed
                </button>
                <button type="button"
                    class="px-5 py-1.5 text-xs font-medium text-gray-900 hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700 rounded-lg">
                    Cancled
                </button>
            </div>
        </div>
        <div class="flow-root">
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                @if ($data['history']->count() > 0)
                    @foreach ($data['history'] as $order)
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if ($order->asset == 'crypto')
                                        <img class="w-8 h-8 rounded-full"
                                            src="{{ asset('assets/imgs/crypto-icon.png') }}" alt="Neil image">
                                    @else
                                        <img class="w-8 h-8 rounded-full"
                                            src="{{ asset('assets/imgs/giftcard-icon.png') }}" alt="Neil image">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0 ms-4">
                                    <a href="{{ route('app.order') . '?ref=' . $order->reference }}"
                                        class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ ucwords($order->asset) }} {{ ucwords($order->type) }} Order
                                    </a>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                        @php
                                            $transactionDate = \Carbon\Carbon::parse($order->created_at)->format(
                                                'l, F j, Y',
                                            );
                                        @endphp
                                    </p>
                                </div>
                                <div
                                    class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    &#8358;{{ number_format($order->naira_price, 2) ?? 0 }}
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
</div>
