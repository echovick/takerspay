@extends('layout.app')

@section('content')
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        @include('admin.includes.nav-bar')

        <!-- Sidebar -->
        @include('admin.includes.side-bar')

        <main class="p-4 md:ml-64 h-auto pt-20">
            <livewire:admin.dashboard-stats />

            <!-- Latest Orders Table -->
            <livewire:admin.recent-orders />
        </main>
    </div>
@endsection
