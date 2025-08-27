<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div class="flex justify-between items-center pb-4">
        <div class="flex gap-4 items-center">
            <!-- Date Filter -->
            <select wire:model.live="dateFilter" class="px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                <option value="all">All Time</option>
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
                <option value="year">This Year</option>
            </select>
            
            <!-- Per Page -->
            <select wire:model.live="perPage" class="px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
            </select>
        </div>
        
        <div class="text-sm text-gray-600">
            Showing {{ $assets->firstItem() ?? 0 }} to {{ $assets->lastItem() ?? 0 }} of {{ $assets->total() ?? 0 }} assets
        </div>
    </div>
    
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    S/N
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('name')">
                    <div class="flex items-center">
                        Asset Name
                        @if($sortBy === 'name')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('type')">
                    <div class="flex items-center">
                        Type
                        @if($sortBy === 'type')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('naira_buy_rate')">
                    <div class="flex items-center">
                        Buy Rate
                        @if($sortBy === 'naira_buy_rate')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('naira_sell_rate')">
                    <div class="flex items-center">
                        Sell Rate
                        @if($sortBy === 'naira_sell_rate')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('created_at')">
                    <div class="flex items-center">
                        Date Created
                        @if($sortBy === 'created_at')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3">
                    Availability
                </th>
                <th scope="col" class="px-6 py-3">
                    Orders
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($assets as $index => $asset)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $assets->firstItem() + $index }}
                    </th>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full flex items-center justify-center text-white font-bold text-xs mr-3 
                                {{ $asset->type === 'crypto' ? 'bg-gradient-to-tr from-blue-500 to-cyan-600' : 'bg-gradient-to-tr from-purple-500 to-pink-600' }}">
                                {{ strtoupper(substr($asset->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">{{ $asset->name }}</div>
                                <div class="text-xs text-gray-500 font-mono">{{ $asset->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $asset->type === 'crypto' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ ucfirst($asset->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">
                            ₦{{ number_format($asset->naira_buy_rate, 2) }}
                        </div>
                        <div class="text-xs text-gray-500">per USD</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">
                            ₦{{ number_format($asset->naira_sell_rate, 2) }}
                        </div>
                        <div class="text-xs text-gray-500">per USD</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">
                            {{ $asset->created_at->format('M d, Y') }}
                        </div>
                        <div class="text-xs text-gray-500">{{ $asset->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @php $availability = $this->getAvailabilityStatus($asset); @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $availability['color'] === 'green' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $availability['color'] === 'yellow' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $availability['color'] === 'red' ? 'bg-red-100 text-red-800' : '' }}">
                            <span class="h-1.5 w-1.5 mr-1.5 rounded-full 
                                {{ $availability['color'] === 'green' ? 'bg-green-500' : '' }}
                                {{ $availability['color'] === 'yellow' ? 'bg-yellow-500' : '' }}
                                {{ $availability['color'] === 'red' ? 'bg-red-500' : '' }}"></span>
                            {{ $availability['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $this->getAssetOrdersCount($asset) }}</div>
                        <div class="text-xs text-gray-500">
                            @php $margin = $this->getProfitMargin($asset); @endphp
                            @if($margin > 0)
                                <span class="text-green-600">{{ number_format($margin, 1) }}% profit</span>
                            @elseif($margin < 0)
                                <span class="text-red-600">{{ number_format(abs($margin), 1) }}% loss</span>
                            @else
                                <span class="text-gray-500">No margin</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $asset->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            <span class="h-1.5 w-1.5 mr-1.5 rounded-full 
                                {{ $asset->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            {{ $asset->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <button wire:click="editAsset({{ $asset->id }})" class="text-blue-600 hover:text-blue-900 text-sm font-medium">Edit</button>
                            <span class="text-gray-300">|</span>
                            <button wire:click="toggleAssetStatus({{ $asset->id }})" 
                                class="{{ $asset->is_active ? 'text-orange-600 hover:text-orange-900' : 'text-green-600 hover:text-green-900' }} text-sm font-medium">
                                {{ $asset->is_active ? 'Disable' : 'Enable' }}
                            </button>
                            <span class="text-gray-300">|</span>
                            <button wire:click="deleteAsset({{ $asset->id }})" wire:confirm="Are you sure you want to delete this asset? This action cannot be undone." 
                                class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="px-6 py-8 text-center">
                        <div class="text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No assets found</h3>
                            <p class="mt-1 text-sm text-gray-500">No assets match your current filters.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $assets->links() }}
    </div>

    <!-- Edit Asset Modal -->
    @if($showEditModal && $editingAsset)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Edit Asset</h3>
                        <button wire:click="closeEditModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form wire:submit="updateAsset" class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Asset Name -->
                        <div>
                            <label for="editName" class="block text-sm font-medium text-gray-700 mb-1">Asset Name *</label>
                            <input type="text" wire:model.live="editName" id="editName"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @error('editName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Asset Slug -->
                        <div>
                            <label for="editSlug" class="block text-sm font-medium text-gray-700 mb-1">Asset Slug *</label>
                            <input type="text" wire:model="editSlug" id="editSlug"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50">
                            @error('editSlug') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Asset Type -->
                        <div>
                            <label for="editType" class="block text-sm font-medium text-gray-700 mb-1">Asset Type *</label>
                            <select wire:model="editType" id="editType" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="">Select asset type</option>
                                <option value="crypto">Cryptocurrency</option>
                                <option value="giftcard">Gift Card</option>
                            </select>
                            @error('editType') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Available Units -->
                        <div>
                            <label for="editAvailableUnits" class="block text-sm font-medium text-gray-700 mb-1">Available Units *</label>
                            <input type="number" wire:model="editAvailableUnits" id="editAvailableUnits" step="0.01" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @error('editAvailableUnits') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Naira Buy Rate -->
                        <div>
                            <label for="editNairaBuyRate" class="block text-sm font-medium text-gray-700 mb-1">Naira Buy Rate *</label>
                            <input type="number" wire:model="editNairaBuyRate" id="editNairaBuyRate" step="0.01" min="0" placeholder="Enter amount in Naira"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @error('editNairaBuyRate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">Rate for buying assets per dollar (₦)</p>
                        </div>

                        <!-- Naira Sell Rate -->
                        <div>
                            <label for="editNairaSellRate" class="block text-sm font-medium text-gray-700 mb-1">Naira Sell Rate *</label>
                            <input type="number" wire:model="editNairaSellRate" id="editNairaSellRate" step="0.01" min="0" placeholder="Enter amount in Naira"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @error('editNairaSellRate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">Rate for selling assets per dollar (₦)</p>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-4 mt-6 pt-4 border-t border-gray-200">
                        <button type="button" wire:click="closeEditModal"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                            <span wire:loading.remove wire:target="updateAsset">Update Asset</span>
                            <span wire:loading wire:target="updateAsset">Updating...</span>
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
