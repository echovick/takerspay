<!-- Mobile-First Minimal Sidebar -->
<aside
    class="fixed inset-y-0 left-0 z-40 w-64 md:w-60 bg-white border-r border-gray-100 transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out"
    id="drawer-navigation">

    <!-- Mobile Close Button -->
    <div class="md:hidden absolute top-4 right-4">
        <button onclick="document.getElementById('drawer-navigation').classList.add('-translate-x-full')"
            class="p-2 rounded-lg hover:bg-gray-100">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Logo Section - Simplified -->
    <div class="h-16 flex items-center px-5 border-b border-gray-100">
        <h2 class="text-lg font-semibold text-gray-900">Takerspay</h2>
    </div>

    <!-- Navigation Menu - Simplified -->
    <nav class="px-3 py-4 overflow-y-auto h-[calc(100vh-4rem)]">
        <!-- Main Menu -->
        <ul class="space-y-1">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="text-sm font-medium">Dashboard</span>
                    @if (request()->routeIs('admin.dashboard'))
                        <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
                    @endif
                </a>
            </li>

            <!-- Section Label -->
            <li class="pt-3 pb-1">
                <p class="px-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Manage</p>
            </li>

            <!-- Users -->
            <li>
                <a href="{{ route('admin.user-management') }}"
                    class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.user-management') || request()->routeIs('admin.user-details') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <span class="text-sm font-medium">Users</span>
                    @if (request()->routeIs('admin.user-management') || request()->routeIs('admin.user-details'))
                        <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
                    @endif
                </a>
            </li>

            <!-- Orders -->
            <li>
                <a href="{{ route('admin.order-management') }}"
                    class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.order-management') || request()->routeIs('admin.order-details') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="text-sm font-medium">Orders</span>
                    @if (request()->routeIs('admin.order-management') || request()->routeIs('admin.order-details'))
                        <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
                    @endif
                </a>
            </li>

            <!-- Assets -->
            <li>
                <a href="{{ route('admin.asset-management') }}"
                    class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.asset-management') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    <span class="text-sm font-medium">Assets</span>
                    @if (request()->routeIs('admin.asset-management'))
                        <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
                    @endif
                </a>
            </li>

            <!-- Section Label -->
            <li class="pt-3 pb-1">
                <p class="px-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Finance</p>
            </li>

            <!-- Wallets -->
            <li>
                <a href="{{ route('admin.user-wallets') }}"
                    class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.user-wallets') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                        </path>
                    </svg>
                    <span class="text-sm font-medium">Wallets</span>
                    @if (request()->routeIs('admin.user-wallets'))
                        <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
                    @endif
                </a>
            </li>

            <!-- Transactions -->
            <li>
                <a href="{{ route('admin.transaction-history') }}"
                    class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.transaction-history') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    <span class="text-sm font-medium">Transactions</span>
                    @if (request()->routeIs('admin.transaction-history'))
                        <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
                    @endif
                </a>
            </li>

            <!-- Support -->
            <li>
                <a href="{{ route('admin.tickets-management') }}"
                    class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.tickets-management') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <span class="text-sm font-medium">Support</span>
                    @if (request()->routeIs('admin.tickets-management'))
                        <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
                    @endif
                </a>
            </li>

            @if (auth()->user()->role == 'super-admin-')
                <!-- Settings -->
                <li class="pt-3">
                    <a href="{{ route('admin.settings') }}"
                        class="flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.settings') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">Settings</span>
                        @if (request()->routeIs('admin.settings'))
                            <div class="ml-auto w-2 h-2 bg-blue-600 rounded-full"></div>
                        @endif
                    </a>
                </li>
            @endif
        </ul>

        <!-- Logout - Fixed at Bottom -->
        <div class="mt-auto pt-4 border-t border-gray-100">
            <form method="POST" action="/logout">
                @csrf
                <button type="submit"
                    class="flex items-center w-full px-3 py-2.5 rounded-lg text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <span class="text-sm font-medium">Logout</span>
                </button>
            </form>
        </div>
    </nav>
</aside>

<!-- Mobile Overlay -->
<div id="sidebar-overlay"
    onclick="document.getElementById('drawer-navigation').classList.add('-translate-x-full'); this.classList.add('hidden')"
    class="fixed inset-0 bg-gray-900 bg-opacity-50 z-30 hidden md:hidden"></div>
