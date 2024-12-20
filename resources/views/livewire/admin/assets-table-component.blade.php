<div>
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700" wire:ignore>
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="crypto-assets"
            data-tabs-toggle="#crypto-assets-content" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="fiat-assets" data-tabs-target="#profile"
                    type="button" role="tab" aria-controls="profile" aria-selected="false">Crypto Assets</button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="giftcards" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard"
                    aria-selected="false">Gift Cards</button>
            </li>
        </ul>
    </div>
    <div id="crypto-assets-content">
        <div class="hidden rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel"
            aria-labelledby="fiat-assets">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <div class="pb-4 bg-white dark:bg-gray-900">
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative mt-1 flex justify-between">
                        <div>
                            <div
                            class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="table-search"
                            class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search for items">
                        </div>
                            <button data-modal-target="create-asset-modal" data-modal-toggle="create-asset-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                New Asset
                              </button>

                    </div>
                </div>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-all-search" type="checkbox"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Asset Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Slug
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Type
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Available Units
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Buy Rate (/USD)
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Sell Rate (/USD)
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cryptoAssets as $asset)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-1" type="checkbox"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $asset->name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $asset->slug }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $asset->type }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $asset->available_units }}
                                </td>
                                <td class="px-6 py-4">
                                    ₦{{ number_format($asset->naira_buy_rate, 2) }}/$
                                </td>
                                <td class="px-6 py-4">
                                    ₦{{ number_format($asset->naira_sell_rate, 2) }}/$
                                </td>
                                <td class="px-6 py-4 flex">
                                    <a href="#" data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1" wire:click="selectAsset('{{ $asset->id }}')">Edit</a> |
                                    <a href="#"
                                        class="font-medium text-red-600 dark:text-blue-500 hover:underline mx-1" wire:click="deleteAsset('{{ $asset->id }}')" wire:confirm="Are you sure you want to delete this asset?">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel"
            aria-labelledby="giftcards">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <div class="pb-4 bg-white dark:bg-gray-900">
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative mt-1 flex justify-between">
                        <div>
                            <div
                            class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="table-search"
                            class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search for items">
                        </div>
                            <button data-modal-target="create-asset-modal" data-modal-toggle="create-asset-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                New Asset
                              </button>
                    </div>
                </div>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-all-search" type="checkbox"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Asset Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Slug
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Type
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Available Units
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Buy Rate (/USD)
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Sell Rate (/USD)
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($giftcards as $asset)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-1" type="checkbox"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $asset->name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $asset->slug }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $asset->type }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $asset->available_units }}
                                </td>
                                <td class="px-6 py-4">
                                    ₦{{ number_format($asset->naira_buy_rate, 2) }}/$
                                </td>
                                <td class="px-6 py-4">
                                    ₦{{ number_format($asset->naira_sell_rate, 2) }}/$
                                </td>
                                <td class="px-6 py-4">
                                    <a href="#" data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1" wire:click="selectAsset('{{ $asset->id }}')">Edit</a>|
                                    <a href="#"
                                        class="font-medium text-red-600 dark:text-blue-500 hover:underline mx-1" wire:click="deleteAsset('{{ $asset->id }}')" wire:confirm="Are you sure you want to delete this asset?">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('admin.includes.edit-asset-modal')
    @include('admin.includes.create-asset-modal')
</div>
