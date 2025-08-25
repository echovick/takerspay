<div class="w-full mb-3 max-w p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 dark:bg-gray-800 dark:border-gray-700">
    <h5 class="mb-3 text-base font-semibold text-gray-900 md:text-xl dark:text-white">
        Connect Crypto wallet
    </h5>
    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
        Connect with one of our available wallet providers or create a new one.
    </p>
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

                        <span class="flex-1 text-sm ms-3 whitespace-nowrap px-3">{{ $wallet->asset?->name ?? 'Unknown Asset' }} ({{ $wallet->asset?->slug ?? 'N/A' }})</span>
                        <span
                            class="inline-flex items-center justify-center px-2 py-0.5 ms-3 text-xs font-medium text-white rounded">
                            <span data-modal-target="edit-crypto-wallet-modal" data-modal-toggle="edit-crypto-wallet-modal" wire:click="selectWallet('{{ $wallet->id }}')" type="button"><x-icons.edit /></span>
                            <span wire:click="deleteWallet('{{ $wallet->id }}')" wire:confirm="Are you sure you want to delete this wallet?"> <x-icons.trash /></span>
                        </span>
                    </a>
                </li>
            </ul>
        @endforeach
    @else
        <x-alerts.info-alert> You do not have any connected wallets, please click the add button to add a crypto wallet </x-alerts.info-alert>
    @endif
    <button data-modal-target="add-crypto-wallet-modal" data-modal-toggle="add-crypto-wallet-modal" type="button"
        class="px-3 py-2 mb-3 text-xs font-medium text-center text-white bg-primary-1000 rounded-lg hover:bg-primary-1100 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
        Wallet</button>
    <div>
        <a href="#"
            class="inline-flex items-center text-xs font-normal text-gray-500 hover:underline dark:text-gray-400">
            <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7.529 7.988a2.502 2.502 0 0 1 5 .191A2.441 2.441 0 0 1 10 10.582V12m-.01 3.008H10M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            Why do I need to connect with my wallet?</a>
    </div>
    @include('app.includes.wallet.add-crypto-wallet-modal')
    @include('app.includes.wallet.edit-crypto-wallet-modal')
</div>
