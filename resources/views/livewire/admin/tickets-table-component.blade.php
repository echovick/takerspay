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
            Showing {{ $tickets->firstItem() ?? 0 }} to {{ $tickets->lastItem() ?? 0 }} of {{ $tickets->total() ?? 0 }} tickets
        </div>
    </div>

    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">S/N</th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('subject')">
                    <div class="flex items-center">
                        Subject
                        @if($sortBy === 'subject')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('user_name')">
                    <div class="flex items-center">
                        User
                        @if($sortBy === 'user_name')
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
                <th scope="col" class="px-6 py-3">Messages</th>
                <th scope="col" class="px-6 py-3">Last Message</th>
                <th scope="col" class="px-6 py-3 cursor-pointer hover:bg-gray-100" wire:click="sortBy('created_at')">
                    <div class="flex items-center">
                        Created
                        @if($sortBy === 'created_at')
                            @if($sortDirection === 'asc')
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            @else
                                <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/></svg>
                            @endif
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tickets as $index => $ticket)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $tickets->firstItem() + $index }}
                    </th>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $ticket->subject }}</div>
                        <div class="text-xs text-gray-500">ID: #{{ $ticket->id }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($ticket->user)
                            <div class="flex items-center">
                                @php
                                    $firstName = $ticket->user->metaData->first_name ?? '';
                                    $lastName = $ticket->user->metaData->last_name ?? '';
                                    $displayName = trim($firstName . ' ' . $lastName) ?: $ticket->user->email;
                                    $initials = $firstName && $lastName ? strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1)) : strtoupper(substr($ticket->user->email, 0, 2));
                                @endphp
                                <div class="h-8 w-8 rounded-full flex items-center justify-center text-white font-bold text-xs mr-3 bg-gradient-to-tr from-blue-500 to-cyan-600">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 text-sm">{{ $displayName }}</div>
                                    <div class="text-xs text-gray-500">{{ $ticket->user->email }}</div>
                                </div>
                            </div>
                        @else
                            <span class="text-gray-500">Unknown User</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusColor($ticket->status) }}">
                            <span class="h-1.5 w-1.5 mr-1.5 rounded-full {{ $this->getStatusDotColor($ticket->status) }}"></span>
                            {{ $ticket->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @php $messageCount = $ticket->messages->count(); @endphp
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 {{ $this->getPriorityColor($messageCount) }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <span class="font-medium {{ $this->getPriorityColor($messageCount) }}">{{ $messageCount }}</span>
                        </div>
                        <div class="text-xs text-gray-500">
                            @if($messageCount > 10)
                                High Priority
                            @elseif($messageCount > 5)
                                Medium Priority
                            @else
                                Low Priority
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $ticket->last_message }}">
                            {{ Str::limit($ticket->last_message, 50) ?: 'No messages yet' }}
                        </div>
                        @if($ticket->messages->count() > 0)
                            <div class="text-xs text-gray-500">{{ $ticket->messages->last()->created_at->diffForHumans() }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 w-40">
                        <div class="font-medium text-gray-900">{{ $ticket->created_at->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $ticket->created_at->format('H:i:s') }}</div>
                        <div class="text-xs text-gray-500">{{ $ticket->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <button wire:click="openViewModal({{ $ticket->id }})" 
                                class="text-blue-600 hover:text-blue-900 text-sm font-medium" title="View Ticket">
                                View
                            </button>
                            <span class="text-gray-300">|</span>
                            <button wire:click="openResponseModal({{ $ticket->id }})" 
                                class="text-green-600 hover:text-green-900 text-sm font-medium" title="Respond">
                                Respond
                            </button>
                            @if($ticket->status !== 'Closed')
                                <span class="text-gray-300">|</span>
                                <button wire:click="updateTicketStatus({{ $ticket->id }}, 'Closed')" 
                                    wire:confirm="Are you sure you want to close this ticket?"
                                    class="text-red-600 hover:text-red-900 text-sm font-medium" title="Close Ticket">
                                    Close
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center">
                        <div class="text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No tickets found</h3>
                            <p class="mt-1 text-sm text-gray-500">No tickets match your current filters.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $tickets->links() }}
    </div>

    <!-- View Ticket Modal -->
    @if($showViewModal && $viewTicket)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Ticket #{{ $viewTicket->id }}</h3>
                            <p class="text-sm text-gray-600">{{ $viewTicket->subject }}</p>
                        </div>
                        <button wire:click="closeViewModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-4">
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        @forelse($viewTicket->messages as $message)
                            <div class="flex {{ $message->is_admin ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg {{ $message->is_admin ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-900' }}">
                                    <div class="text-sm">{{ $message->message }}</div>
                                    <div class="text-xs mt-1 {{ $message->is_admin ? 'text-blue-100' : 'text-gray-500' }}">
                                        @if($message->user)
                                            @php
                                                $firstName = $message->user->metaData->first_name ?? '';
                                                $lastName = $message->user->metaData->last_name ?? '';
                                                $displayName = trim($firstName . ' ' . $lastName) ?: $message->user->email;
                                            @endphp
                                            {{ $message->is_admin ? 'Admin' : $displayName }} • {{ $message->created_at->format('M d, Y H:i') }}
                                        @else
                                            Unknown User • {{ $message->created_at->format('M d, Y H:i') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500">No messages in this ticket.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Response Modal -->
    @if($showResponseModal && $selectedTicket)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Respond to Ticket</h3>
                            <p class="text-sm text-gray-600">{{ $selectedTicket->subject }}</p>
                        </div>
                        <button wire:click="closeResponseModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form wire:submit="sendResponse" class="px-6 py-4">
                    <div class="space-y-4">
                        <!-- Status Update -->
                        <div>
                            <label for="newStatus" class="block text-sm font-medium text-gray-700 mb-1">Update Status *</label>
                            <select wire:model="newStatus" id="newStatus" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="Open">Open</option>
                                <option value="Pending">Pending</option>
                                <option value="Closed">Closed</option>
                            </select>
                            @error('newStatus') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Response Message -->
                        <div>
                            <label for="responseMessage" class="block text-sm font-medium text-gray-700 mb-1">Response Message *</label>
                            <textarea wire:model="responseMessage" id="responseMessage" rows="5"
                                placeholder="Type your response to the user..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                            @error('responseMessage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-4 mt-6 pt-4 border-t border-gray-200">
                        <button type="button" wire:click="closeResponseModal"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                            <span wire:loading.remove wire:target="sendResponse">Send Response</span>
                            <span wire:loading wire:target="sendResponse">Sending...</span>
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