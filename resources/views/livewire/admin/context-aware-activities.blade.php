<div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden">
    <div class="bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200 px-6 py-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-900">Recent Activities</h2>
        </div>
    </div>
    <div class="p-4">
        <div class="space-y-4">
            @forelse($activities as $activity)
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 last:border-0">
                    <div class="flex items-center">
                        <div
                            class="h-10 w-10 rounded-full flex items-center justify-center text-white font-bold text-xs
                            {{ $activity['type'] === 'order' ? 'bg-gradient-to-tr from-indigo-500 to-purple-600' : '' }}
                            {{ $activity['type'] === 'transaction' ? 'bg-gradient-to-tr from-green-500 to-teal-600' : '' }}
                            {{ $activity['type'] === 'user_registration' ? 'bg-gradient-to-tr from-blue-500 to-cyan-600' : '' }}">
                            @php
                                $initials = '';
                                if (!empty($activity['user'])) {
                                    $names = explode(' ', $activity['user']);
                                    $initials = strtoupper(substr($names[0], 0, 1));
                                    if (count($names) > 1) {
                                        $initials .= strtoupper(substr(end($names), 0, 1));
                                    }
                                } else {
                                    $initials = 'UN';
                                }
                            @endphp
                            {{ $initials }}
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="flex items-center flex-wrap gap-1">
                                <p class="text-sm font-medium text-gray-900">{{ $activity['description'] }}</p>
                                <span
                                    class="px-2 py-0.5 text-xs rounded-full font-medium
                                    {{ $activity['type'] === 'order' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                    {{ $activity['type'] === 'transaction' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $activity['type'] === 'user_registration' ? 'bg-blue-100 text-blue-800' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $activity['type'])) }}
                                </span>
                            </div>
                            <div class="flex items-center text-xs text-gray-500 mt-1 flex-wrap gap-2">
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $activity['user'] ?? 'Unknown User' }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($activity['created_at'])->diffForHumans() }}
                                </span>
                                @if(!empty($activity['reference']))
                                    <span class="text-gray-400 font-mono">{{ $activity['reference'] }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="text-right ml-4">
                        @if($activity['amount'] > 0)
                            <p class="text-sm font-medium text-gray-900">
                                {{ $activity['currency'] ?? 'NGN' === 'NGN' ? '₦' : '$' }}{{ number_format($activity['amount'], 2) }}
                            </p>
                        @endif
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                            {{ in_array($activity['status'], ['success', 'completed', 'active']) ? 'bg-green-100 text-green-800' : '' }}
                            {{ $activity['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ in_array($activity['status'], ['failed', 'cancelled', 'inactive']) ? 'bg-red-100 text-red-800' : '' }}">
                            <span class="h-1.5 w-1.5 mr-1.5 rounded-full
                                {{ in_array($activity['status'], ['success', 'completed', 'active']) ? 'bg-green-500' : '' }}
                                {{ $activity['status'] === 'pending' ? 'bg-yellow-500' : '' }}
                                {{ in_array($activity['status'], ['failed', 'cancelled', 'inactive']) ? 'bg-red-500' : '' }}"></span>
                            {{ ucfirst($activity['status']) }}
                        </span>
                        @if(!empty($activity['fee']) && $activity['fee'] > 0)
                            <div class="text-xs text-gray-500 mt-1">Fee: ₦{{ number_format($activity['fee'], 2) }}</div>
                        @endif
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
