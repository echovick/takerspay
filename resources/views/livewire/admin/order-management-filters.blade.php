<div>
    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="px-4 py-3 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-900">Search & Filters</h2>
        </div>
        <div class="p-4">
            <div class="flex flex-col lg:flex-row gap-3">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" wire:model.live="search" placeholder="Search by reference, asset, user email, or name..."
                        class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
                
                <!-- Status Filter -->
                <select wire:model.live="statusFilter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="canceled">Canceled</option>
                </select>
                
                <!-- Asset Filter -->
                <select wire:model.live="assetFilter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">All Assets</option>
                    <option value="crypto">Crypto</option>
                    <option value="giftcard">Gift Card</option>
                </select>
                
                <!-- Type Filter -->
                <select wire:model.live="typeFilter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">All Types</option>
                    <option value="buy">Buy</option>
                    <option value="sell">Sell</option>
                </select>
                
                <button wire:click="exportOrders" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center text-sm whitespace-nowrap">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Export
                </button>
            </div>
        </div>
    </div>

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

    @if(session()->has('info'))
        <div class="mt-4 bg-blue-500 text-white px-4 py-3 rounded-lg text-sm">
            {{ session('info') }}
        </div>
    @endif
</div>

<script>
document.addEventListener('livewire:initialized', function() {
    Livewire.on('downloadCsv', function(data) {
        const csvContent = data[0].content;
        const filename = data[0].filename;
        
        // Create blob and download link
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        
        if (link.download !== undefined) {
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', filename);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        }
    });
});
</script>