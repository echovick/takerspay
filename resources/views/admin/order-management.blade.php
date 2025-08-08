@extends('layout.app')

@section('content')
    @include('admin.includes.nav-bar')
    @include('admin.includes.side-bar')

    <!-- Main Content - Mobile Optimized -->
    <main class="p-[25px] md:ml-60 pt-[100px] bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Page Header - Simplified -->
            <div class="mb-6">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Order Management</h1>
                <p class="text-sm text-gray-600 mt-1">Track and manage all customer orders across the platform</p>
            </div>

            <!-- Search and Filters -->
            <div class="mb-6">
                <livewire:admin.order-management-filters />
            </div>

            <!-- Order Stats -->
            <div class="mb-6">
                <livewire:admin.order-stats-component />
            </div>

            <!-- Orders Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="px-4 py-3 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900">All Orders</h3>
                </div>
                <div class="p-4">
                    <livewire:admin.orders-table-component />
                </div>
            </div>
        </div>
    </main>
@endsection
