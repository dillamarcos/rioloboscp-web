<section>

    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">

        @csrf
        @method('put')

        <!-- CURRENT PASSWORD -->
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />

            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full
                    bg-white dark:bg-gray-700
                    text-gray-900 dark:text-gray-100
                    border-gray-300 dark:border-gray-600
                    focus:border-indigo-500 dark:focus:border-indigo-400
                    focus:ring-indigo-500 dark:focus:ring-indigo-400" />
        </div>

        <!-- NEW PASSWORD -->
        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />

            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full
                    bg-white dark:bg-gray-700
                    text-gray-900 dark:text-gray-100
                    border-gray-300 dark:border-gray-600
                    focus:border-indigo-500 dark:focus:border-indigo-400
                    focus:ring-indigo-500 dark:focus:ring-indigo-400" />
        </div>

        <!-- CONFIRM PASSWORD -->
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full
                    bg-white dark:bg-gray-700
                    text-gray-900 dark:text-gray-100
                    border-gray-300 dark:border-gray-600
                    focus:border-indigo-500 dark:focus:border-indigo-400
                    focus:ring-indigo-500 dark:focus:ring-indigo-400" />
        </div>

        <!-- ACTIONS -->
        <div class="flex items-center gap-4">

            <x-primary-button>
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Saved.') }}
                </p>
            @endif

        </div>

    </form>

</section>