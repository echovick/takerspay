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
                <livewire:admin.ticket-filters />
            </div>

            <!-- Dashboard Stats -->
            <div class="mb-6">
                <livewire:admin.ticket-stats-component />
            </div>

            <!-- Support Tickets Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="px-4 py-3 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900">Support Tickets Management</h3>
                </div>
                <div class="p-4">
                    <livewire:admin.tickets-table-component />
                </div>
            </div>
        </div>
    </main>
@endsection