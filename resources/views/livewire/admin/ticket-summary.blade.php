<div class="space-y-3">
    @forelse($tickets as $ticket)
        <div class="flex items-center justify-between border-b border-gray-100 pb-2">
            <div class="flex items-center">
                <div class="h-8 w-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-800">{{ $ticket['subject'] }}</p>
                    <p class="text-xs text-gray-500">{{ $ticket['user']['email'] ?? 'Unknown User' }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-xs">{{ \Carbon\Carbon::parse($ticket['created_at'])->diffForHumans() }}</p>
                <p class="text-xs mt-1">
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs
                    {{ $ticket['status'] == 'open'
                        ? 'bg-red-100 text-red-800'
                        : ($ticket['status'] == 'in-progress'
                            ? 'bg-yellow-100 text-yellow-800'
                            : 'bg-green-100 text-green-800') }}">
                        {{ ucfirst($ticket['status']) }}
                    </span>
                </p>
            </div>
        </div>
    @empty
        <div class="text-center py-3">
            <p class="text-gray-500">No tickets found</p>
        </div>
    @endforelse

    <div class="mt-3 flex justify-center">
        <a href="{{ route('admin.tickets-management') }}"
            class="inline-flex items-center px-3 py-1.5 border border-green-600 text-xs font-medium rounded text-green-600 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            <span>Manage Support Tickets</span>
            <svg class="ml-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </a>
    </div>
</div>
