<div>
    <!-- Tab Navigation -->
    <div class="mb-4 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" role="tablist">
            <li class="me-2" role="presentation">
                <button wire:click="setActiveTab('crypto')" 
                    class="inline-block p-4 border-b-2 rounded-t-lg {{ $activeTab === 'crypto' ? 'text-blue-600 border-blue-600' : 'text-gray-500 border-transparent hover:text-gray-600 hover:border-gray-300' }}"
                    type="button" role="tab">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Crypto Wallets
                    </div>
                </button>
            </li>
            <li class="me-2" role="presentation">
                <button wire:click="setActiveTab('fiat')" 
                    class="inline-block p-4 border-b-2 rounded-t-lg {{ $activeTab === 'fiat' ? 'text-blue-600 border-blue-600' : 'text-gray-500 border-transparent hover:text-gray-600 hover:border-gray-300' }}"
                    type="button" role="tab">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        FundsPadi Wallet
                    </div>
                </button>
            </li>
        </ul>
    </div>

    <!-- Table Controls -->
    <div class="flex justify-between items-center mb-4">
        <div class="flex gap-4 items-center">
            <!-- Per Page -->
            <select wire:model.live="perPage" class="px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
            </select>
        </div>
        
        <div class="text-sm text-gray-600">
            Showing {{ $wallets->firstItem() ?? 0 }} to {{ $wallets->lastItem() ?? 0 }} of {{ $wallets->total() ?? 0 }} wallets
        </div>
    </div>

    <!-- Wallets Table -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">S/N</th>
                    <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('user_name')">
                        <div class="flex items-center">
                            User
                            @if($sortBy === 'user_name')
                                @if($sortDirection === 'asc')
                                    <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                @else
                                    <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                                @endif
                            @endif
                        </div>
                    </th>
                    @if($activeTab === 'crypto')
                        <th scope="col" class="px-6 py-3">Asset</th>
                        <th scope="col" class="px-6 py-3">Wallet Number</th>
                    @else
                        <th scope="col" class="px-6 py-3">Wallet Details</th>
                        <th scope="col" class="px-6 py-3">Account Number</th>
                    @endif
                    <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('balance')">
                        <div class="flex items-center">
                            Balance
                            @if($sortBy === 'balance')
                                @if($sortDirection === 'asc')
                                    <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                @else
                                    <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                                @endif
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('created_at')">
                        <div class="flex items-center">
                            Created
                            @if($sortBy === 'created_at')
                                @if($sortDirection === 'asc')
                                    <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                @else
                                    <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                                @endif
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($wallets as $index => $wallet)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $wallets->firstItem() + $index }}
                        </th>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @php
                                    $firstName = $wallet->user->metaData->first_name ?? '';
                                    $lastName = $wallet->user->metaData->last_name ?? '';
                                    $displayName = trim($firstName . ' ' . $lastName) ?: $wallet->user->email;
                                    $initials = $firstName && $lastName ? strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1)) : strtoupper(substr($wallet->user->email, 0, 2));
                                @endphp
                                <div class="h-8 w-8 rounded-full flex items-center justify-center text-white font-bold text-xs mr-3 bg-gradient-to-tr from-blue-500 to-cyan-600">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $displayName }}</div>
                                    <div class="text-xs text-gray-500">{{ $wallet->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        @if($activeTab === 'crypto')
                            <td class="px-6 py-4">
                                @if($wallet->asset)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $wallet->asset->name }}
                                    </span>
                                @else
                                    <span class="text-gray-500">No Asset</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-mono text-sm text-gray-900">{{ $wallet->crypto_wallet_number ?: 'Not Set' }}</div>
                            </td>
                        @else
                            <td class="px-6 py-4">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $wallet->bank_name ?: 'FundsPadi' }}</div>
                                    <div class="text-xs text-gray-500">{{ $wallet->account_name ?: 'Wallet Account' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-mono text-sm text-gray-900">{{ $wallet->account_number ?: 'Not Set' }}</div>
                            </td>
                        @endif
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">₦{{ number_format($wallet->balance, 2) }}</div>
                            <div class="text-xs text-gray-500">{{ $wallet->currency ?? 'NGN' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $wallet->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <span class="h-1.5 w-1.5 mr-1.5 rounded-full 
                                    {{ $wallet->status === 'active' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ ucfirst($wallet->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $wallet->created_at->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $wallet->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <button wire:click="openTransactionModal({{ $wallet->id }}, 'credit')" 
                                    onclick="console.log('Credit button clicked for wallet {{ $wallet->id }}, active tab: {{ $activeTab }}')"
                                    class="text-green-600 hover:text-green-900 text-sm font-medium" title="Credit Wallet">
                                    Credit
                                </button>
                                <span class="text-gray-300">|</span>
                                <button wire:click="openTransactionModal({{ $wallet->id }}, 'debit')" 
                                    onclick="console.log('Debit button clicked for wallet {{ $wallet->id }}, active tab: {{ $activeTab }}')"
                                    class="text-red-600 hover:text-red-900 text-sm font-medium" title="Debit Wallet">
                                    Debit
                                </button>
                                <span class="text-gray-300">|</span>
                                <button wire:click="toggleWalletStatus({{ $wallet->id }})" 
                                    class="text-blue-600 hover:text-blue-900 text-sm font-medium" title="Toggle Status">
                                    {{ $wallet->status === 'active' ? 'Disable' : 'Enable' }}
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center">
                            <div class="text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No {{ $activeTab === 'crypto' ? 'crypto wallets' : 'FundsPadi wallets' }} found</h3>
                                <p class="mt-1 text-sm text-gray-500">No wallets match your current filters.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $wallets->links() }}
        </div>
    </div>

    <!-- Transaction Modal -->
    @if($showTransactionModal && $selectedWallet)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-lg w-full">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ ucfirst($transactionType) }} Wallet
                        </h3>
                        <button wire:click="closeTransactionModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="mt-2">
                        @php
                            $firstName = $selectedWallet->user->metaData->first_name ?? '';
                            $lastName = $selectedWallet->user->metaData->last_name ?? '';
                            $userName = trim($firstName . ' ' . $lastName) ?: $selectedWallet->user->email;
                        @endphp
                        <p class="text-sm text-gray-600">
                            User: <strong>{{ $userName }}</strong>
                        </p>
                        <p class="text-sm text-gray-600">
                            Current Balance: <strong>₦{{ number_format($selectedWallet->balance, 2) }}</strong>
                        </p>
                    </div>
                </div>

                <!-- Modal Body -->
                <form wire:submit="processTransaction" class="px-6 py-4">
                    <div class="space-y-4">
                        <!-- Amount -->
                        <div>
                            <label for="transactionAmount" class="block text-sm font-medium text-gray-700 mb-1">
                                Amount *
                            </label>
                            <input type="number" wire:model="transactionAmount" id="transactionAmount" step="0.01" min="0.01" 
                                placeholder="Enter amount"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @error('transactionAmount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">Amount in Naira (₦)</p>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="transactionDescription" class="block text-sm font-medium text-gray-700 mb-1">
                                Description *
                            </label>
                            <textarea wire:model="transactionDescription" id="transactionDescription" rows="3"
                                placeholder="Enter transaction description"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                            @error('transactionDescription') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        @if($transactionType === 'debit' && $selectedWallet->balance < floatval($transactionAmount))
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <p class="text-red-700 text-sm">Insufficient balance for this debit amount.</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-4 mt-6 pt-4 border-t border-gray-200">
                        <button type="button" wire:click="closeTransactionModal"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white rounded-lg
                                {{ $transactionType === 'credit' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }}">
                            <span wire:loading.remove wire:target="processTransaction">
                                {{ ucfirst($transactionType) }} Wallet
                            </span>
                            <span wire:loading wire:target="processTransaction">Processing...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Success/Error Messages -->
    @if(session()->has('success'))
        <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif
</div>
