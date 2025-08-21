@extends('layout.app')

@section('content')
    <div class="app-wrapper">
        <livewire:orders.order-record />
        
        {{-- Menu Bar --}}
        <livewire:nav-bar-component />
    </div>
@endsection
