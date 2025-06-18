<div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden">
    <div class="bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200 px-6 py-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-900">Recent Activities</h2>
        </div>
    </div>
    <div class="p-4">
        <div class="space-y-4">
            @forelse($activities as $activity)
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <div class="flex items-center">
                        <div
                            class="h-10 w-10 rounded-full {{ $activity['type'] === 'order' ? 'bg-gradient-to-tr from-indigo-500 to-purple-600' : 'bg-gradient-to-tr from-green-500 to-teal-600' }} flex items-center justify-center text-white font-bold text-xs">
                            {{ strtoupper(substr($activity['user'] ?? 'UN', 0, 2)) }}
                        </div>
                        <div class="ml-3">
                            <div class="flex items-center">
                                <p class="text-sm font-medium text-gray-900">{{ $activity['description'] }}</p>
                                <span
                                    class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activity['type'] === 'order' ? 'bg-indigo-100 text-indigo-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($activity['type']) }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($activity['created_at'])->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium">
                            ₦{{ number_format($activity['amount'], 2) }}
                        </p>
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                            {{ $activity['status'] === 'success' || $activity['status'] === 'completed'
                                ? 'bg-green-100 text-green-800'
                                : ($activity['status'] === 'pending'
                                    ? 'bg-yellow-100 text-yellow-800'
                                    : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($activity['status']) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center py-4">
                    <p class="text-gray-500">No recent activities found.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
