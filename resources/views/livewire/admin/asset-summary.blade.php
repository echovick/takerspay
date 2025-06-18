<div class="space-y-3">
    @forelse($assets as $asset)
        <div class="flex items-center justify-between border-b border-gray-100 pb-2">
            <div class="flex items-center">
                <div class="h-8 w-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-800">{{ $asset['name'] }}</p>
                    <p class="text-xs text-gray-500">{{ $asset['type'] }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-gray-800">
                    @if ($asset['type'] == 'crypto')
                        ${{ number_format($asset['dollar_rate'], 2) }}
                    @else
                        ₦{{ number_format($asset['naira_rate'], 2) }}
                    @endif
                </p>
                <p class="text-xs text-gray-500">
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs {{ $asset['status'] == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($asset['status']) }}
                    </span>
                </p>
            </div>
        </div>
    @empty
        <div class="text-center py-3">
            <p class="text-gray-500">No assets found</p>
        </div>
    @endforelse

    <div class="mt-3 flex justify-center">
        <a href="{{ route('admin.asset-management') }}"
            class="inline-flex items-center px-3 py-1.5 border border-indigo-600 text-xs font-medium rounded text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <span>View All Assets</span>
            <svg class="ml-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </a>
    </div>
</div>
