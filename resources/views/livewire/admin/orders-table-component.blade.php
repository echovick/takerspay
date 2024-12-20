<div class="mt-6 relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <caption
            class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
            All Orders
            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Browse all customer orders from here</p>
        </caption>
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Order Ref
                </th>
                <th scope="col" class="px-6 py-3">
                    User
                </th>
                <th scope="col" class="px-6 py-3">
                    Trade Type
                </th>
                <th scope="col" class="px-6 py-3">
                    Asset
                </th>
                <th scope="col" class="px-6 py-3">
                    Amount
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @if (isset($orders) && $orders->count() > 0)
                @foreach ($orders as $order)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $order->reference }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $order->user->email }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->type }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->asset }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">
                                {{ $order->transaction_status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            ₦{{ number_format($order->naira_price,2) }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.order-details') }}?ref={{ $order->reference }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
