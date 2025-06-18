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
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Order Details</h1>
                            <p class="mt-1 text-gray-600">Order Reference: <span
                                    class="font-medium">{{ $_GET['ref'] }}</span></p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-4 md:mt-0 flex flex-col md:flex-row gap-2">
                            <button
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Approve Order
                            </button>

                            <button
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Export
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Breadcrumb -->
            <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-white shadow-md mb-6 animate__animated animate__fadeIn animate__delay-1s"
                aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('admin.order-management') }}"
                                class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2">
                                Orders
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 mx-1 text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">{{ $_GET['ref'] }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Order Detail Content -->
            <div class="flex flex-wrap animate__animated animate__fadeIn animate__delay-2s">
                <!-- Order Details Section -->
                <div class="w-full md:w-3/5 p-2 md:pr-4">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200 px-6 py-4">
                            <h2 class="text-lg font-medium text-gray-900">Order Information</h2>
                        </div>
                        <div class="p-4">
                            <livewire:admin.order-detail />
                        </div>
                    </div>
                </div>

                <!-- Order Chat Section -->
                <div class="w-full md:w-2/5 p-2 md:pl-2">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden h-full">
                        <div class="bg-gradient-to-r from-gray-50 to-indigo-50 border-b border-gray-200 px-6 py-4">
                            <h2 class="text-lg font-medium text-gray-900">Order Communication</h2>
                        </div>
                        <div class="h-[505px] overflow-y-auto p-4">
                            <livewire:orders.order-record />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
