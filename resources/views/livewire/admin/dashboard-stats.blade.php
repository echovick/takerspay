<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Stat Card 1 -->
    <a href="#"
        class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
        <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white">Total Users</h5>
        <p class="font-normal text-md text-gray-700 dark:text-gray-400">{{ $totalUsers }}</p>
    </a>
    <!-- Stat Card 2 -->
    <a href="#"
        class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
        <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white">Pending Orders</h5>
        <p class="font-normal text-md text-gray-700 dark:text-gray-400">{{ $pendingOrders }}</p>
    </a>
    <!-- Stat Card 3 -->
    <a href="#"
        class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
        <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white">Completed Orders</h5>
        <p class="font-normal text-md text-gray-700 dark:text-gray-400">{{ $completedOrders }}</p>
    </a>
    <!-- Stat Card 4 -->
    <a href="#"
        class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
        <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white">Total Revenue</h5>
        <p class="font-normal text-md text-gray-700 dark:text-gray-400">₦{{ number_format($totalRevenue, 2) }}</p>
    </a>
</div>
