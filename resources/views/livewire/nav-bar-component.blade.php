<div>
    <!-- Mobile Menu Toggle Button (visible on mobile only) -->
    <div class="fixed top-4 left-4 z-50 md:hidden">
        <button id="mobile-menu-toggle" class="p-2 bg-white rounded-lg shadow-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-600">
            <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Overlay (for mobile) -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

    <!-- Side Menu -->
    <div id="sidebar" class="fixed left-0 top-0 h-full w-64 bg-white dark:bg-gray-800 shadow-lg z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out border-r border-gray-200 dark:border-gray-700">
    <!-- Logo/Brand Section -->
    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('assets/imgs/takers-pay-logo.png') }}" alt="TakersPay Logo" class="w-6 h-6">
            <span class="text-sm font-semibold text-gray-800 dark:text-white">TakersPay</span>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-3 py-4">
        <!-- Dashboard Section -->
        <div class="mb-6">
            <h3 class="px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Dashboard</h3>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('app.home') }}" class="nav-link flex items-center px-3 py-2.5 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('app.home') ? 'bg-primary-1010 text-white hover:bg-primary-1010' : '' }}">
                        <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        <span class="text-sm">Home</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Wallet & Trading Section -->
        <div class="mb-6">
            <h3 class="px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Trading</h3>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('app.wallets') }}" class="nav-link flex items-center px-3 py-2.5 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('app.wallets') ? 'bg-primary-1010 text-white hover:bg-primary-1010' : '' }}">
                        <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M11.074 4 8.442.408A.95.95 0 0 0 7.014.254L2.926 4h8.148ZM9 13v-1a4 4 0 0 1 4-4h6V6a1 1 0 0 0-1-1H1a1 1 0 0 0-1 1v13a1 1 0 0 0 1 1h17a1 1 0 0 0 1-1v-2h-6a4 4 0 0 1-4-4Z" />
                            <path d="M19 10h-6a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1Zm-4.5 3.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM12.62 4h2.78L12.539.41a1.086 1.086 0 1 0-1.7 1.352L12.62 4Z" />
                        </svg>
                        <span class="text-sm">Wallets</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('app.order') }}" class="nav-link flex items-center px-3 py-2.5 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('app.order') ? 'bg-primary-1010 text-white hover:bg-primary-1010' : '' }}">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 18 18">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                        </svg>
                        <span class="text-sm">New Order</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('app.all-orders') }}" class="nav-link flex items-center px-3 py-2.5 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('app.all-orders') ? 'bg-primary-1010 text-white hover:bg-primary-1010' : '' }}">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span class="text-sm">Orders</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Account Section -->
        <div class="mb-6">
            <h3 class="px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Account</h3>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('app.settings') }}" class="nav-link flex items-center px-3 py-2.5 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('app.settings') ? 'bg-primary-1010 text-white hover:bg-primary-1010' : '' }}">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12.25V1m0 11.25a2.25 2.25 0 0 0 0 4.5m0-4.5a2.25 2.25 0 0 1 0 4.5M4 19v-2.25m6-13.5V1m0 2.25a2.25 2.25 0 0 0 0 4.5m0-4.5a2.25 2.25 0 0 1 0 4.5M10 19V7.75m6 4.5V1m0 11.25a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM16 19v-2" />
                        </svg>
                        <span class="text-sm">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('app.profile') }}" class="nav-link flex items-center px-3 py-2.5 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('app.profile') ? 'bg-primary-1010 text-white hover:bg-primary-1010' : '' }}">
                        <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z" />
                        </svg>
                        <span class="text-sm">Profile</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Support Section -->
    <div class="px-3 py-3 border-t border-gray-200 dark:border-gray-700">
        <a href="mailto:support@takerspay.com" class="flex items-center px-3 py-2 text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M12 2a7 7 0 0 0-7 7 3 3 0 0 0-3 3v2a3 3 0 0 0 3 3h1a1 1 0 0 0 1-1V9a5 5 0 1 1 10 0v7.083A2.919 2.919 0 0 1 14.083 19H14a2 2 0 0 0-2-2h-1a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h1a2 2 0 0 0 1.732-1h.351a4.917 4.917 0 0 0 4.83-4H19a3 3 0 0 0 3-3v-2a3 3 0 0 0-3-3 7 7 0 0 0-7-7Zm1.45 3.275a4 4 0 0 0-4.352.976 1 1 0 0 0 1.452 1.376 2.001 2.001 0 0 1 2.836-.067 1 1 0 1 0 1.386-1.442 4 4 0 0 0-1.321-.843Z" clip-rule="evenodd" />
            </svg>
            <span class="text-xs">Support</span>
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    
    function toggleSidebar() {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }
    
    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }
    
    mobileMenuToggle?.addEventListener('click', toggleSidebar);
    overlay?.addEventListener('click', closeSidebar);
    
    // Close sidebar when clicking nav links on mobile
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 768) {
                closeSidebar();
            }
        });
    });
    
    // Handle window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            closeSidebar();
        }
    });
});
</script>
</div>
