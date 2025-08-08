<!-- App Context Switcher Component -->
<div class="bg-white rounded-xl shadow-lg mb-6 overflow-hidden animate__animated animate__fadeIn">
    <div class="bg-gradient-to-r from-indigo-500 via-purple-600 to-violet-600 px-6 py-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-white font-bold text-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                    </svg>
                    Application Context
                </h3>
                <p class="text-white/80 text-sm mt-0.5">Switch between different app views</p>
            </div>
            <div class="hidden md:flex items-center space-x-2">
                <span class="text-white/60 text-xs">Active:</span>
                <span class="px-2 py-1 bg-white/20 backdrop-blur-sm rounded-lg text-white text-xs font-medium">
                    {{ request()->get('context') == 'crypto' ? 'Crypto & Gift Cards' : (request()->get('context') == 'finance' ? 'Financial App' : 'Unified View') }}
                </span>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <!-- Unified View Tab -->
            <a href="{{ route('admin.dashboard', ['context' => 'all']) }}"
                class="group relative overflow-hidden rounded-xl transition-all duration-300 {{ request()->get('context') == 'all' || !request()->has('context') ? 'bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg shadow-indigo-500/30' : 'bg-gray-50 hover:bg-gray-100 border border-gray-200' }}">
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 rounded-xl {{ request()->get('context') == 'all' || !request()->has('context') ? 'bg-white/20' : 'bg-gradient-to-br from-indigo-100 to-purple-100' }} flex items-center justify-center">
                            <svg class="w-6 h-6 {{ request()->get('context') == 'all' || !request()->has('context') ? 'text-white' : 'text-indigo-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6c.828 0 1.5-.448 1.5-1 0-.276-.112-.526-.293-.707a6.011 6.011 0 012.586 0c-.181.181-.293.431-.293.707 0 .552.672 1 1.5 1 .526 0 .988-.27 1.256-.679a6.012 6.012 0 011.912 2.706c-.209.082-.436.127-.668.127-1.105 0-2-.672-2-1.5 0-.276.112-.526.293-.707a6.012 6.012 0 010 2.586c-.181-.181-.431-.293-.707-.293-.828 0-1.5.895-1.5 2s.672 1.5 1.5 1.5c.232 0 .459-.045.668-.127a6.012 6.012 0 01-1.912 2.706c-.268-.409-.73-.679-1.256-.679-.828 0-1.5.448-1.5 1 0 .276.112.526.293.707a6.012 6.012 0 01-2.586 0c.181-.181.293-.431.293-.707 0-.552-.672-1-1.5-1-.526 0-.988.27-1.256.679a6.012 6.012 0 01-1.912-2.706c.209-.082.436-.127.668-.127 1.105 0 2 .672 2 1.5 0 .276-.112.526-.293.707a6.011 6.011 0 010-2.586c.181.181.431.293.707.293.828 0 1.5-.895 1.5-2s-.672-1.5-1.5-1.5c-.232 0-.459.045-.668.127z"></path>
                            </svg>
                        </div>
                        @if(request()->get('context') == 'all' || !request()->has('context'))
                            <span class="px-2 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs font-medium">Active</span>
                        @endif
                    </div>
                    <h4 class="{{ request()->get('context') == 'all' || !request()->has('context') ? 'text-white' : 'text-gray-900' }} font-semibold text-sm mb-1">Unified View</h4>
                    <p class="{{ request()->get('context') == 'all' || !request()->has('context') ? 'text-white/80' : 'text-gray-600' }} text-xs">Combined metrics from all applications</p>
                    
                    <!-- Stats Preview -->
                    <div class="mt-3 pt-3 border-t {{ request()->get('context') == 'all' || !request()->has('context') ? 'border-white/20' : 'border-gray-200' }}">
                        <div class="flex items-center justify-between">
                            <span class="{{ request()->get('context') == 'all' || !request()->has('context') ? 'text-white/60' : 'text-gray-500' }} text-xs">Total Apps</span>
                            <span class="{{ request()->get('context') == 'all' || !request()->has('context') ? 'text-white' : 'text-gray-900' }} text-xs font-bold">2</span>
                        </div>
                    </div>
                </div>
                
                <!-- Animated Background Effect -->
                @if(request()->get('context') == 'all' || !request()->has('context'))
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                @endif
            </a>

            <!-- Crypto & Gift Card Tab -->
            <a href="{{ route('admin.dashboard', ['context' => 'crypto']) }}"
                class="group relative overflow-hidden rounded-xl transition-all duration-300 {{ request()->get('context') == 'crypto' ? 'bg-gradient-to-br from-amber-500 to-orange-600 shadow-lg shadow-amber-500/30' : 'bg-gray-50 hover:bg-gray-100 border border-gray-200' }}">
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 rounded-xl {{ request()->get('context') == 'crypto' ? 'bg-white/20' : 'bg-gradient-to-br from-amber-100 to-orange-100' }} flex items-center justify-center">
                            <svg class="w-6 h-6 {{ request()->get('context') == 'crypto' ? 'text-white' : 'text-amber-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        @if(request()->get('context') == 'crypto')
                            <span class="px-2 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs font-medium">Active</span>
                        @endif
                    </div>
                    <h4 class="{{ request()->get('context') == 'crypto' ? 'text-white' : 'text-gray-900' }} font-semibold text-sm mb-1">Crypto & Gift Cards</h4>
                    <p class="{{ request()->get('context') == 'crypto' ? 'text-white/80' : 'text-gray-600' }} text-xs">Digital assets and gift card trading</p>
                    
                    <!-- Stats Preview -->
                    <div class="mt-3 pt-3 border-t {{ request()->get('context') == 'crypto' ? 'border-white/20' : 'border-gray-200' }}">
                        <div class="flex items-center justify-between">
                            <span class="{{ request()->get('context') == 'crypto' ? 'text-white/60' : 'text-gray-500' }} text-xs">Active Trades</span>
                            <span class="{{ request()->get('context') == 'crypto' ? 'text-white' : 'text-gray-900' }} text-xs font-bold">24</span>
                        </div>
                    </div>
                </div>
                
                <!-- Animated Background Effect -->
                @if(request()->get('context') == 'crypto')
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                @endif
            </a>

            <!-- Financial App Tab -->
            <a href="{{ route('admin.dashboard', ['context' => 'finance']) }}"
                class="group relative overflow-hidden rounded-xl transition-all duration-300 {{ request()->get('context') == 'finance' ? 'bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg shadow-emerald-500/30' : 'bg-gray-50 hover:bg-gray-100 border border-gray-200' }}">
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 rounded-xl {{ request()->get('context') == 'finance' ? 'bg-white/20' : 'bg-gradient-to-br from-emerald-100 to-teal-100' }} flex items-center justify-center">
                            <svg class="w-6 h-6 {{ request()->get('context') == 'finance' ? 'text-white' : 'text-emerald-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        @if(request()->get('context') == 'finance')
                            <span class="px-2 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs font-medium">Active</span>
                        @endif
                    </div>
                    <h4 class="{{ request()->get('context') == 'finance' ? 'text-white' : 'text-gray-900' }} font-semibold text-sm mb-1">Financial Services</h4>
                    <p class="{{ request()->get('context') == 'finance' ? 'text-white/80' : 'text-gray-600' }} text-xs">Banking and payment solutions</p>
                    
                    <!-- Stats Preview -->
                    <div class="mt-3 pt-3 border-t {{ request()->get('context') == 'finance' ? 'border-white/20' : 'border-gray-200' }}">
                        <div class="flex items-center justify-between">
                            <span class="{{ request()->get('context') == 'finance' ? 'text-white/60' : 'text-gray-500' }} text-xs">Transactions</span>
                            <span class="{{ request()->get('context') == 'finance' ? 'text-white' : 'text-gray-900' }} text-xs font-bold">156</span>
                        </div>
                    </div>
                </div>
                
                <!-- Animated Background Effect -->
                @if(request()->get('context') == 'finance')
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                @endif
            </a>
        </div>

        <!-- Quick Insights -->
        <div class="mt-4 p-3 bg-gray-50 rounded-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-indigo-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-xs text-gray-600">
                        @if(request()->get('context') == 'crypto')
                            Viewing crypto and gift card transactions only
                        @elseif(request()->get('context') == 'finance')
                            Viewing financial app data only
                        @else
                            Viewing all applications combined
                        @endif
                    </span>
                </div>
                <button class="text-xs text-indigo-600 hover:text-indigo-700 font-medium transition-colors duration-200">
                    Learn More →
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add hover effect styles -->
<style>
    .group:hover .group-hover\:opacity-100 {
        opacity: 1;
    }
</style>