<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <!-- Table Controls -->
    <div class="flex justify-between items-center pb-4">
        <div class="flex gap-4 items-center">
            <!-- Per Page -->
            <select wire:model.live="perPage" class="px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500">
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
            </select>
        </div>
        
        <div class="text-sm text-gray-600">
            Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of {{ $transactions->total() ?? 0 }} transactions
        </div>
    </div>

    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">S/N</th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('transaction_reference')">
                    <div class="flex items-center">
                        Reference
                        @if($sortBy === 'transaction_reference')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('user_email')">
                    <div class="flex items-center">
                        User
                        @if($sortBy === 'user_email')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3">Wallet</th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('transaction_type')">
                    <div class="flex items-center">
                        Type
                        @if($sortBy === 'transaction_type')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('amount')">
                    <div class="flex items-center">
                        Amount
                        @if($sortBy === 'amount')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('status')">
                    <div class="flex items-center">
                        Status
                        @if($sortBy === 'status')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3">Description</th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('created_at')">
                    <div class="flex items-center">
                        Date
                        @if($sortBy === 'created_at')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $index => $transaction)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $transactions->firstItem() + $index }}
                    </th>
                    <td class="px-6 py-4">
                        <div class="font-mono text-sm text-gray-900">{{ $transaction->transaction_reference }}</div>
                        <div class="text-xs text-gray-500">ID: {{ $transaction->id }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($transaction->wallet && $transaction->wallet->user)
                            <div class="flex items-center">
                                @php
                                    $user = $transaction->wallet->user;
                                    $firstName = $user->metaData->first_name ?? '';
                                    $lastName = $user->metaData->last_name ?? '';
                                    $displayName = trim($firstName . ' ' . $lastName) ?: $user->email;
                                    $initials = $firstName && $lastName ? strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1)) : strtoupper(substr($user->email, 0, 2));
                                @endphp
                                <div class="h-8 w-8 rounded-full flex items-center justify-center text-white font-bold text-xs mr-3 bg-gradient-to-tr from-blue-500 to-cyan-600">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 text-sm">{{ $displayName }}</div>
                                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        @else
                            <span class="text-gray-500">Unknown User</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($transaction->wallet)
                            <div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $transaction->wallet->type === 'crypto' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ $transaction->wallet->type === 'crypto' ? 'Crypto' : 'FundsPadi' }}
                                </span>
                                @if($transaction->wallet->type === 'crypto' && $transaction->wallet->asset)
                                    <div class="text-xs text-gray-500 mt-1">{{ $transaction->wallet->asset->name }}</div>
                                @endif
                            </div>
                        @else
                            <span class="text-gray-500">Unknown</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 {{ $this->getTypeColor($transaction->transaction_type) }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $this->getTypeIcon($transaction->transaction_type) }}"></path>
                            </svg>
                            <span class="font-medium {{ $this->getTypeColor($transaction->transaction_type) }}">
                                {{ ucfirst($transaction->transaction_type) }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium {{ $this->getTypeColor($transaction->transaction_type) }}">
                            {{ $transaction->transaction_type === 'credit' ? '+' : '-' }}₦{{ number_format($transaction->amount, 2) }}
                        </div>
                        <div class="text-xs text-gray-500">{{ $transaction->currency ?? 'NGN' }}</div>
                        @if($transaction->balance_after)
                            <div class="text-xs text-gray-500">Balance: ₦{{ number_format($transaction->balance_after, 2) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusColor($transaction->status) }}">
                            <span class="h-1.5 w-1.5 mr-1.5 rounded-full {{ $this->getStatusDotColor($transaction->status) }}"></span>
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $transaction->transaction_description }}">
                            {{ $transaction->transaction_description ?: 'No description' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 w-40">
                        <div class="font-medium text-gray-900">{{ $transaction->created_at->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $transaction->created_at->format('H:i:s') }}</div>
                        <div class="text-xs text-gray-500">{{ $transaction->created_at->diffForHumans() }}</div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="px-6 py-8 text-center">
                        <div class="text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No transactions found</h3>
                            <p class="mt-1 text-sm text-gray-500">No transactions match your current filters.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $transactions->links() }}
    </div>
</div>