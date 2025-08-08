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
            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() ?? 0 }} users
        </div>
    </div>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    S/N
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('email')">
                    <div class="flex items-center">
                        Email
                        @if($sortBy === 'email')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('name')">
                    <div class="flex items-center">
                        Name
                        @if($sortBy === 'name')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('phone')">
                    <div class="flex items-center">
                        Phone
                        @if($sortBy === 'phone')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3">
                    Tag
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('balance')">
                    <div class="flex items-center">
                        Account Balance
                        @if($sortBy === 'balance')
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
                        Date Registered
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
                    Orders
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    KYC
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $index => $user)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $users->firstItem() + $index }}
                    </th>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-medium text-sm mr-3">
                                @php
                                    $name = trim(($user->metaData?->first_name ?? '') . ' ' . ($user->metaData?->last_name ?? ''));
                                    if (!empty($name)) {
                                        $names = explode(' ', $name);
                                        $initials = strtoupper(substr($names[0], 0, 1));
                                        if (count($names) > 1) {
                                            $initials .= strtoupper(substr(end($names), 0, 1));
                                        }
                                    } else {
                                        $initials = strtoupper(substr($user->email, 0, 2));
                                    }
                                @endphp
                                {{ $initials }}
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">{{ $user->email }}</div>
                                @if($user->email_verified_at)
                                    <div class="text-xs text-green-600">Verified</div>
                                @else
                                    <div class="text-xs text-red-600">Unverified</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">
                            {{ trim(($user->metaData?->first_name ?? '') . ' ' . ($user->metaData?->last_name ?? '')) ?: 'N/A' }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        {{ $user->phone ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4">
                        @if($user->metaData?->tag)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $user->metaData->tag }}
                            </span>
                        @else
                            <span class="text-gray-400">N/A</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">
                            ₦{{ number_format($user->account_balance ?? 0, 2) }}
                        </div>
                        <div class="text-xs text-gray-500">{{ $user->wallets_count ?? 0 }} wallet(s)</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">
                            {{ $user->created_at->format('M d, Y') }}
                        </div>
                        <div class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $user->orders_count ?? 0 }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @php $userStatus = $this->getUserStatus($user); @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $userStatus['color'] === 'green' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $userStatus['color'] === 'gray' ? 'bg-gray-100 text-gray-800' : '' }}
                            {{ $userStatus['color'] === 'red' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $userStatus['color'] === 'yellow' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $userStatus['color'] === 'blue' ? 'bg-blue-100 text-blue-800' : '' }}">
                            <span class="h-1.5 w-1.5 mr-1.5 rounded-full 
                                {{ $userStatus['color'] === 'green' ? 'bg-green-500' : '' }}
                                {{ $userStatus['color'] === 'gray' ? 'bg-gray-500' : '' }}
                                {{ $userStatus['color'] === 'red' ? 'bg-red-500' : '' }}
                                {{ $userStatus['color'] === 'yellow' ? 'bg-yellow-500' : '' }}
                                {{ $userStatus['color'] === 'blue' ? 'bg-blue-500' : '' }}"></span>
                            {{ ucfirst($userStatus['status']) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @php $kycStatus = $this->getKYCStatus($user); @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $kycStatus['color'] === 'green' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $kycStatus['color'] === 'gray' ? 'bg-gray-100 text-gray-800' : '' }}
                            {{ $kycStatus['color'] === 'red' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $kycStatus['color'] === 'yellow' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                            {{ $kycStatus['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.user-details', $user->id) }}"
                                class="text-blue-600 hover:text-blue-900 text-sm font-medium">View</a>
                            <span class="text-gray-300">|</span>
                            <button class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="px-6 py-8 text-center">
                        <div class="text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No users found</h3>
                            <p class="mt-1 text-sm text-gray-500">No users match your current filters.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $users->links() }}
    </div>
</div>
