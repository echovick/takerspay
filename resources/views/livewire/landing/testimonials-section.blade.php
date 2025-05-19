<section class="bg-white py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-xl text-center">
            <h2 class="text-lg font-semibold leading-8 tracking-tight text-primary-1000">Testimonials</h2>
            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">What our users are saying</p>
        </div>
        <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mx-0 lg:max-w-none">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($testimonials as $testimonial)
                    <figure class="rounded-2xl bg-gray-50 p-8 text-sm leading-6 h-full">
                        <blockquote class="text-gray-900">
                            <p>"{{ $testimonial['content'] }}"</p>
                        </blockquote>
                        <figcaption class="mt-6 flex items-center gap-x-4">
                            <div
                                class="h-10 w-10 rounded-full bg-gray-400 flex items-center justify-center text-white font-semibold">
                                {{ substr($testimonial['author'], 0, 1) }}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">{{ $testimonial['author'] }}</div>
                                <div class="text-gray-600">{{ $testimonial['role'] }}</div>
                            </div>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </div>
</section>
