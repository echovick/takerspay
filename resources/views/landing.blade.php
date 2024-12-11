@extends('layout.app')

@section('content')
    <div>
        {{-- Header --}}
        <header>
            <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800">
                <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <img src="{{ asset('assets/imgs/takers-pay-logo.png') }}" class="h-[100px] sm:h-[100px]"
                            alt="TakersPay Logo" />
                        <span
                            class="hidden lg:inline self-center text-xl font-semibold whitespace-nowrap dark:text-white">TakersPay</span>
                    </a>
                    <div class="flex items-center lg:order-2">
                        <a href="{{ route('login') }}"
                            class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Log
                            in</a>
                        <a href="{{ route('register') }}"
                            class="text-white bg-primary-1000 hover:bg-primary-1100 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">Get
                            started</a>
                        <button data-collapse-toggle="mobile-menu-2" type="button"
                            class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                            aria-controls="mobile-menu-2" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                        <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                            <li>
                                <a href="#"
                                    class="block py-2 pr-4 pl-3 text-white rounded bg-primary-1000 lg:bg-transparent lg:text-primary-1000 lg:p-0 dark:text-white"
                                    aria-current="page">Home</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Features</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <section class="bg-white dark:bg-gray-900 px-4">
            <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
                <div class="mx-auto text-center place-self-center lg:col-span-12 ">
                    <h1
                        class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white">
                        The better way to trade Your Crypto & Giftcards</h1>
                    <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">From
                        Various Crypto Currencies to Giftcards, traders around the world use TakersPay to simplify their
                        trading experience</p>
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-primary-1000 hover:bg-primary-1100 focus:ring-4 focus:ring-primary-1200 dark:focus:ring-primary-1000">
                        Get started
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#"
                        class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        Contact Us
                    </a>
                </div>
            </div>
        </section>
        <div class="bg-primary-1000 text-white text-sm py-2 overflow-hidden whitespace-nowrap">
            <div id="crypto-prices" class="animate-marquee inline-block">
                <!-- Prices will be injected here dynamically -->
            </div>
        </div>
        {{-- Features --}}
        <section class="bg-slate-100 dark:bg-gray-900 px-4">
            <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
                <div class="max-w-screen-md mb-8 lg:mb-16">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Designed for
                        traders like you</h2>
                    <p class="text-gray-500 sm:text-xl dark:text-gray-400">Here at TakersPay we focus on giving a memorable
                        experience</p>
                </div>
                <div class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-12 md:space-y-0">
                    <div>
                        <div
                            class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-primary-1200 lg:h-12 lg:w-12 dark:bg-primary-900">
                            <svg class="w-5 h-5 text-white lg:w-6 lg:h-6 dark:text-primary-1200" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Fast & Secure Transactions</h3>
                        <p class="text-gray-500 dark:text-gray-400">Trade crypto and gift cards with ease and confidence.
                            Our platform ensures lightning-fast transactions, protected by advanced security protocols.</p>
                    </div>
                    <div>
                        <div
                            class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-primary-1200 lg:h-12 lg:w-12 dark:bg-primary-900">
                            <svg class="w-5 h-5 text-white lg:w-6 lg:h-6 dark:text-primary-1200" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">24/7 Customer Support</h3>
                        <p class="text-gray-500 dark:text-gray-400">Have questions or issues? Our dedicated support team is
                            available around the clock to assist you at any step.</p>
                    </div>
                    <div>
                        <div
                            class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-primary-1200 lg:h-12 lg:w-12 dark:bg-primary-900">
                            <svg class="w-5 h-5 text-white lg:w-6 lg:h-6 dark:text-primary-1200" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                    clip-rule="evenodd"></path>
                                <path
                                    d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Seamless User Experience</h3>
                        <p class="text-gray-500 dark:text-gray-400">Navigate effortlessly through our intuitive platform,
                            designed with user convenience in mind, whether you're a beginner or a seasoned trader.</p>
                    </div>
                    <div>
                        <div
                            class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-primary-1200 lg:h-12 lg:w-12 dark:bg-primary-900">
                            <svg class="w-5 h-5 text-white lg:w-6 lg:h-6 dark:text-primary-1200" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z">
                                </path>
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Multi-Currency Support</h3>
                        <p class="text-gray-500 dark:text-gray-400">Trade in your preferred currency with our platform's
                            support for multiple cryptocurrencies and fiat payment options.</p>
                    </div>
                    <div>
                        <div
                            class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-primary-1200 lg:h-12 lg:w-12 dark:bg-primary-900">
                            <svg class="w-5 h-5 text-white lg:w-6 lg:h-6 dark:text-primary-1200" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">High-Level Encryption</h3>
                        <p class="text-gray-500 dark:text-gray-400">We prioritize your privacy and security by leveraging
                            industry-leading encryption technology for all transactions and data exchanges.</p>
                    </div>
                    <div>
                        <div
                            class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-primary-1200 lg:h-12 lg:w-12 dark:bg-primary-900">
                            <svg class="w-5 h-5 text-white lg:w-6 lg:h-6 dark:text-primary-1200" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">Mobile-Friendly</h3>
                        <p class="text-gray-500 dark:text-gray-400">Trade on the go with our fully optimized platform,
                            accessible on both mobile and desktop devices.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- CTA --}}
        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
                <div class="mx-auto max-w-screen-sm text-center">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold leading-tight text-gray-900 dark:text-white">
                        Start trading with us today</h2>
                    <p class="mb-6 font-light text-gray-500 dark:text-gray-400 md:text-lg">Trade your crypto & gift cards
                        with us</p>
                    <a href="{{ route('register') }}"
                        class="text-white bg-primary-1000 hover:bg-primary-1100 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">Get
                        Started</a>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="p-4 bg-slate-100 md:p-8 lg:p-10 dark:bg-gray-800">
            <div class="mx-auto max-w-screen-xl text-center">
                <a href="#"
                    class="flex justify-center items-center text-2xl font-semibold text-gray-900 dark:text-white">
                    <img src="{{ asset('assets/imgs/takers-pay-logo.png') }}" class="h-[100px] sm:h-[100px]"
                        alt="TakersPay Logo" />
                    TakersPay
                </a>
                <p class="my-6 text-gray-500 dark:text-gray-400">Enjoy Seamless trading experience with TakersPay</p>
                <ul class="flex flex-wrap justify-center items-center mb-6 text-gray-900 dark:text-white">
                    <li>
                        <a href="#" class="mr-4 hover:underline md:mr-6 ">About</a>
                    </li>
                    <li>
                        <a href="#" class="mr-4 hover:underline md:mr-6">FAQs</a>
                    </li>
                    <li>
                        <a href="#" class="mr-4 hover:underline md:mr-6">Contact</a>
                    </li>
                </ul>
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024 <a href="#"
                        class="hover:underline">TakersPay</a>. All Rights Reserved.</span>
            </div>
        </footer>
    </div>
@endsection
