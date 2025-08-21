@extends('layout.app')

@section('content')
    <div class="app-wrapper">
        <div class="flex flex-row justify-between">
            <div class="">
                <p class="text-sm font-semibold">Hello {{ ucwords(auth()->user()?->metaData?->tag) }} <br> <span
                        class="text-xs font-normal">Welcome to your dashboard</span></p>
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
