<nav x-data="{ open: false }"
    class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 transition-colors">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT -->
            <div class="flex">

                <!-- LOGO -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/escudo.png') }}"
                            class="h-12 md:h-14 lg:h-16 w-auto object-contain hover:scale-105 transition">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

            </div>

            <!-- RIGHT: USER -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md
                                   text-gray-600 dark:text-gray-200
                                   bg-white dark:bg-gray-800
                                   hover:text-gray-800 dark:hover:text-white
                                   transition">

                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content" class="bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>

                    </x-slot>
                </x-dropdown>
            </div>

            <!-- HAMBURGER -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-gray-500 dark:text-gray-300
                               hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    ☰
                </button>
            </div>

        </div>
    </div>

    <!-- MOBILE -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden
                bg-white dark:bg-gray-900 border-t dark:border-gray-800">

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-800">

            <div class="px-4">
                <div class="text-gray-800 dark:text-gray-100 font-medium">
                    {{ Auth::user()->name }}
                </div>

                <div class="text-gray-500 dark:text-gray-400 text-sm">
                    {{ Auth::user()->email }}
                </div>
            </div>

        </div>
    </div>

</nav>