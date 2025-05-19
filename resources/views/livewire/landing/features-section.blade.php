<section class="bg-gradient-to-b from-white to-gray-50 py-16 sm:py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Designed for traders like you</h2>
            <p class="mt-6 text-lg leading-8 text-gray-600">Here at TakersPay we focus on giving you a memorable
                experience with advanced features and security.</p>
        </div>
        <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
            <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                @foreach ($features as $feature)
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-lg font-semibold leading-7 text-gray-900">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary-1000 text-white">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="{{ $feature['icon'] }}" />
                                </svg>
                            </div>
                            {{ $feature['title'] }}
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                            <p class="flex-auto">{{ $feature['description'] }}</p>
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
</section>
