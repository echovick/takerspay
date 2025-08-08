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
                    <input type="text" wire:model.live="search" placeholder="Search assets by name, slug, or type..."
                        class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
                
                <!-- Type Filter -->
                <select wire:model.live="typeFilter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">All Types</option>
                    <option value="crypto">Cryptocurrency</option>
                    <option value="giftcard">Gift Card</option>
                </select>
                
                <!-- Availability Filter -->
                <select wire:model.live="availabilityFilter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">All Assets</option>
                    <option value="available">Available (> 0 units)</option>
                    <option value="unavailable">Out of Stock</option>
                </select>
                
                <button wire:click="openAddAssetModal" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center text-sm whitespace-nowrap">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Asset
                </button>
            </div>
        </div>
    </div>

    <!-- Add Asset Modal -->
    @if($showAddAssetModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Add New Asset</h3>
                        <button wire:click="closeAddAssetModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form wire:submit="createAsset" class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="md:col-span-2">
                            <h4 class="text-sm font-medium text-gray-900 mb-4">Basic Information</h4>
                        </div>

                        <!-- Asset Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Asset Name *</label>
                            <input type="text" wire:model.live="name" id="name" placeholder="e.g., Bitcoin, Amazon Gift Card"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Asset Slug -->
                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Asset Slug *</label>
                            <input type="text" wire:model="slug" id="slug" placeholder="auto-generated from name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50">
                            @error('slug') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">Auto-generated from asset name</p>
                        </div>

                        <!-- Asset Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Asset Type *</label>
                            <select wire:model="type" id="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="">Select asset type</option>
                                <option value="crypto">Cryptocurrency</option>
                                <option value="giftcard">Gift Card</option>
                            </select>
                            @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Available Units -->
                        <div>
                            <label for="available_units" class="block text-sm font-medium text-gray-700 mb-1">Available Units *</label>
                            <input type="number" wire:model="available_units" id="available_units" step="0.01" min="0" placeholder="0.00"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @error('available_units') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">Units available per dollar</p>
                        </div>

                        <!-- Pricing Information -->
                        <div class="md:col-span-2 mt-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-4">Pricing Information</h4>
                        </div>

                        <!-- Naira Buy Rate -->
                        <div>
                            <label for="naira_buy_rate" class="block text-sm font-medium text-gray-700 mb-1">Naira Buy Rate *</label>
                            <input type="number" wire:model="naira_buy_rate" id="naira_buy_rate" step="0.01" min="0" placeholder="Enter amount in Naira"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @error('naira_buy_rate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">Rate for buying assets per dollar (₦)</p>
                        </div>

                        <!-- Naira Sell Rate -->
                        <div>
                            <label for="naira_sell_rate" class="block text-sm font-medium text-gray-700 mb-1">Naira Sell Rate *</label>
                            <input type="number" wire:model="naira_sell_rate" id="naira_sell_rate" step="0.01" min="0" placeholder="Enter amount in Naira"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @error('naira_sell_rate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">Rate for selling assets per dollar (₦)</p>
                        </div>

                        <!-- Rate Difference Indicator -->
                        @if($naira_buy_rate && $naira_sell_rate)
                            <div class="md:col-span-2">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div class="text-sm">
                                            <p class="text-blue-800 font-medium">Rate Analysis</p>
                                            <p class="text-blue-700">
                                                Spread: ₦{{ number_format(abs($naira_buy_rate - $naira_sell_rate), 2) }}
                                                @if($naira_buy_rate > $naira_sell_rate)
                                                    <span class="text-green-600">(Profitable setup)</span>
                                                @else
                                                    <span class="text-red-600">(Check rates - sell rate higher than buy rate)</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-4 mt-6 pt-4 border-t border-gray-200">
                        <button type="button" wire:click="closeAddAssetModal"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                            <span wire:loading.remove wire:target="createAsset">Create Asset</span>
                            <span wire:loading wire:target="createAsset">Creating...</span>
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