@extends('layout.app')

@section('content')
    @include('admin.includes.nav-bar')
    @include('admin.includes.side-bar')

    <!-- Main Content - Mobile Optimized -->
    <main class="p-[25px] md:ml-60 pt-[100px] bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Page Header - Simplified -->
            <div class="mb-6">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-sm text-gray-600 mt-1">Manage your applications and monitor activities</p>
            </div>

            <!-- App Context Switcher - Mobile Optimized -->
            <div class="mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <h2 class="text-sm font-semibold text-gray-900">Application Context</h2>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <!-- All Apps -->
                            <a href="{{ route('admin.dashboard', ['context' => 'all']) }}"
                                class="p-3 rounded-lg border transition-colors {{ request()->get('context') == 'all' || !request()->has('context') ? 'bg-blue-50 border-blue-200 text-blue-800' : 'bg-gray-50 border-gray-200 hover:bg-gray-100 text-gray-700' }}">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                    <span class="text-xs font-medium">All Apps</span>
                                </div>
                            </a>

                            <!-- Crypto App -->
                            <a href="{{ route('admin.dashboard', ['context' => 'crypto']) }}"
                                class="p-3 rounded-lg border transition-colors {{ request()->get('context') == 'crypto' ? 'bg-amber-50 border-amber-200 text-amber-800' : 'bg-gray-50 border-gray-200 hover:bg-gray-100 text-gray-700' }}">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    <span class="text-xs font-medium">Crypto</span>
                                </div>
                            </a>

                            <!-- Financial App -->
                            <a href="{{ route('admin.dashboard', ['context' => 'finance']) }}"
                                class="p-3 rounded-lg border transition-colors {{ request()->get('context') == 'finance' ? 'bg-green-50 border-green-200 text-green-800' : 'bg-gray-50 border-gray-200 hover:bg-gray-100 text-gray-700' }}">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                        </path>
                                    </svg>
                                    <span class="text-xs font-medium">Finance</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Stats - Mobile Optimized -->
            <div class="mb-6">
                <livewire:admin.context-aware-stats context="{{ request()->get('context', 'all') }}" />
            </div>

            <!-- Quick Actions - Mobile First -->
            <div class="mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <h2 class="text-sm font-semibold text-gray-900">Quick Actions</h2>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <a href="{{ route('admin.user-management') }}"
                                class="flex flex-col items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <svg class="w-6 h-6 text-blue-600 mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                                <span class="text-xs font-medium text-gray-700">Users</span>
                            </a>

                            <a href="{{ route('admin.order-management') }}"
                                class="flex flex-col items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <svg class="w-6 h-6 text-green-600 mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <span class="text-xs font-medium text-gray-700">Orders</span>
                            </a>

                            <a href="{{ route('admin.user-wallets') }}"
                                class="flex flex-col items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <svg class="w-6 h-6 text-purple-600 mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                    </path>
                                </svg>
                                <span class="text-xs font-medium text-gray-700">Wallets</span>
                            </a>

                            <a href="{{ route('admin.transaction-history') }}"
                                class="flex flex-col items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <svg class="w-6 h-6 text-amber-600 mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                    </path>
                                </svg>
                                <span class="text-xs font-medium text-gray-700">Transactions</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid - Mobile Responsive -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Activities -->
                <div class="space-y-6">
                    <livewire:admin.context-aware-activities context="{{ request()->get('context', 'all') }}" />
                </div>

                <!-- Sidebar Components -->
                <div class="space-y-6">
                    <!-- Asset Summary - Conditional -->
                    @if (request()->get('context') === 'crypto' || !request()->has('context') || request()->get('context') === 'all')
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-gray-900">Assets</h3>
                                <a href="{{ route('admin.asset-management') }}"
                                    class="text-xs text-blue-600 hover:text-blue-700">View All</a>
                            </div>
                            <div class="p-4">
                                <livewire:admin.asset-summary />
                            </div>
                        </div>
                    @endif

                    <!-- Support Tickets - Conditional -->
                    @if (request()->get('context') === 'finance' || !request()->has('context') || request()->get('context') === 'all')
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-gray-900">Support Tickets</h3>
                                <a href="{{ route('admin.tickets-management') }}"
                                    class="text-xs text-blue-600 hover:text-blue-700">View All</a>
                            </div>
                            <div class="p-4">
                                <livewire:admin.ticket-summary />
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- JavaScript for Context Switching -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateContext(context) {
                Livewire.dispatch('contextChanged', {
                    context: context
                });
            }

            // Get current context from URL
            const urlParams = new URLSearchParams(window.location.search);
            const currentContext = urlParams.get('context') || 'all';

            // Initialize with current context
            updateContext(currentContext);
        });
    </script>
@endsection
