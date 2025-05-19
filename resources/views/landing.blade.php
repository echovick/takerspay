@extends('layout.app')

@section('content')
    <div>
        {{-- Header/Navbar --}}
        @livewire('landing.navbar-section')

        {{-- Hero Section --}}
        @livewire('landing.hero-section')

        {{-- Crypto Prices Ticker --}}
        @livewire('landing.crypto-prices-ticker')

        {{-- Features Section --}}
        <div id="features">
            @livewire('landing.features-section')
        </div>

        {{-- Testimonials Section --}}
        @livewire('landing.testimonials-section')

        {{-- CTA Section --}}
        @livewire('landing.cta-section')

        {{-- Footer --}}
        <div id="contact">
            @livewire('landing.footer-section')
        </div>
    </div>
@endsection
