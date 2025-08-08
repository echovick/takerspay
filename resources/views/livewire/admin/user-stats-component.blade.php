<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Total Users Card -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-lg relative overflow-hidden">
        <div class="absolute h-full w-1 bg-blue-600 left-0 top-0"></div>
        <div class="p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Users</p>
                    <p class="text-xl font-bold text-gray-800">{{ number_format($totalUsers) }}</p>
                    <div class="flex items-center mt-1 text-xs">
                        <span class="text-green-500 flex items-center mr-2">
                            <span class="inline-flex h-2 w-2 rounded-full bg-green-500 mr-1"></span>
                            {{ number_format($activeUsers) }} active
                        </span>
                        <span class="text-blue-500">+{{ number_format($newUsersToday) }} today</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Registrations Card -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-lg relative overflow-hidden">
        <div class="absolute h-full w-1 bg-green-600 left-0 top-0"></div>
        <div class="p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">New This Month</p>
                    <p class="text-xl font-bold text-gray-800">{{ number_format($newUsersThisMonth) }}</p>
                    <div class="flex items-center mt-1 text-xs">
                        @if($growthPercentage > 0)
                            <span class="text-green-500">+{{ $growthPercentage }}% from last month</span>
                        @elseif($growthPercentage < 0)
                            <span class="text-red-500">{{ $growthPercentage }}% from last month</span>
                        @else
                            <span class="text-gray-500">No change from last month</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KYC Verification Card -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-lg relative overflow-hidden">
        <div class="absolute h-full w-1 bg-purple-600 left-0 top-0"></div>
        <div class="p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">KYC Verified</p>
                    <p class="text-xl font-bold text-gray-800">{{ number_format($kycVerified) }}</p>
                    <div class="flex items-center mt-1 text-xs space-x-2">
                        @if($kycPending > 0)
                            <span class="text-yellow-500">{{ number_format($kycPending) }} pending</span>
                        @endif
                        @if($kycRejected > 0)
                            <span class="text-red-500">{{ number_format($kycRejected) }} rejected</span>
                        @endif
                        @if($kycPending == 0 && $kycRejected == 0)
                            <span class="text-green-500">All processed</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Activity Card -->
    <div class="bg-white border border-gray-100 shadow-sm rounded-lg relative overflow-hidden">
        <div class="absolute h-full w-1 bg-amber-600 left-0 top-0"></div>
        <div class="p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-amber-100 text-amber-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Active Today</p>
                    <p class="text-xl font-bold text-gray-800">{{ number_format($activeToday) }}</p>
                    <div class="flex items-center mt-1 text-xs">
                        <span class="text-blue-500">Average session: {{ $averageSessionTime }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>