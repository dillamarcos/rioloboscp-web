<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans antialiased bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300">

    <div class="min-h-screen">

        <!-- NAVIGATION -->
        <div class="shadow-sm dark:shadow-black/30 bg-white dark:bg-gray-800 transition-colors">
            @include('layouts.navigation')
        </div>

        <!-- PAGE HEADING -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow dark:shadow-black/20 transition-colors">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="text-gray-900 dark:text-gray-100">
                        {{ $header }}
                    </div>
                </div>
            </header>
        @endisset

        <!-- PAGE CONTENT -->
        <main class="transition-colors">
            {{ $slot }}
        </main>

    </div>

</body>

</html>