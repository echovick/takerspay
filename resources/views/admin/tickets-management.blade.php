@extends('layout.app')

@section('content')
    @include('admin.includes.nav-bar')
    @include('admin.includes.side-bar')

    <!-- Main Content - Mobile Optimized -->
    <main class="p-[25px] md:ml-60 pt-[100px] bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Page Header - Simplified -->
            <div class="mb-6">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Support Tickets</h1>
                <p class="text-sm text-gray-600 mt-1">Manage and respond to customer support inquiries</p>
            </div>

            <!-- Search and Filters -->
            <div class="mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <h2 class="text-sm font-semibold text-gray-900">Search & Filters</h2>
                    </div>
                    <div class="p-4">
                        <div class="flex flex-col lg:flex-row gap-3">
                            <div class="relative flex-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" placeholder="Search tickets..." class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>
                            <select class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="">All Status</option>
                                <option value="open">Open</option>
                                <option value="in-progress">In Progress</option>
                                <option value="resolved">Resolved</option>
                                <option value="closed">Closed</option>
                            </select>
                            <select class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="">All Priority</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Stats -->
            <div class="mb-6">
                <livewire:admin.context-aware-stats context="finance" />
            </div>

            <!-- Support Tickets Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-900">All Support Tickets</h3>
                    <div class="text-xs text-gray-500">{{ number_format(248) }} total tickets</div>
                </div>
                <div class="p-0">
                    <!-- Tickets content would go here -->
                    <div class="p-8 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <p class="text-sm">Support tickets component will be displayed here</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection