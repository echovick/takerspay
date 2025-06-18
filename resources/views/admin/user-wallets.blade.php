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
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">User Wallets</h1>
                            <p class="mt-1 text-gray-600">Manage and monitor all user wallets across the platform</p>
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
                                <input type="text" placeholder="Search wallets"
                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <select
                                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Filter by Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="suspended">Suspended</option>
                            </select>

                            <button
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                New Wallet
                            </button>
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
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Total Wallets</h3>
                            <p class="text-xl font-bold text-gray-900">{{ number_format(1254) }}</p>
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
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Total Balance</h3>
                            <p class="text-xl font-bold text-gray-900">${{ number_format(2548956, 2) }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-lg shadow-md p-5 border-l-4 border-indigo-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="bg-indigo-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Active Wallets</h3>
                            <p class="text-xl font-bold text-gray-900">{{ number_format(1087) }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-lg shadow-md p-5 border-l-4 border-purple-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="bg-purple-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Transactions Today</h3>
                            <p class="text-xl font-bold text-gray-900">{{ number_format(156) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wallets Table -->
            <div
                class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden mb-6 animate__animated animate__fadeIn animate__delay-2s">
                <div class="bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200 px-6 py-4">
                    <h2 class="text-lg font-medium text-gray-900">User Wallets</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Wallet ID</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Balance</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Last Transaction</th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                // Sample data - replace with actual wallet data in production
                                $wallets = [
                                    [
                                        'user' => ['name' => 'John Doe', 'email' => 'john@example.com', 'id' => 1],
                                        'id' => 'WAL-12345',
                                        'type' => 'fiat',
                                        'balance' => 2500.75,
                                        'currency' => 'USD',
                                        'status' => 'active',
                                        'last_transaction' => '2023-10-12 14:25',
                                    ],
                                    [
                                        'user' => ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'id' => 2],
                                        'id' => 'WAL-12346',
                                        'type' => 'crypto',
                                        'balance' => 0.75,
                                        'currency' => 'BTC',
                                        'status' => 'active',
                                        'last_transaction' => '2023-10-11 08:35',
                                    ],
                                    [
                                        'user' => [
                                            'name' => 'Robert Johnson',
                                            'email' => 'robert@example.com',
                                            'id' => 3,
                                        ],
                                        'id' => 'WAL-12347',
                                        'type' => 'fiat',
                                        'balance' => 750.25,
                                        'currency' => 'EUR',
                                        'status' => 'inactive',
                                        'last_transaction' => '2023-10-05 16:40',
                                    ],
                                    [
                                        'user' => ['name' => 'Emily Wilson', 'email' => 'emily@example.com', 'id' => 4],
                                        'id' => 'WAL-12348',
                                        'type' => 'fiat',
                                        'balance' => 1200.0,
                                        'currency' => 'USD',
                                        'status' => 'active',
                                        'last_transaction' => '2023-10-10 09:15',
                                    ],
                                    [
                                        'user' => [
                                            'name' => 'Michael Brown',
                                            'email' => 'michael@example.com',
                                            'id' => 5,
                                        ],
                                        'id' => 'WAL-12349',
                                        'type' => 'crypto',
                                        'balance' => 2.5,
                                        'currency' => 'ETH',
                                        'status' => 'suspended',
                                        'last_transaction' => '2023-09-28 12:10',
                                    ],
                                ];
                            @endphp

                            @foreach ($wallets as $wallet)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="h-10 w-10 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold">
                                                {{ substr($wallet['user']['name'], 0, 1) }}{{ substr(strrchr($wallet['user']['name'], ' '), 1, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <a href="{{ route('admin.user-details', $wallet['user']['id']) }}"
                                                        class="hover:text-blue-600">
                                                        {{ $wallet['user']['name'] }}
                                                    </a>
                                                </div>
                                                <div class="text-sm text-gray-500">{{ $wallet['user']['email'] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-mono text-gray-900">{{ $wallet['id'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $wallet['type'] == 'fiat' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                            {{ ucfirst($wallet['type']) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ number_format($wallet['balance'], $wallet['currency'] == 'BTC' || $wallet['currency'] == 'ETH' ? 8 : 2) }}
                                            {{ $wallet['currency'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $wallet['status'] == 'active' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $wallet['status'] == 'inactive' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $wallet['status'] == 'suspended' ? 'bg-red-100 text-red-800' : '' }}">
                                            <span
                                                class="h-2 w-2 mr-1.5 rounded-full 
                                                {{ $wallet['status'] == 'active' ? 'bg-green-500' : '' }}
                                                {{ $wallet['status'] == 'inactive' ? 'bg-gray-500' : '' }}
                                                {{ $wallet['status'] == 'suspended' ? 'bg-red-500' : '' }}"></span>
                                            {{ ucfirst($wallet['status']) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $wallet['last_transaction'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button type="button" class="text-indigo-600 hover:text-indigo-900"
                                                title="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            <button type="button" class="text-emerald-600 hover:text-emerald-900"
                                                title="Deposit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </button>
                                            <button type="button" class="text-blue-600 hover:text-blue-900"
                                                title="Transfer">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                                </svg>
                                            </button>
                                            <button type="button" class="text-red-600 hover:text-red-900"
                                                title="Suspend">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
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
                                    class="font-medium">25</span> results
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
                                    class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    10
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

            <!-- Recent Activity Section -->
            <div
                class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden mb-6 animate__animated animate__fadeIn animate__delay-3s">
                <div class="bg-gradient-to-r from-gray-50 to-green-50 border-b border-gray-200 px-6 py-4">
                    <h2 class="text-lg font-medium text-gray-900">Recent Wallet Activity</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Wallet ID</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                // Sample data - replace with actual transaction data in production
                                $transactions = [
                                    [
                                        'user' => ['name' => 'John Doe', 'id' => 1],
                                        'wallet_id' => 'WAL-12345',
                                        'type' => 'deposit',
                                        'amount' => 500.0,
                                        'currency' => 'USD',
                                        'status' => 'completed',
                                        'date' => '2023-10-12 14:25',
                                    ],
                                    [
                                        'user' => ['name' => 'Jane Smith', 'id' => 2],
                                        'wallet_id' => 'WAL-12346',
                                        'type' => 'withdrawal',
                                        'amount' => 0.25,
                                        'currency' => 'BTC',
                                        'status' => 'pending',
                                        'date' => '2023-10-11 08:35',
                                    ],
                                    [
                                        'user' => ['name' => 'Emily Wilson', 'id' => 4],
                                        'wallet_id' => 'WAL-12348',
                                        'type' => 'deposit',
                                        'amount' => 1200.0,
                                        'currency' => 'USD',
                                        'status' => 'completed',
                                        'date' => '2023-10-10 09:15',
                                    ],
                                    [
                                        'user' => ['name' => 'Robert Johnson', 'id' => 3],
                                        'wallet_id' => 'WAL-12347',
                                        'type' => 'transfer',
                                        'amount' => 250.75,
                                        'currency' => 'EUR',
                                        'status' => 'completed',
                                        'date' => '2023-10-05 16:40',
                                    ],
                                    [
                                        'user' => ['name' => 'Michael Brown', 'id' => 5],
                                        'wallet_id' => 'WAL-12349',
                                        'type' => 'withdrawal',
                                        'amount' => 1.5,
                                        'currency' => 'ETH',
                                        'status' => 'failed',
                                        'date' => '2023-09-28 12:10',
                                    ],
                                ];
                            @endphp

                            @foreach ($transactions as $transaction)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="h-8 w-8 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold">
                                                {{ substr($transaction['user']['name'], 0, 1) }}{{ substr(strrchr($transaction['user']['name'], ' '), 1, 1) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <a href="{{ route('admin.user-details', $transaction['user']['id']) }}"
                                                        class="hover:text-blue-600">
                                                        {{ $transaction['user']['name'] }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-mono text-gray-900">{{ $transaction['wallet_id'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $transaction['type'] == 'deposit' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $transaction['type'] == 'withdrawal' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $transaction['type'] == 'transfer' ? 'bg-blue-100 text-blue-800' : '' }}">
                                            {{ ucfirst($transaction['type']) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="text-sm font-medium 
                                            {{ $transaction['type'] == 'deposit' ? 'text-green-600' : '' }}
                                            {{ $transaction['type'] == 'withdrawal' ? 'text-red-600' : '' }}
                                            {{ $transaction['type'] == 'transfer' ? 'text-blue-600' : '' }}">
                                            {{ $transaction['type'] == 'deposit' ? '+' : '-' }}{{ number_format($transaction['amount'], $transaction['currency'] == 'BTC' || $transaction['currency'] == 'ETH' ? 8 : 2) }}
                                            {{ $transaction['currency'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $transaction['status'] == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $transaction['status'] == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $transaction['status'] == 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($transaction['status']) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $transaction['date'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-200">
                    <a href="{{ route('admin.transaction-history') }}"
                        class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        View all transactions <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
