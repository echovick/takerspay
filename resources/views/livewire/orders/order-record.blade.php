<div>
    <div class="flex flex-row justify-between bg-grey">
        <div class="flex flex-row">
            <a href="{{ route('app.home') }}">
                @if (Auth::user()->role == 'user')
                    <x-icons.left-arrow />
                @endif
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
                                @if (isset($item['text']))
                                    <p class="text-xs font-normal text-gray-900 dark:text-white">
                                        {{ $item['text'] ?? '' }}
                                    </p>
                                @endif
                                @if (isset($item['image_url']))
                                    <img src="{{ $item['image_url'] }}" alt="Image">
                                @endif
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
                                @if (isset($item['text']))
                                    <p class="text-xs font-normal text-gray-900 dark:text-white">
                                        {{ $item['text'] ?? '' }}
                                    </p>
                                @endif
                                @if (isset($item['image_url']))
                                    <img src="{{ $item['image_url'] }}" alt="Image">
                                @endif
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
            @if (isset($order->file_url) && !empty($order->file_url))
                @php
                    $files = explode(',', $order->file_url);
                @endphp
                @foreach ($files as $file)
                    @if ($order->type == 'sell')
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
                                    <img src="{{ url($file) }}" alt="Image">
                                </div>
                                <span
                                    class="text-xs font-normal text-gray-500 dark:text-gray-400 text-right mb-3"></span>
                            </div>
                            <!-- Avatar -->
                            <div>
                                <div class="relative w-8 h-8 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                                    <svg class="absolute w-10 h-10 text-gray-400 -left-1" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-start gap-2.5 mt-3">
                            <img class="w-8 h-8 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"
                                src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                alt="Bordered avatar">
                            <div class="flex flex-col gap-1 w-full max-w-[320px] ml-1">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">TP Admin</span>
                                    <span
                                        class="text-xs font-normal text-gray-500 dark:text-gray-400">{{ isset($item['timestamp']) ? $item['timestamp'] : '' }}</span>
                                </div>
                                <div
                                    class="flex flex-col leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                                    <img src="{{ asset($file) }}" alt="Image">
                                </div>
                                <span class="text-xs font-normal text-gray-500 dark:text-gray-400 mb-3"></span>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        @endif
    </div>

    @include('app.includes.chat-input')
</div>
