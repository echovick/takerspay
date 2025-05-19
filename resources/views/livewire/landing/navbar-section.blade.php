<nav x-data="{ open: false }" class="bg-white shadow sticky top-0 z-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <div class="flex flex-shrink-0 items-center">
                    <a href="{{ url('/') }}">
                        <img class="h-12 w-auto" src="{{ asset('assets/imgs/takers-pay-logo.png') }}" alt="TakersPay Logo">
                    </a>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    @foreach ($menuItems as $item)
                        <a href="{{ $item['route'] }}"
                            class="{{ $item['active'] ? 'border-primary-1000 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium">
                            {{ $item['name'] }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">
                <a href="{{ route('login') }}"
                    class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">
                    Log in
                </a>
                <a href="{{ route('register') }}"
                    class="inline-flex items-center rounded-md bg-primary-1000 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-1100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-1000">
                    Get started
                </a>
            </div>
            <div class="-mr-2 flex items-center sm:hidden">
                <!-- Mobile menu button -->
                <button @click="open = !open" type="button"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-1000"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Icon when menu is open -->
                    <svg x-show="open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-show="open" class="sm:hidden" id="mobile-menu">
        <div class="space-y-1 pb-3 pt-2">
            @foreach ($menuItems as $item)
                <a href="{{ $item['route'] }}"
                    class="{{ $item['active'] ? 'bg-primary-50 border-primary-1000 text-primary-1000' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} block border-l-4 py-2 pl-3 pr-4 text-base font-medium">
                    {{ $item['name'] }}
                </a>
            @endforeach
        </div>
        <div class="border-t border-gray-200 pb-3 pt-4">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <a href="{{ route('login') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        Log in
                    </a>
                </div>
                <div class="ml-3">
                    <a href="{{ route('register') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-white bg-primary-1000 hover:bg-primary-1100">
                        Get started
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
