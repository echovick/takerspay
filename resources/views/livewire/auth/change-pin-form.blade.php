<div
    class="w-full max-w p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 dark:bg-gray-800 dark:border-gray-700">
    <h5 class="mb-3 text-base font-semibold text-gray-900 md:text-xl dark:text-white">
        Change your Pin
    </h5>
    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Connect with one of our available wallet
        providers or create a new one.</p>

    <form class="max-w mx-auto">
        <div class="flex mb-2 space-x-2 rtl:space-x-reverse mt-3">
            <div>
                <label for="code-1" class="sr-only">First code</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-next="code-2" id="code-1"
                    class="w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required />
            </div>
            <div>
                <label for="code-2" class="sr-only">Second code</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-1"
                    data-focus-input-next="code-3" id="code-2"
                    class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required />
            </div>
            <div>
                <label for="code-3" class="sr-only">Third code</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-2"
                    data-focus-input-next="code-4" id="code-3"
                    class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required />
            </div>
            <div>
                <label for="code-4" class="sr-only">Fourth code</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-3"
                    data-focus-input-next="code-5" id="code-4"
                    class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required />
            </div>
            <div>
                <label for="code-5" class="sr-only">Fifth code</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-4"
                    data-focus-input-next="code-6" id="code-5"
                    class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required />
            </div>
            <div>
                <label for="code-6" class="sr-only">Sixth code</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-5" id="code-6"
                    class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required />
            </div>
        </div>
        <button type="submit"
            class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 mt-3">Submit</button>
    </form>

    <div>
        <a href="#"
            class="inline-flex items-center text-xs font-normal text-gray-500 hover:underline dark:text-gray-400 mt-3">
            <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7.529 7.988a2.502 2.502 0 0 1 5 .191A2.441 2.441 0 0 1 10 10.582V12m-.01 3.008H10M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            Why do I need to connect with my wallet?</a>
    </div>
</div>

@script
    <script>
        // use this simple function to automatically focus on the next input
        function focusNextInput(el, prevId, nextId) {
            if (el.value.length === 0) {
                if (prevId) {
                    document.getElementById(prevId).focus();
                }
            } else {
                if (nextId) {
                    document.getElementById(nextId).focus();
                }
            }
        }

        document.querySelectorAll('[data-focus-input-init]').forEach(function(element) {
            element.addEventListener('keyup', function(event) {
                const prevId = this.getAttribute('data-focus-input-prev');
                const nextId = this.getAttribute('data-focus-input-next');

                // Check if the current input is filled or empty
                if (this.value.length === 1 && nextId && event.key !== 'Backspace') {
                    document.getElementById(nextId).focus();
                } else if (event.key === 'Backspace' && prevId) {
                    document.getElementById(prevId).focus();
                }
            });

            element.addEventListener('paste', function(event) {
                event.preventDefault();
                const pasteData = (event.clipboardData || window.clipboardData).getData('text');
                const digits = pasteData.replace(/\D/g, ''); // Keep only numbers

                const inputs = document.querySelectorAll('[data-focus-input-init]');
                inputs.forEach((input, index) => {
                    if (digits[index]) {
                        input.value = digits[index];
                        const nextId = input.getAttribute('data-focus-input-next');
                        if (nextId) {
                            document.getElementById(nextId).focus();
                        }
                    }
                });
            });
        });
    </script>
@endscript
