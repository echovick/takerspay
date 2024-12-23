<div class="{{ auth()->user()->role == 'user' ? 'fixed z-50 w-full h-16 max-w-lg -translate-x-1/2' : '' }} rounded-full bottom-4 left-1/2 dark:bg-gray-700 dark:border-gray-600">
    <form wire:submit="handleInput">
        <label for="chat" class="sr-only">Your message</label>
        <div class="flex items-center px-2 py-2 rounded-lg bg-gray-50 dark:bg-gray-700">
            <input wire:model.live="photos"
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                id="imageUploadInput" accept="image/*" style="display: none;" type="file" multiple>

            <!-- Button -->
            <button type="button"
                class="p-2 text-gray-500 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600"
                onclick="triggerImageUpload()">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 18">
                    <path fill="currentColor"
                        d="M13 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0ZM7.565 7.423 4.5 14h11.518l-2.516-3.71L11 13 7.565 7.423Z" />
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 1H2a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1Z" />
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0ZM7.565 7.423 4.5 14h11.518l-2.516-3.71L11 13 7.565 7.423Z" />
                </svg>
                <span class="sr-only">Upload image</span>
            </button>
            @if (isset($photos) && !empty($photos))
                <div class="mb-4 w-100">
                    <x-alerts.info-alert> {{ count($photos) }} Images Selected, Click Submit to send </x-alerts.info-alert>
                </div>
            @else
                <input id="chat" rows="1" wire:model.live="input"
                    class="flex-grow mx-2 p-2 text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Your message...">
            @endif

            <!-- Send Button -->
            <button type="submit"
                class="p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                <svg class="w-5 h-5 rotate-90 rtl:-rotate-90" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 18 20">
                    <path
                        d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z" />
                </svg>
                <span class="sr-only">Send message</span>
            </button>
        </div>
    </form>
</div>

{{-- <div class="fixed z-50 w-full h-16 max-w-lg -translate-x-1/2 rounded-full bottom-4 left-1/2 dark:bg-gray-700 dark:border-gray-600">
    @if (!$order->transaction_status || $order->transaction_status == 'pending' || $order->order_step == 'upload_gift_card')
        <form wire:submit="handleInput">
            <label for="chat" class="sr-only">Your message</label>
            <div class="flex items-center px-2 py-2 rounded-lg bg-gray-50 dark:bg-gray-700">
                <!-- Left Icon -->
                <button type="button"
                    class="p-2 text-gray-500 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 18">
                        <path fill="currentColor"
                            d="M13 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0ZM7.565 7.423 4.5 14h11.518l-2.516-3.71L11 13 7.565 7.423Z" />
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 1H2a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1Z" />
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0ZM7.565 7.423 4.5 14h11.518l-2.516-3.71L11 13 7.565 7.423Z" />
                    </svg>
                    <span class="sr-only">Upload image</span>
                </button>

                <!-- Chat Input -->
                @if (($order->order_step == 'upload_gift_card' && $order->type == 'sell' && $order->asset == 'giftcard' && !$order->file_url) || $order->order_step == 'confirm_purchase')
                    <input wire:model="photos"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        id="multiple_files" type="file" multiple>
                @else
                    <input id="chat" rows="1" wire:model.live="input"
                        class="flex-grow mx-2 p-2 text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Your message...">
                @endif

                <!-- Send Button -->
                <button type="submit"
                    class="p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                    <svg class="w-5 h-5 rotate-90 rtl:-rotate-90" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 18 20">
                        <path
                            d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z" />
                    </svg>
                    <span class="sr-only">Send message</span>
                </button>
            </div>
        </form>
    @else
        @if (Auth::user()->role == 'user')
            <x-alerts.info-alert> This Order Has Been {{ $order->transaction_status }}, you can no longer make
                changes
                to it</x-alert.info-alert>
        @endif
    @endif
</div> --}}
