<!-- User Details -->
<div id="user-profile-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    User Details
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="user-profile-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <tbody>
                        <tr>
                            <td
                                class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                                Email
                            </td>
                            <td
                                class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                                {{ $order->user->email ?? "N/A" }}
                            </td>
                        </tr>
                        <tr>
                            <td
                                class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                                Phone
                            </td>
                            <td
                                class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                                {{ $order->user->phone ?? "N/A" }}
                            </td>
                        </tr>
                        <tr>
                            <td
                                class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-700 dark:text-gray-400">
                                User Tag
                            </td>
                            <td
                                class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-400">
                                {{ $order->user->metaData->tag ?? "N/A" }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- User Crypto Wallets -->
<div id="user-crypto-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    User Crypto Wallets
                </h3>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                @if (isset($cryptoWallets) && $cryptoWallets->count() > 0)
                    @foreach ($cryptoWallets as $wallet)
                        <ul class="my-4 space-y-3">
                            <li class="mb-3">
                                <a href="#"
                                    class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M10.7367 14.5876c.895.2365 2.8528.754 3.1643-.4966.3179-1.2781-1.5795-1.7039-2.5053-1.9117-.1034-.0232-.1947-.0437-.2694-.0623l-.6025 2.4153c.0611.0152.1328.0341.2129.0553Zm.8452-3.5291c.7468.1993 2.3746.6335 2.6581-.5025.2899-1.16213-1.2929-1.5124-2.066-1.68348-.0869-.01923-.1635-.03619-.2262-.0518l-.5462 2.19058c.0517.0129.1123.0291.1803.0472Z" />
                                        <path fill="currentColor" fill-rule="evenodd"
                                            d="M9.57909 21.7008c5.35781 1.3356 10.78401-1.9244 12.11971-7.2816 1.3356-5.35745-1.9247-10.78433-7.2822-12.11995C9.06034.963624 3.6344 4.22425 2.2994 9.58206.963461 14.9389 4.22377 20.3652 9.57909 21.7008ZM14.2085 8.0526c1.3853.47719 2.3984 1.1925 2.1997 2.5231-.1441.9741-.6844 1.4456-1.4013 1.6116.9844.5128 1.485 1.2987 1.0078 2.6612-.5915 1.6919-1.9987 1.8347-3.8697 1.4807l-.454 1.8196-1.0972-.2734.4481-1.7953c-.2844-.0706-.575-.1456-.8741-.2269l-.44996 1.8038-1.09594-.2735.45407-1.8234c-.10059-.0258-.20185-.0522-.30385-.0788-.15753-.0411-.3168-.0827-.47803-.1231l-1.42812-.3559.54468-1.2563s.80844.215.7975.1991c.31063.0769.44844-.1256.50282-.2606l.71781-2.8766.11562.0288c-.04375-.0175-.08343-.0288-.11406-.0366l.51188-2.05344c.01375-.23312-.06688-.52719-.51125-.63812.01718-.01157-.79688-.19813-.79688-.19813l.29188-1.17187 1.51313.37781-.0013.00562c.2275.05657.4619.11032.7007.16469l.4497-1.80187 1.0965.27343-.4406 1.76657c.2944.06718.5906.135.8787.20687l.4375-1.755 1.0975.27344-.4493 1.8025Z"
                                            clip-rule="evenodd" />
                                    </svg>

                                    <span class="flex-1 text-sm ms-3 whitespace-nowrap px-3">{{ $wallet->asset->name }} ({{ $wallet->asset->slug }}) - {{ $wallet->crypto_wallet_number }}</span>
                                    <span class="inline-flex items-center justify-center px-2 py-0.5 ms-3 text-xs font-medium text-white rounded">
                                    </span>
                                </a>
                            </li>
                        </ul>
                    @endforeach
                @else
                    <x-alerts.info-alert> User doesnt have a crypto wallet connected </x-alerts.info-alert>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- User Bank Accounts Wallets -->
<div id="user-bank-accounts-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    User Crypto Wallets
                </h3>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                @if (isset($bankAccounts) && $bankAccounts->count() > 0)
                    @foreach ($bankAccounts as $account)
                        <ul class="my-4 space-y-3">
                            <li class="mb-3">
                                <a href="#"
                                    class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                                    <x-icons.cash />
                                    <span class="flex-1 text-sm ms-3 whitespace-nowrap px-3">{{ $account?->bank_name }}
                                        ({{ $account->account_number }} @ {{ $account?->account_name }})</span>
                                    <span class="inline-flex items-center justify-center px-2 py-0.5 ms-3 text-xs font-medium text-white rounded">
                                    </span>
                                </a>
                            </li>
                        </ul>
                    @endforeach
                @else
                    <x-alerts.info-alert> User doesnt have a bank account added </x-alerts.info-alert>
                @endif
            </div>
        </div>
    </div>
</div>
