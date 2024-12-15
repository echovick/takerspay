<div
    class="w-full max-w p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 dark:bg-gray-800 dark:border-gray-700">
    <h5 class="mb-3 text-base font-semibold text-gray-900 md:text-xl dark:text-white">
        Change your password
    </h5>
    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">It is advisable to set a new password for your account, atleast 1 every 3 months</p>
    <form class="space-y-4 md:space-y-6 mt-3" wire:submit.prevent="changePassword">
        <div class="alert-section">
            @if (isset($successMsg) && !empty($successMsg))
                <x-alerts.info-alert> {{ $successMsg }} </x-alerts.info-alert>
                @php $successMsg = '';@endphp
            @endif
            @if (isset($errorMsg) && !empty($errorMsg))
                <x-alerts.danger-alert> {{ $errorMsg }} </x-alerts.info-alert>
                @php $errorMsg = '';@endphp
            @endif
        </div>
        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current
                Password</label>
            <input type="password" name="password" id="password" placeholder="••••••••" wire:model="currentPassword"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required="">
        </div>
        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New
                Password</label>
            <input type="password" name="password" id="password" placeholder="••••••••" wire:model="password"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required="">
                @error('password') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>
        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm New
                Password</label>
            <input type="password" name="password" id="password" placeholder="••••••••"
                wire:model="password_confirmation"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required="">
                @error('password_confirmation') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>
        <button type="submit"
            class="w-full text-white bg-primary-1000 hover:bg-primary-1100 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            Submit
            <svg wire:loading wire:loading.target="changePassword" aria-hidden="true" role="status"
                class="ml-2 inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                    fill="#E5E7EB" />
                <path
                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                    fill="currentColor" />
            </svg>
        </button>
    </form>
    <div>
        <a href="#"
            class="inline-flex items-center text-xs font-normal text-gray-500 hover:underline dark:text-gray-400 mt-3">
            <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7.529 7.988a2.502 2.502 0 0 1 5 .191A2.441 2.441 0 0 1 10 10.582V12m-.01 3.008H10M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            Having difficulties changing your password?</a>
    </div>
</div>
