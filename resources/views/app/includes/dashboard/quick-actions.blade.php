<div>
    <p class="font-semibold text-xs mb-2">Quick Actions</p>
    <div class="flex-row mb-3 text-white">
        @if (in_array(auth()->user()->role, ['super-admin', 'admin']))
            <a href="{{ url('/tp-admin') }}"><span
                    class="bg-primary-1010 mb-3 shadow text-white-800 text-xs font-medium me-2 px-2.5 py-1 rounded dark:bg-green-900 dark:text-green-300">
                    Admin Panel</span></a>
        @endif
        <a href="{{ route('app.wallets') }}"><span
                class="bg-primary-1010 mb-3 shadow text-white-800 text-xs font-medium me-2 px-2.5 py-1 rounded dark:bg-green-900 dark:text-green-300">Add
                Crypto Wallets</span></a>
        <a href="{{ route('app.profile') }}"><span
                class="bg-primary-1010 mb-3 shadow text-white-800 text-xs font-medium me-2 px-2.5 py-1 rounded dark:bg-green-900 dark:text-green-300">Update
                Profile</span></a>
    </div>
</div>
