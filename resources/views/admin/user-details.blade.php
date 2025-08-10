@extends('layout.app')

@section('content')
    @include('admin.includes.nav-bar')
    @include('admin.includes.side-bar')

    @php
        $userId = request()->segment(3);
        $user = App\Models\User::find($userId);
    @endphp

    <!-- Main Content - Responsive for both Mobile and Desktop -->
    <main class="p-[25px] md:ml-60 pt-[100px] bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Page Header -->
            <div class="mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                    <div class="flex items-center space-x-3 mb-2 sm:mb-0">
                        <a href="{{ route('admin.user-management') }}" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                        </a>
                        <h1 class="text-xl md:text-2xl font-bold text-gray-900">
                            {{ trim(($user->metaData->first_name ?? '') . ' ' . ($user->metaData->last_name ?? '')) ?: $user->email }}
                        </h1>
                        @php
                            $kycStatus = $user->metaData->status ?? 'inactive';
                        @endphp
                        @if ($kycStatus === 'active')
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 mr-1.5 bg-green-400 rounded-full"></span>
                                Verified
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <span class="w-1.5 h-1.5 mr-1.5 bg-yellow-400 rounded-full"></span>
                                Pending
                            </span>
                        @endif
                    </div>
                    <div class="text-sm text-gray-600">
                        <span class="hidden sm:inline">ID: {{ $user->id }} • </span>
                        Joined {{ $user->created_at->format('M d, Y') }}
                    </div>
                </div>
                <p class="text-sm text-gray-600">Manage user wallet and transaction activities</p>
            </div>

            <!-- User Stats Section -->
            <div class="mb-6">
                <livewire:admin.user-details-stats-component :user="$user" />
            </div>

            <!-- Wallet Management Actions -->
            <div class="mb-6">
                <livewire:admin.user-wallet-management-component :user="$user" />
            </div>

            <!-- Transaction History Section -->
            <div>
                <livewire:admin.user-transaction-history-component :user="$user" />
            </div>
        </div>
    </main>
@endsection
