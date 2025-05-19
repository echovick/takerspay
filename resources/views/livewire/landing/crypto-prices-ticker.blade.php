<div wire:poll.60s="fetchPrices"
    class="bg-gradient-to-r from-primary-1000 to-primary-1100 text-white py-3 overflow-hidden">
    <div class="flex items-center animate-marquee whitespace-nowrap">
        @if ($loading)
            <div class="flex items-center space-x-4 px-4">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span>Loading crypto prices...</span>
            </div>
        @elseif ($error)
            <div class="px-4">Crypto prices are temporarily unavailable. Check back in a moment for live updates.
            </div>
        @else
            @foreach ($prices as $crypto => $data)
                <span class="uppercase">{{ $crypto }}:</span>
                <span class="text-green-300">${{ number_format($data['usd'], 2) }}</span> |
            @endforeach
        @endif
    </div>
</div>
