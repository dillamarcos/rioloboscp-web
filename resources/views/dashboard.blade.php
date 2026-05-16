<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 transition-colors duration-300">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg
                        border border-gray-100 dark:border-gray-700 transition-colors">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{ __("You're logged in!") }}

                </div>

            </div>

        </div>

    </div>

</x-app-layout>