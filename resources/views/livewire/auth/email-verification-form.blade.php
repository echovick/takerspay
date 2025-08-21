<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full"
                style="background-color: #B0149A;">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Verify your email
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                We sent a verification code to
                <span class="font-medium" style="color: #B0149A;">{{ $email }}</span>
            </p>
        </div>

        <form wire:submit.prevent="verifyEmail" class="mt-8 space-y-6">

            @if (session()->has('message'))
                <div class="rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('message') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">
                                {{ session('error') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div>
                <label for="otp" class="block text-sm font-medium text-gray-700">
                    Enter verification code
                </label>
                <div class="mt-1">
                    <input wire:model="otp" id="otp" name="otp" type="text" maxlength="6"
                        placeholder="000000"
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-primary-1000 focus:border-primary-1000 focus:z-10 sm:text-sm text-center text-2xl font-mono tracking-widest"
                        required>
                </div>
                @error('otp')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 disabled:opacity-50"
                    style="background-color: #B0149A;" onmouseover="this.style.backgroundColor='#BA0E77'"
                    onmouseout="this.style.backgroundColor='#B0149A'">

                    <!-- Loading spinner (shown during verification) -->
                    <span wire:loading wire:target="verifyEmail"
                        class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </span>

                    <!-- Lock icon (shown when not loading) -->
                    <span wire:loading.remove wire:target="verifyEmail"
                        class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-white/70 group-hover:text-white/90" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>

                    <!-- Button text -->
                    <span wire:loading wire:target="verifyEmail">Verifying...</span>
                    <span wire:loading.remove wire:target="verifyEmail">Verify Email</span>
                </button>
            </div>

            <div class="text-center">
                <button type="button" wire:click="sendOtp" @if ($cooldown > 0) disabled @endif
                    class="text-sm disabled:text-gray-400 disabled:cursor-not-allowed inline-flex items-center"
                    style="color: #B0149A;" onmouseover="this.style.color='#CE3F7E'"
                    onmouseout="this.style.color='#B0149A'">
                    <span wire:loading wire:target="sendOtp" class="mr-2">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </span>
                    @if ($cooldown > 0)
                        Resend code in {{ $cooldown }}s
                    @else
                        Resend verification code
                    @endif
                </button>
            </div>

            <div class="text-center">
                <button type="button" wire:click="logout" class="text-sm text-gray-600 hover:text-gray-500">
                    Sign out
                </button>
            </div>
        </form>
    </div>

    @if ($cooldown > 0)
        <script>
            setTimeout(() => {
                @this.call('updateCooldown');
            }, 1000);
        </script>
    @endif

</div>
