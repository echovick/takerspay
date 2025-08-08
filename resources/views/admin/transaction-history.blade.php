@extends('layout.app')

@section('content')
    @include('admin.includes.nav-bar')
    @include('admin.includes.side-bar')

    <!-- Main Content - Mobile Optimized -->
    <main class="p-[25px] md:ml-60 pt-[100px] bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Page Header - Simplified -->
            <div class="mb-6">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Transaction History</h1>
                <p class="text-sm text-gray-600 mt-1">View and analyze all transactions across the platform</p>
            </div>

            <!-- Search and Filters -->
            <div class="mb-6">
                <livewire:admin.transaction-filters />
            </div>

            <!-- Dashboard Stats -->
            <div class="mb-6">
                <livewire:admin.transaction-stats-component />
            </div>

            <!-- Transactions Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="px-4 py-3 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900">Transaction History</h3>
                </div>
                <div class="p-4">
                    <livewire:admin.transactions-table-component />
                </div>
            </div>
        </div>
    </main>
@endsection