<
!-- Main modal -->
<div id="rates-details-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Our Rates
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="rates-details-modal">
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
                {{-- Crypto Rates --}}
                <div id="alert-additional-content-1" class="p-4 mb-4 text-black rounded-lg bg-primary-1050"
                    role="alert">
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <h3 class="text-sm font-medium">Cryptocurrency Rates</h3>
                    </div>
                    <div class="mt-2 mb-4 text-xs">
                        <table class="border-separate border-spacing-x-10 border-spacing-y-2 ms-[-35px]">
                            <thead>
                                <td></td>
                                <td class="text-sm font-bold">Buy</td>
                                <td class="text-sm font-bold">Sell</td>
                            </thead>
                            <tbody>
                                @foreach ($cryptoAssets as $asset)
                                <tr>
                                    <td class="text-sm font-bold">{{ ucwords($asset->name) }}:</td>
                                    <td>{{ $asset->naira_buy_rate > 1 ? $asset->naira_buy_rate : '--' }}/$</td>
                                    <td>{{ $asset->naira_buy_rate > 1 ? $asset->naira_sell_rate : '--' }}/$</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Gift Cards Rates --}}
                <div id="alert-additional-content-1" class="p-4 mb-4 text-black rounded-lg bg-primary-1050"
                    role="alert">
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <h3 class="text-sm font-medium">Gift Card Rates</h3>
                    </div>
                    <div class="mt-2 mb-4 text-xs">
                        <table class="border-separate border-spacing-x-10 border-spacing-y-2 ms-[-35px]">
                            <thead>
                                <td></td>
                                <td class="text-sm font-bold">Buy</td>
                                <td class="text-sm font-bold">Sell</td>
                            </thead>
                            <tbody>
                                @foreach ($giftcardAssets as $asset)
                                <tr>
                                    <td class="text-sm font-bold">{{ ucwords($asset->name) }}:</td>
                                    <td>{{ $asset->naira_buy_rate > 1 ? $asset->naira_buy_rate : '--' }}/$</td>
                                    <td>{{ $asset->naira_buy_rate > 1 ? $asset->naira_sell_rate : '--' }}/$</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="rates-details-modal" type="button"
                    class="text-white bg-primary-1000 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Close</button>
            </div>
        </div>
    </div>
</div>
