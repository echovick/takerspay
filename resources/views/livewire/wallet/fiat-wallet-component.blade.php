<div
    class="w-full max-w p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 dark:bg-gray-800 dark:border-gray-700">
    <h5 class="mb-3 text-base font-semibold text-gray-900 md:text-xl dark:text-white">
        Connect Bank Account
    </h5>
    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Enter your naira bank account to receive funds</p>
    @if (isset($fiatWallets) && $fiatWallets->count() > 0)
        @foreach ($fiatWallets as $wallet)
            <ul class="my-4 space-y-3">
                <li class="mb-3">
                    <a href="#"
                        class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 14a3 3 0 0 1 3-3h4a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-4a3 3 0 0 1-3-3Zm3-1a1 1 0 1 0 0 2h4v-2h-4Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M12.293 3.293a1 1 0 0 1 1.414 0L16.414 6h-2.828l-1.293-1.293a1 1 0 0 1 0-1.414ZM12.414 6 9.707 3.293a1 1 0 0 0-1.414 0L5.586 6h6.828ZM4.586 7l-.056.055A2 2 0 0 0 3 9v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2h-4a5 5 0 0 1 0-10h4a2 2 0 0 0-1.53-1.945L17.414 7H4.586Z"
                                clip-rule="evenodd" />
                        </svg>

                        <span class="flex-1 text-sm ms-3 whitespace-nowrap px-3">{{ $wallet->bank_name }}
                            ({{ $wallet->account_number }})</span>
                        <span
                            class="inline-flex items-center justify-center px-2 py-0.5 ms-3 text-xs font-medium text-white rounded">
                            <span data-modal-target="edit-bank-account-modal"
                                data-modal-toggle="edit-bank-account-modal"
                                wire:click="selectWallet('{{ $wallet->id }}')" type="button"><x-icons.edit /></span>
                            <span wire:click="deleteWallet('{{ $wallet->id }}')"
                                wire:confirm="Are you sure you want to delete this wallet?"> <x-icons.trash /></span>
                        </span>
                    </a>
                </li>
            </ul>
        @endforeach
    @else
        <x-alerts.info-alert> You do not have any connected wallets, please click the add button to add a crypto wallet
        </x-alerts.info-alert>
    @endif
    <button data-modal-target="add-bank-account-modal" data-modal-toggle="add-bank-account-modal" type="button"
        class="px-3 py-2 mb-3 text-xs font-medium text-center text-white bg-primary-1000 rounded-lg hover:bg-primary-1100 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
        Account</button>
    <div>
        <a href="#"
            class="inline-flex items-center text-xs font-normal text-gray-500 hover:underline dark:text-gray-400">
            <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7.529 7.988a2.502 2.502 0 0 1 5 .191A2.441 2.441 0 0 1 10 10.582V12m-.01 3.008H10M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            Why do I need to connect my bank account?</a>
    </div>
    @include('app.includes.wallet.add-bank-account-modal')
    @include('app.includes.wallet.edit-bank-account-modal')
</div>
