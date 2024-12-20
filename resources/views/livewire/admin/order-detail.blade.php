<div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <div class="flex justify-between items-center mb-4">
        <h5 class="text-md font-bold text-gray-900 dark:text-white">Order Summary</h5>
        <form>
            <select id="small" wire:model.live="status" wire:change="updateStatus"
                class="block w-full p-2 mb-6 text-xs text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Change Order Status</option>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="canceled">Cancel</option>
                <option value="confirmed">Confirm</option>
                <option value="processing">Processing</option>
            </select>
        </form>
    </div>
    @if (isset($successMsg))
        <x-alerts.info-alert> {{ $successMsg }} </x-alerts.info-alert>
    @endif
    @if (isset($errorMsg))
        <x-alerts.danger-alert> {{ $errorMsg }} </x-alerts.info-alert>
    @endif
    <div class="inline-flex rounded-md shadow-sm mb-4 w-100" role="group">
        <button type="button"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
            <x-icons.eye />
            <span class="px-2 text-xs">User Profile</span>
        </button>
        <button type="button"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
            <x-icons.bitcoin />
            <span class="px-2 text-xs">User Crypto Wallets</span>
        </button>
        <button type="button"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
            <x-icons.cash />
            <span class="px-2 text-xs">User Bank Accounts</span>
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800">
            <tbody>
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        User
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->user->email }}
                    </td>
                </tr>
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        Reference
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->reference }}
                    </td>
                </tr>
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        Type
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->type }}
                    </td>
                </tr>
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        Asset
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->asset }}
                    </td>
                </tr>
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        Asset Value
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->asset_value }}
                    </td>
                </tr>
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        Amount In Dollar
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->dollar_price }}
                    </td>
                </tr>
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        Amount In Naira
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->naira_price }}
                    </td>
                </tr>
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        Status
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->transaction_status }}
                    </td>
                </tr>
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        Date Confirmed
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->confirmed_at }}
                    </td>
                </tr>
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        Date Ordered
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->confirmed_at }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
