@extends('layout.app')

@section('content')
    <!-- Add Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    @include('admin.includes.nav-bar')

    <!-- Sidebar -->
    @include('admin.includes.side-bar')

    <!-- Mobile-optimized Content Area with web compatibility -->
    <main class="p-2 md:p-4 md:ml-64 h-auto pt-20 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="container mx-auto max-w-7xl">
            <!-- Page Header -->
            <div class="bg-white rounded-xl shadow-lg mb-6 overflow-hidden animate__animated animate__fadeIn">
                <div class="relative overflow-hidden">
                    <!-- Background with proper gradient and height -->
                    <div class="h-28 bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600">
                        <!-- Decorative elements properly positioned -->
                        <div class="absolute top-5 right-10 h-24 w-24 rounded-full bg-white opacity-10"></div>
                        <div class="absolute bottom-5 left-20 h-32 w-32 rounded-full bg-white opacity-5"></div>
                        <div class="absolute -bottom-16 -right-8 h-48 w-48 rounded-full bg-indigo-500 opacity-10"></div>
                    </div>
                </div>

                <!-- Content section with proper spacing -->
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Support Tickets</h1>
                            <p class="mt-1 text-gray-600">Manage and respond to customer support inquiries</p>
                        </div>

                        <!-- Filter and search controls -->
                        <div class="mt-4 md:mt-0 flex flex-col md:flex-row gap-2">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" placeholder="Search tickets"
                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <select
                                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Filter by Status</option>
                                <option value="open">Open</option>
                                <option value="in-progress">In Progress</option>
                                <option value="resolved">Resolved</option>
                                <option value="closed">Closed</option>
                            </select>

                            <select
                                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Filter by Priority</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 animate__animated animate__fadeIn animate__delay-1s">
                <div
                    class="bg-white rounded-lg shadow-md p-5 border-l-4 border-blue-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Total Tickets</h3>
                            <p class="text-xl font-bold text-gray-900">{{ number_format(248) }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-lg shadow-md p-5 border-l-4 border-red-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="bg-red-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Open Tickets</h3>
                            <p class="text-xl font-bold text-gray-900">{{ number_format(42) }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-lg shadow-md p-5 border-l-4 border-yellow-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">In Progress</h3>
                            <p class="text-xl font-bold text-gray-900">{{ number_format(28) }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-lg shadow-md p-5 border-l-4 border-green-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Resolved Today</h3>
                            <p class="text-xl font-bold text-gray-900">{{ number_format(15) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tickets Table -->
            <div
                class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden mb-6 animate__animated animate__fadeIn animate__delay-2s">
                <div class="bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200 px-6 py-4">
                    <h2 class="text-lg font-medium text-gray-900">Support Tickets</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ticket ID</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Subject</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Priority</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created</th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                // Sample data - replace with actual ticket data in production
                                $tickets = [
                                    [
                                        'id' => 'TCKT-' . rand(10000, 99999),
                                        'user' => ['name' => 'John Doe', 'id' => 1, 'email' => 'john@example.com'],
                                        'subject' => 'Cannot withdraw funds from my wallet',
                                        'priority' => 'high',
                                        'status' => 'open',
                                        'created' => '2023-10-12 14:25',
                                        'updated' => '2023-10-12 16:30',
                                    ],
                                    [
                                        'id' => 'TCKT-' . rand(10000, 99999),
                                        'user' => ['name' => 'Jane Smith', 'id' => 2, 'email' => 'jane@example.com'],
                                        'subject' => 'Transaction not showing in my history',
                                        'priority' => 'medium',
                                        'status' => 'in-progress',
                                        'created' => '2023-10-11 09:15',
                                        'updated' => '2023-10-12 11:20',
                                    ],
                                    [
                                        'id' => 'TCKT-' . rand(10000, 99999),
                                        'user' => ['name' => 'Emily Wilson', 'id' => 4, 'email' => 'emily@example.com'],
                                        'subject' => 'Need help with account verification',
                                        'priority' => 'low',
                                        'status' => 'resolved',
                                        'created' => '2023-10-10 16:40',
                                        'updated' => '2023-10-11 10:30',
                                    ],
                                    [
                                        'id' => 'TCKT-' . rand(10000, 99999),
                                        'user' => [
                                            'name' => 'Robert Johnson',
                                            'id' => 3,
                                            'email' => 'robert@example.com',
                                        ],
                                        'subject' => 'Fraudulent transaction on my account',
                                        'priority' => 'urgent',
                                        'status' => 'in-progress',
                                        'created' => '2023-10-12 08:05',
                                        'updated' => '2023-10-12 09:15',
                                    ],
                                    [
                                        'id' => 'TCKT-' . rand(10000, 99999),
                                        'user' => [
                                            'name' => 'Michael Brown',
                                            'id' => 5,
                                            'email' => 'michael@example.com',
                                        ],
                                        'subject' => 'Request for account closure',
                                        'priority' => 'medium',
                                        'status' => 'open',
                                        'created' => '2023-10-11 14:50',
                                        'updated' => null,
                                    ],
                                ];
                            @endphp

                            @foreach ($tickets as $ticket)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-mono text-gray-900">{{ $ticket['id'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="h-8 w-8 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold">
                                                {{ substr($ticket['user']['name'], 0, 1) }}{{ substr(strrchr($ticket['user']['name'], ' '), 1, 1) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <a href="{{ route('admin.user-details', $ticket['user']['id']) }}"
                                                        class="hover:text-blue-600">
                                                        {{ $ticket['user']['name'] }}
                                                    </a>
                                                </div>
                                                <div class="text-xs text-gray-500">{{ $ticket['user']['email'] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $ticket['subject'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $ticket['priority'] == 'low' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $ticket['priority'] == 'medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $ticket['priority'] == 'high' ? 'bg-orange-100 text-orange-800' : '' }}
                                            {{ $ticket['priority'] == 'urgent' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($ticket['priority']) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $ticket['status'] == 'open' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $ticket['status'] == 'in-progress' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $ticket['status'] == 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $ticket['status'] == 'closed' ? 'bg-gray-100 text-gray-800' : '' }}">
                                            <span
                                                class="h-1.5 w-1.5 mr-1.5 rounded-full 
                                                {{ $ticket['status'] == 'open' ? 'bg-red-500' : '' }}
                                                {{ $ticket['status'] == 'in-progress' ? 'bg-yellow-500' : '' }}
                                                {{ $ticket['status'] == 'resolved' ? 'bg-green-500' : '' }}
                                                {{ $ticket['status'] == 'closed' ? 'bg-gray-500' : '' }}"></span>
                                            {{ ucfirst($ticket['status']) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $ticket['created'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button type="button" class="text-indigo-600 hover:text-indigo-900"
                                                title="View Ticket">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            @if ($ticket['status'] == 'open')
                                                <button type="button" class="text-yellow-600 hover:text-yellow-900"
                                                    title="Assign to Me">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                                    </svg>
                                                </button>
                                            @endif
                                            @if (in_array($ticket['status'], ['open', 'in-progress']))
                                                <button type="button" class="text-green-600 hover:text-green-900"
                                                    title="Mark as Resolved">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                            @endif
                                            <button type="button" class="text-blue-600 hover:text-blue-900"
                                                title="Reply">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-3 flex items-center justify-between border-t border-gray-200">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <a href="#"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Previous
                        </a>
                        <a href="#"
                            class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Next
                        </a>
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span
                                    class="font-medium">42</span> results
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                aria-label="Pagination">
                                <a href="#"
                                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Previous</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="#" aria-current="page"
                                    class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    1
                                </a>
                                <a href="#"
                                    class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    2
                                </a>
                                <a href="#"
                                    class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    3
                                </a>
                                <span
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                    ...
                                </span>
                                <a href="#"
                                    class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    8
                                </a>
                                <a href="#"
                                    class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    9
                                </a>
                                <a href="#"
                                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Next</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recently Resolved Tickets -->
            <div
                class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden mb-6 animate__animated animate__fadeIn animate__delay-3s">
                <div class="bg-gradient-to-r from-gray-50 to-green-50 border-b border-gray-200 px-6 py-4">
                    <h2 class="text-lg font-medium text-gray-900">Recently Resolved Tickets</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @php
                            // Sample data - replace with actual resolved tickets in production
                            $resolvedTickets = [
                                [
                                    'id' => 'TCKT-' . rand(10000, 99999),
                                    'user' => 'David Lee',
                                    'subject' => 'Password reset not working',
                                    'resolved_by' => 'Admin User',
                                    'resolved_at' => '2 hours ago',
                                ],
                                [
                                    'id' => 'TCKT-' . rand(10000, 99999),
                                    'user' => 'Sarah Wilson',
                                    'subject' => 'Unable to update profile picture',
                                    'resolved_by' => 'Support Team',
                                    'resolved_at' => '5 hours ago',
                                ],
                                [
                                    'id' => 'TCKT-' . rand(10000, 99999),
                                    'user' => 'James Thompson',
                                    'subject' => 'Payment method verification failed',
                                    'resolved_by' => 'Finance Team',
                                    'resolved_at' => 'Yesterday',
                                ],
                            ];
                        @endphp

                        @foreach ($resolvedTickets as $ticket)
                            <div
                                class="flex justify-between items-center border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $ticket['subject'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $ticket['id'] }} • {{ $ticket['user'] }}</p>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="h-1.5 w-1.5 mr-1.5 rounded-full bg-green-500"></span>
                                        Resolved
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">By {{ $ticket['resolved_by'] }} •
                                        {{ $ticket['resolved_at'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
