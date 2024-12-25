<div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <div class="flex justify-between items-center mb-4">
        <div>
            <span
                class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">{{ $this->order?->transaction_status }}</span><br>
            <h5 class="text-md font-bold text-gray-900 dark:text-white">Order Summary</h5>
        </div>
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
        <button type="button" data-modal-target="user-profile-modal" data-modal-toggle="user-profile-modal"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
            <x-icons.eye />
            <span class="px-2 text-xs">User Profile</span>
        </button>
        <button type="button" data-modal-target="user-crypto-modal" data-modal-toggle="user-crypto-modal"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
            <x-icons.bitcoin />
            <span class="px-2 text-xs">User Crypto Wallets</span>
        </button>
        <button type="button" data-modal-target="user-bank-accounts-modal" data-modal-toggle="user-bank-accounts-modal"
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
                        {{ $order->user->email ?? 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        Reference
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->reference ?? 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        Type
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->type ?? 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        Asset
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->asset ?? 'N/A' }}
                    </td>
                </tr>
                @if ($order->asset = 'giftcard')
                    <tr>
                        <td
                            class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                            Gift Card Currency
                        </td>
                        <td
                            class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                            {{ $order->trade_currency ?? 'N/A' }}
                        </td>
                    </tr>
                @endif
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        Asset Value
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->asset_value ?? 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        Amount In Dollar
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->dollar_price ?? 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        Amount In Naira
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->naira_price ?? 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        Status
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->transaction_status ?? 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        Date Confirmed
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->confirmed_at ?? 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                        Date Ordered
                    </td>
                    <td
                        class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                        {{ $order->confirmed_at ?? 'N/A' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @include('admin.includes.user-details-modal')
</div>
