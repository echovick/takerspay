<div>
    <!-- Wallet Action Buttons -->
    <div class="flex flex-wrap gap-3 mb-6">
        <button wire:click="openDepositModal"
            class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg text-white bg-indigo-600 shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150">
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Deposit
        </button>
        <button wire:click="openWithdrawModal"
            class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg text-white bg-emerald-600 shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition duration-150">
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
            </svg>
            Withdraw
        </button>
        <button wire:click="openTransferModal"
            class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg text-white bg-blue-600 shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
            </svg>
            Transfer
        </button>
    </div>

    <!-- Deposit Modal -->
    @if ($showDepositModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Deposit to Wallet</h3>
                        <button wire:click="closeDepositModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <form wire:submit="processDeposit" class="px-6 py-4">
                    <div class="space-y-4">
                        <!-- Wallet Type -->
                        <div>
                            <label for="depositWalletType" class="block text-sm font-medium text-gray-700 mb-1">Wallet
                                Type *</label>
                            <select wire:model="depositWalletType" id="depositWalletType" disabled
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed text-sm">
                                <option value="nuban">Fiat Wallet (NGN)</option>
                            </select>
                            @error('depositWalletType')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="depositAmount" class="block text-sm font-medium text-gray-700 mb-1">Amount
                                *</label>
                            <input type="number" wire:model="depositAmount" id="depositAmount" step="0.01"
                                min="0.01" placeholder="0.00"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            @error('depositAmount')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="depositDescription"
                                class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                            <textarea wire:model="depositDescription" id="depositDescription" rows="3"
                                placeholder="Reason for this deposit..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm"></textarea>
                            @error('depositDescription')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-6 pt-4 border-t border-gray-200">
                        <button type="button" wire:click="closeDepositModal"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                            <span wire:loading.remove wire:target="processDeposit">Process Deposit</span>
                            <span wire:loading wire:target="processDeposit">Processing...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Withdraw Modal -->
    @if ($showWithdrawModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Withdraw from Wallet</h3>
                        <button wire:click="closeWithdrawModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <form wire:submit="processWithdraw" class="px-6 py-4">
                    <div class="space-y-4">
                        <!-- Wallet Type -->
                        <div>
                            <label for="withdrawWalletType" class="block text-sm font-medium text-gray-700 mb-1">Wallet
                                Type *</label>
                            <select wire:model="withdrawWalletType" id="withdrawWalletType" disabled
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed text-sm">
                                <option value="nuban">Fiat Wallet (NGN)</option>
                            </select>
                            @error('withdrawWalletType')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="withdrawAmount" class="block text-sm font-medium text-gray-700 mb-1">Amount
                                *</label>
                            <input type="number" wire:model="withdrawAmount" id="withdrawAmount" step="0.01"
                                min="0.01" placeholder="0.00"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            @error('withdrawAmount')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Bank Account -->
                        <div>
                            <label for="withdrawBankAccount" class="block text-sm font-medium text-gray-700 mb-1">Bank
                                Account *</label>
                            <select wire:model="withdrawBankAccount" id="withdrawBankAccount"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                <option value="">Select Bank Account</option>
                                @foreach ($availableBankAccounts as $account)
                                    <option value="{{ $account['id'] }}">{{ $account['display'] }}</option>
                                @endforeach
                            </select>
                            @error('withdrawBankAccount')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                            @if (empty($availableBankAccounts))
                                <p class="text-yellow-600 text-xs mt-1">No active bank accounts found for this user.
                                </p>
                            @endif
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="withdrawDescription"
                                class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                            <textarea wire:model="withdrawDescription" id="withdrawDescription" rows="3"
                                placeholder="Reason for this withdrawal..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm"></textarea>
                            @error('withdrawDescription')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-6 pt-4 border-t border-gray-200">
                        <button type="button" wire:click="closeWithdrawModal"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit" @if (empty($availableBankAccounts)) disabled @endif
                            class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg disabled:bg-gray-400 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="processWithdraw">Process Withdrawal</span>
                            <span wire:loading wire:target="processWithdraw">Processing...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Transfer Modal -->
    @if ($showTransferModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Transfer Between Wallets</h3>
                        <button wire:click="closeTransferModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <form wire:submit="processTransfer" class="px-6 py-4">
                    <div class="space-y-4">
                        <!-- From Wallet -->
                        <div>
                            <label for="transferFromWalletType"
                                class="block text-sm font-medium text-gray-700 mb-1">From Wallet *</label>
                            <select wire:model="transferFromWalletType" id="transferFromWalletType" disabled
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed text-sm">
                                <option value="nuban">Fiat Wallet (NGN)</option>
                            </select>
                            @error('transferFromWalletType')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="transferAmount" class="block text-sm font-medium text-gray-700 mb-1">Amount
                                *</label>
                            <input type="number" wire:model="transferAmount" id="transferAmount" step="0.01"
                                min="0.01" placeholder="0.00"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @error('transferAmount')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Recipient User Search -->
                        <div>
                            <label for="userSearchTerm" class="block text-sm font-medium text-gray-700 mb-1">Recipient
                                User *</label>
                            <div class="relative">
                                <input type="text" wire:model.live="userSearchTerm"
                                    wire:keyup="searchUsersForTransfer" id="userSearchTerm"
                                    placeholder="Search by name or email..."
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">

                                @if (!empty($searchUsers))
                                    <div
                                        class="absolute z-10 w-full bg-white border border-gray-300 rounded-lg mt-1 max-h-48 overflow-y-auto shadow-lg">
                                        @foreach ($searchUsers as $searchUser)
                                            <div wire:click="selectTransferUser({{ $searchUser['id'] }})"
                                                class="px-3 py-2 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0">
                                                <div class="font-medium text-sm">{{ $searchUser['display'] }}</div>
                                                <div class="text-xs text-gray-500">{{ $searchUser['email'] }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            @error('transferToUserId')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- To Wallet -->
                        <div>
                            <label for="transferToWalletType" class="block text-sm font-medium text-gray-700 mb-1">To
                                Wallet *</label>
                            <select wire:model="transferToWalletType" id="transferToWalletType" disabled
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed text-sm">
                                <option value="nuban">Fiat Wallet (NGN)</option>
                            </select>
                            @error('transferToWalletType')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="transferDescription"
                                class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                            <textarea wire:model="transferDescription" id="transferDescription" rows="3"
                                placeholder="Reason for this transfer..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                            @error('transferDescription')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-6 pt-4 border-t border-gray-200">
                        <button type="button" wire:click="closeTransferModal"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                            <span wire:loading.remove wire:target="processTransfer">Process Transfer</span>
                            <span wire:loading wire:target="processTransfer">Processing...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Success/Error Messages -->
    @if (session()->has('success'))
        <div class="mb-4 bg-green-500 text-white px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 bg-red-500 text-white px-4 py-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif
</div>
