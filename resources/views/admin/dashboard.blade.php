@extends('layout.app')

@section('content')
    <!-- Add Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    @include('admin.includes.nav-bar')

    <!-- Sidebar -->
    @include('admin.includes.side-bar')

    <!-- Mobile-optimized Content Area with web compatibility -->
    <main class="p-2 md:p-4 md:ml-64 h-auto pt-20 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="container mx-auto max-w-7xl">
            <!-- Page Header -->
            <div class="bg-white rounded-xl shadow-lg mb-6 overflow-hidden animate__animated animate__fadeIn">
                <div class="relative overflow-hidden">
                    <!-- Background with proper gradient and height -->
                    <div class="h-28 bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600">
                        <!-- Decorative elements properly positioned -->
                        <div class="absolute top-5 right-10 h-24 w-24 rounded-full bg-white opacity-10"></div>
                        <div class="absolute bottom-5 left-20 h-32 w-32 rounded-full bg-white opacity-5"></div>
                        <div class="absolute -bottom-16 -right-8 h-48 w-48 rounded-full bg-indigo-500 opacity-10"></div>
                    </div>
                </div>

                <!-- Content section with proper spacing -->
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Admin Dashboard</h1>
                            <p class="mt-1 text-gray-600">Overview of platform activities and statistics</p>
                        </div>

                        <!-- Date filter -->
                        <div class="mt-4 md:mt-0 flex flex-col md:flex-row gap-2">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" placeholder="Filter by date"
                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <button
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Export Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- App Context Switcher -->
            <div class="animate__animated animate__fadeIn">
                @include('admin.includes.app-context-switcher')
            </div>

            <!-- Dashboard Stats -->
            <div class="animate__animated animate__fadeIn animate__delay-1s">
                <livewire:admin.context-aware-stats context="{{ request()->get('context', 'all') }}" />
            </div>

            <!-- Recent Activities -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 animate__animated animate__fadeIn animate__delay-2s">
                <livewire:admin.context-aware-activities context="{{ request()->get('context', 'all') }}" />

                <!-- App Context Specific Information -->
                @if (request()->get('context') === 'crypto' || !request()->has('context') || request()->get('context') === 'all')
                    <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-50 to-indigo-50 border-b border-gray-200 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-medium text-gray-900">Crypto Assets</h2>
                                <a href="{{ route('admin.asset-management') }}"
                                    class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Manage Assets</a>
                            </div>
                        </div>
                        <div class="p-4">
                            <livewire:admin.asset-summary />
                        </div>
                    </div>
                @endif

                @if (request()->get('context') === 'finance' || !request()->has('context') || request()->get('context') === 'all')
                    <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-50 to-green-50 border-b border-gray-200 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-medium text-gray-900">Support Tickets</h2>
                                <a href="{{ route('admin.tickets-management') }}"
                                    class="text-sm text-green-600 hover:text-green-800 font-medium">View All Tickets</a>
                            </div>
                        </div>
                        <div class="p-4">
                            <livewire:admin.ticket-summary />
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateContext(context) {
                // Dispatch Livewire event to update context in components
                Livewire.dispatch('contextChanged', {
                    context: context
                });
            }

            // Get current context from URL
            const urlParams = new URLSearchParams(window.location.search);
            const currentContext = urlParams.get('context') || 'all';

            // Initialize with current context
            updateContext(currentContext);

            // Add event listeners to context switcher buttons
            document.querySelectorAll('.context-switch-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    const context = this.dataset.context;
                    updateContext(context);
                });
            });
        });
    </script>
@endsection
