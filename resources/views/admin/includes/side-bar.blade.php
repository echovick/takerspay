<aside
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidenav" id="drawer-navigation">
    <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
        <form action="#" method="GET" class="md:hidden mb-2">
            <label for="sidebar-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z">
                        </path>
                    </svg>
                </div>
                <input type="text" name="search" id="sidebar-search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Search" />
            </div>
        </form>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center p-2 text-base font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }} dark:text-white dark:hover:bg-gray-700 group">
                    <svg aria-hidden="true"
                        class="w-6 h-6 {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-500 group-hover:text-gray-900' }} transition duration-75 dark:text-gray-400 dark:group-hover:text-white"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                    </svg>
                    <span class="ml-3 font-medium text-sm">Dashboard</span>
                </a>
            </li>
            <hr class="my-2">
            <li>
                <a href="{{ route('admin.user-management') }}"
                    class="flex items-center p-2 text-base font-medium rounded-lg {{ request()->routeIs('admin.user-management') || request()->routeIs('admin.user-details') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }} transition duration-75 dark:hover:bg-gray-700 dark:text-white group">
                    <svg aria-hidden="true"
                        class="flex-shrink-0 w-6 h-6 {{ request()->routeIs('admin.user-management') || request()->routeIs('admin.user-details') ? 'text-blue-600' : 'text-gray-500 group-hover:text-gray-900' }} transition duration-75 dark:text-gray-400 dark:group-hover:text-white"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z">
                        </path>
                    </svg>
                    <span class="ml-3 font-medium text-sm">User Management</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.order-management') }}"
                    class="flex items-center p-2 text-base font-medium rounded-lg {{ request()->routeIs('admin.order-management') || request()->routeIs('admin.order-details') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }} transition duration-75 dark:hover:bg-gray-700 dark:text-white group">
                    <svg aria-hidden="true"
                        class="flex-shrink-0 w-6 h-6 {{ request()->routeIs('admin.order-management') || request()->routeIs('admin.order-details') ? 'text-blue-600' : 'text-gray-500 group-hover:text-gray-900' }} transition duration-75 dark:text-gray-400 dark:group-hover:text-white"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                        </path>
                    </svg>
                    <span class="ml-3 font-medium text-sm">Order Management</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.asset-management') }}"
                    class="flex items-center p-2 text-base font-medium rounded-lg {{ request()->routeIs('admin.asset-management') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }} transition duration-75 dark:hover:bg-gray-700 dark:text-white group">
                    <svg aria-hidden="true"
                        class="flex-shrink-0 w-6 h-6 {{ request()->routeIs('admin.asset-management') ? 'text-blue-600' : 'text-gray-500 group-hover:text-gray-900' }} transition duration-75 dark:text-gray-400 dark:group-hover:text-white"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-3 font-medium text-sm">Asset Management</span>
                </a>
            </li>
            <hr class="my-2">
            <li>
                <a href="{{ route('admin.user-wallets') }}"
                    class="flex items-center p-2 text-base font-medium rounded-lg {{ request()->routeIs('admin.user-wallets') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }} transition duration-75 dark:hover:bg-gray-700 dark:text-white group">
                    <svg aria-hidden="true"
                        class="flex-shrink-0 w-6 h-6 {{ request()->routeIs('admin.user-wallets') ? 'text-blue-600' : 'text-gray-500 group-hover:text-gray-900' }} transition duration-75 dark:text-gray-400 dark:group-hover:text-white"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                        <path fill-rule="evenodd"
                            d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-3 font-medium text-sm">User Wallets</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transaction-history') }}"
                    class="flex items-center p-2 text-base font-medium rounded-lg {{ request()->routeIs('admin.transaction-history') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }} transition duration-75 dark:hover:bg-gray-700 dark:text-white group">
                    <svg aria-hidden="true"
                        class="flex-shrink-0 w-6 h-6 {{ request()->routeIs('admin.transaction-history') ? 'text-blue-600' : 'text-gray-500 group-hover:text-gray-900' }} transition duration-75 dark:text-gray-400 dark:group-hover:text-white"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z">
                        </path>
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-3 font-medium text-sm">Transaction History</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.tickets-management') }}"
                    class="flex items-center p-2 text-base font-medium rounded-lg {{ request()->routeIs('admin.tickets-management') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }} transition duration-75 dark:hover:bg-gray-700 dark:text-white group">
                    <svg aria-hidden="true"
                        class="flex-shrink-0 w-6 h-6 {{ request()->routeIs('admin.tickets-management') ? 'text-blue-600' : 'text-gray-500 group-hover:text-gray-900' }} transition duration-75 dark:text-gray-400 dark:group-hover:text-white"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-3 font-medium text-sm">Support Tickets</span>
                </a>
            </li>
            <hr class="my-2">
            @if (auth()->user()->role == 'super-admin')
                <li>
                    <a href="{{ route('admin.settings') }}"
                        class="flex items-center p-2 text-base font-medium rounded-lg {{ request()->routeIs('admin.settings') ? 'bg-blue-50 text-blue-600' : 'text-gray-900 hover:bg-gray-100' }} transition duration-75 dark:hover:bg-gray-700 dark:text-white group">
                        <svg aria-hidden="true"
                            class="flex-shrink-0 w-6 h-6 {{ request()->routeIs('admin.settings') ? 'text-blue-600' : 'text-gray-500 group-hover:text-gray-900' }} transition duration-75 dark:text-gray-400 dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-3 font-medium text-sm">Settings</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</aside>
