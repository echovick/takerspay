@extends('layout.app')

@section('content')
    @include('admin.includes.nav-bar')

    <!-- Sidebar -->
    @include('admin.includes.side-bar')

    <!-- Content Area -->
    <main class="p-4 md:ml-60 h-auto pt-20">
        <livewire:admin.user-wallets-component />
    </main>

@endsection
