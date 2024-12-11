@extends('layout.app')

@section('content')
    <div class="app-wrapper">
        <div class="flex flex-row justify-between">
            <div class="">
                <p class="text-sm font-semibold">Hello {{ auth()->user()?->metaData?->first_name }}
                    {{ auth()->user()?->metaData?->last_name }} <br> <span class="text-xs font-normal">Welcome to your
                        dashboard</span></p>
            </div>
            <div class="">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M12 2a7 7 0 0 0-7 7 3 3 0 0 0-3 3v2a3 3 0 0 0 3 3h1a1 1 0 0 0 1-1V9a5 5 0 1 1 10 0v7.083A2.919 2.919 0 0 1 14.083 19H14a2 2 0 0 0-2-2h-1a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h1a2 2 0 0 0 1.732-1h.351a4.917 4.917 0 0 0 4.83-4H19a3 3 0 0 0 3-3v-2a3 3 0 0 0-3-3 7 7 0 0 0-7-7Zm1.45 3.275a4 4 0 0 0-4.352.976 1 1 0 0 0 1.452 1.376 2.001 2.001 0 0 1 2.836-.067 1 1 0 1 0 1.386-1.442 4 4 0 0 0-1.321-.843Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </div>
        <hr class="my-4">

        {{-- Overview Cards --}}
        <livewire:dashboard.overview-cards />
        <hr class="my-4">

        {{-- Quick Action --}}
        @include('app.includes.dashboard.quick-actions')
        <hr class="my-4">

        {{-- Recent Orders --}}
        <livewire:dashboard.recent-orders />

        {{-- Menu Bar --}}
        <livewire:nav-bar-component />
    </div>
@endsection
