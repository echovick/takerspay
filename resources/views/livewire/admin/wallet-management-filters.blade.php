<div>
    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="px-4 py-3 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-900">Search & Filters</h2>
        </div>
        <div class="p-4">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" wire:model.live="search" placeholder="Search by user name, email, or wallet details..."
                        class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
                
                <!-- Type Filter -->
                <select wire:model.live="typeFilter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">All Types</option>
                    <option value="crypto">Crypto Wallets</option>
                    <option value="fiat">FundsPadi Wallets</option>
                </select>
                
                <!-- Status Filter -->
                <select wire:model.live="statusFilter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                
                <button wire:click="openCreateWalletModal" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center text-sm whitespace-nowrap">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    New Wallet
                </button>
            </div>
        </div>
    </div>

    <!-- Create Wallet Modal -->
    @if($showCreateWalletModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Create New Wallet</h3>
                        <button wire:click="closeCreateWalletModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form wire:submit="createWallet" class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="md:col-span-2">
                            <h4 class="text-sm font-medium text-gray-900 mb-4">Basic Information</h4>
                        </div>

                        <!-- Select User -->
                        <div class="md:col-span-2">
                            <label for="selectedUserId" class="block text-sm font-medium text-gray-700 mb-1">Select User *</label>
                            <select wire:model="selectedUserId" id="selectedUserId" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="">Choose a user...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->display_name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                            @error('selectedUserId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Wallet Type -->
                        <div>
                            <label for="walletType" class="block text-sm font-medium text-gray-700 mb-1">Wallet Type *</label>
                            <select wire:model.live="walletType" id="walletType" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="">Select wallet type</option>
                                <option value="crypto">Crypto Wallet</option>
                                <option value="fiat">FundsPadi Wallet</option>
                            </select>
                            @error('walletType') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Initial Balance -->
                        <div>
                            <label for="initialBalance" class="block text-sm font-medium text-gray-700 mb-1">Initial Balance *</label>
                            <input type="number" wire:model="initialBalance" id="initialBalance" step="0.01" min="0" placeholder="Enter initial balance"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @error('initialBalance') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">Amount in Naira (₦)</p>
                        </div>

                        @if($walletType === 'crypto')
                            <!-- Asset Selection for Crypto -->
                            <div class="md:col-span-2">
                                <h4 class="text-sm font-medium text-gray-900 mb-4">Crypto Wallet Details</h4>
                            </div>

                            <div class="md:col-span-2">
                                <label for="selectedAssetId" class="block text-sm font-medium text-gray-700 mb-1">Select Asset *</label>
                                <select wire:model="selectedAssetId" id="selectedAssetId" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">Choose an asset...</option>
                                    @foreach($assets as $asset)
                                        <option value="{{ $asset->id }}">{{ $asset->name }} ({{ strtoupper($asset->slug) }})</option>
                                    @endforeach
                                </select>
                                @error('selectedAssetId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                <p class="text-xs text-gray-500 mt-1">Wallet number will be auto-generated</p>
                            </div>
                        @elseif($walletType === 'fiat')
                            <!-- FundsPadi Wallet Details -->
                            <div class="md:col-span-2">
                                <h4 class="text-sm font-medium text-gray-900 mb-4">FundsPadi Wallet Details</h4>
                            </div>

                            <div>
                                <label for="bankName" class="block text-sm font-medium text-gray-700 mb-1">Wallet Provider *</label>
                                <input type="text" wire:model="bankName" id="bankName" placeholder="FundsPadi" value="FundsPadi"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                @error('bankName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="accountName" class="block text-sm font-medium text-gray-700 mb-1">Account Name *</label>
                                <input type="text" wire:model="accountName" id="accountName" placeholder="Account holder's name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                @error('accountName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                <p class="text-xs text-gray-500 mt-1">Account number will be auto-generated</p>
                            </div>
                        @endif
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-4 mt-6 pt-4 border-t border-gray-200">
                        <button type="button" wire:click="closeCreateWalletModal"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                            <span wire:loading.remove wire:target="createWallet">Create Wallet</span>
                            <span wire:loading wire:target="createWallet">Creating...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Success/Error Messages -->
    @if(session()->has('success'))
        <div class="mt-4 bg-green-500 text-white px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="mt-4 bg-red-500 text-white px-4 py-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif
</div>