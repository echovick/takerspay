<!-- Minimal Mobile-First Navigation Bar -->
<nav class="bg-white border-b border-gray-100 px-4 py-3 fixed left-0 right-0 top-0 z-50">
    <div class="flex items-center justify-between">
        <!-- Left Section -->
        <div class="flex items-center">
            <!-- Mobile Menu Toggle -->
            <button id="mobile-menu-btn"
                    onclick="document.getElementById('drawer-navigation').classList.toggle('-translate-x-full'); document.getElementById('sidebar-overlay').classList.toggle('hidden')"
                    class="p-2 rounded-lg hover:bg-gray-100 md:hidden">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            
            <!-- Logo/Title -->
            <h1 class="ml-2 md:ml-0 text-lg font-semibold text-gray-900">
                <span class="hidden md:inline">Takerspay Admin</span>
                <span class="md:hidden">Admin</span>
            </h1>
        </div>
        
        <!-- Right Section -->
        <div class="flex items-center space-x-2">
            <!-- Notifications - Mobile Optimized -->
            <div class="relative">
                <button type="button" 
                        onclick="document.getElementById('notification-menu').classList.toggle('hidden')"
                        class="relative p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    @if(true) <!-- Replace with actual notification count check -->
                        <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-xs">3</span>
                        </span>
                    @endif
                </button>
                
                <!-- Notification Dropdown - Simplified -->
                <div id="notification-menu" class="hidden absolute right-0 mt-2 w-80 md:w-96 bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                    </div>
                    <div class="max-h-80 overflow-y-auto">
                        <!-- Notification Item -->
                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-50">
                            <p class="text-sm text-gray-900">New order received</p>
                            <p class="text-xs text-gray-500 mt-1">2 minutes ago</p>
                        </a>
                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-50">
                            <p class="text-sm text-gray-900">User registration</p>
                            <p class="text-xs text-gray-500 mt-1">15 minutes ago</p>
                        </a>
                        <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                            <p class="text-sm text-gray-900">Payment completed</p>
                            <p class="text-xs text-gray-500 mt-1">1 hour ago</p>
                        </a>
                    </div>
                    <div class="px-4 py-2 border-t border-gray-100">
                        <a href="#" class="text-xs text-blue-600 hover:text-blue-700">View all notifications</a>
                    </div>
                </div>
            </div>
            
            <!-- User Menu -->
            <div class="relative">
                <button type="button"
                        onclick="document.getElementById('user-menu').classList.toggle('hidden')"
                        class="flex items-center p-2 rounded-lg hover:bg-gray-100">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <span class="text-white text-sm font-medium">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </span>
                    </div>
                    <span class="ml-2 text-sm text-gray-700 hidden md:inline">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </span>
                    <svg class="w-4 h-4 ml-1 text-gray-400 hidden md:inline" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                
                <!-- User Dropdown - Simplified -->
                <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email ?? 'admin@takerspay.com' }}</p>
                    </div>
                    <div class="py-1">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Settings</a>
                        <hr class="my-1 border-gray-100">
                        <form method="POST" action="/logout" class="inline">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Click outside to close dropdowns -->
<script>
    document.addEventListener('click', function(event) {
        // Close notification menu if clicked outside
        const notifBtn = event.target.closest('button[onclick*="notification-menu"]');
        const notifMenu = document.getElementById('notification-menu');
        if (!notifBtn && !notifMenu.contains(event.target)) {
            notifMenu.classList.add('hidden');
        }
        
        // Close user menu if clicked outside
        const userBtn = event.target.closest('button[onclick*="user-menu"]');
        const userMenu = document.getElementById('user-menu');
        if (!userBtn && !userMenu.contains(event.target)) {
            userMenu.classList.add('hidden');
        }
    });
</script>