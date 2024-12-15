<div>
    <div class="flex flex-row justify-between bg-grey">
        <div class="flex flex-row">
            <a href="{{ route('app.home') }}">
                <svg class="w-7 h-7 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 12h14M5 12l4-4m-4 4 4 4" />
                </svg>
            </a>
            <img class="w-7 h-7 ml-2 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                alt="Rounded avatar">
            <p class="text-xs font-semibold px-3">@ {{ auth()->user()->metaData->tag }}
                <br>
                <span class="font-normal text-xs">ORDER: {{ strtoupper($order?->reference) }}</span>
            </p>
        </div>
        <div>
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v5a1 1 0 1 0 2 0V8Zm-1 7a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z"
                    clip-rule="evenodd" />
            </svg>
        </div>
    </div>
    <hr class="my-4">
    <livewire:rates-card />
    <p class="text-center text-[10px] mb-5 w-100 text-slate-400 mx-auto">To ensure your order is fufilled, please
        provide
        accurate responses, if you have any issues click the icon above to report. Say Hello to start the chat</p>

    <div class="bg-grey pb-10">
        @if (is_array($messages) && count($messages) > 0)
            @foreach ($messages as $item)
                @if ($item['sender'] == 'Bot')
                    <div class="flex items-start gap-2.5 mt-3">
                        <img class="w-8 h-8 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"
                            src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="Bordered avatar">
                        <div class="flex flex-col gap-1 w-full max-w-[320px] ml-1">
                            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">TP Admin</span>
                                <span
                                    class="text-xs font-normal text-gray-500 dark:text-gray-400">{{ isset($item['timestamp']) ? $item['timestamp'] : '' }}</span>
                            </div>
                            <div
                                class="flex flex-col leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                                <p class="text-xs font-normal text-gray-900 dark:text-white">{{ $item['text'] }}</p>
                            </div>
                            <span class="text-xs font-normal text-gray-500 dark:text-gray-400 mb-3"></span>
                        </div>
                    </div>
                @else
                    <div class="flex items-start gap-2.5 justify-end mt-3">
                        <!-- Message Text -->
                        <div class="flex flex-col gap-1 w-full max-w-[320px] mr-1">
                            <div class="flex items-center justify-end space-x-2 space-x-reverse">
                                <span
                                    class="text-xs font-normal text-gray-500 dark:text-gray-400 px-2">{{ isset($item['timestamp']) ? $item['timestamp'] : '' }}</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">You</span>
                            </div>
                            <div
                                class="flex flex-col leading-1.5 p-4 border-gray-200 bg-primary-1050 rounded-s-xl rounded-es-xl dark:bg-blue-700">
                                <p class="text-xs font-normal text-gray-900 dark:text-white">
                                    {{ $item['text'] }}
                                </p>
                            </div>
                            <span class="text-xs font-normal text-gray-500 dark:text-gray-400 text-right mb-3"></span>
                        </div>
                        <!-- Avatar -->
                        <div>
                            <div class="relative w-8 h-8 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                                <svg class="absolute w-10 h-10 text-gray-400 -left-1" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>

    <div
        class="fixed z-50 w-full h-16 max-w-lg -translate-x-1/2 rounded-full bottom-4 left-1/2 dark:bg-gray-700 dark:border-gray-600">
        @if (!$order->transaction_status || $order->transaction_status == 'pending')
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
                    <input id="chat" rows="1" wire:model.live="input"
                        class="flex-grow mx-2 p-2 text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Your message...">

                    <!-- Send Button -->
                    <button type="submit"
                        class="p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                        <svg class="w-5 h-5 rotate-90 rtl:-rotate-90" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                            <path
                                d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z" />
                        </svg>
                        <span class="sr-only">Send message</span>
                    </button>
                </div>
            </form>
        @else
            <x-alerts.info-alert> This Order Has Been {{ $order->transaction_status }}, you can no longer make changes to it</x-alert.info-alert>
        @endif
    </div>
</div>
