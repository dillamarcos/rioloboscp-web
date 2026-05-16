<!DOCTYPE html>
<html lang="es" x-data="{ darkMode: localStorage.getItem('dark') === 'true' }">

<script>
    (function() {
        const dark = localStorage.getItem('dark') === 'true';

        if (dark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    })();
</script>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Riolobos CP | Web Oficial</title>

    <link rel="icon" type="image/png" href="{{ asset('images/escudo_nav.png') }}?v=1">

    <!-- FUENTES -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- ICONOS -->
    <script src="https://kit.fontawesome.com/1d9a68644f.js" crossorigin="anonymous"></script>

    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- ALPINE -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- LIVIEWIRE -->
    @livewireStyles
</head>

<body class="pt-20 overflow-x-hidden font-sans antialiased 
            bg-gray-50 text-gray-900 
            dark:bg-gray-950 dark:text-gray-100 
            transition-colors duration-300">

    <!-- CABECERO -->
    <div class="shadow-md dark:shadow-lg dark:shadow-black/30">
        <x-cabecero />
    </div>

    <!-- TOASTS -->
    @if(session('success'))
        <x-toast type="success" :message="session('success')" />
    @endif

    @if(session('error'))
        <x-toast type="error" :message="session('error')" />
    @endif

    @if(session('info'))
        <x-toast type="info" :message="session('info')" />
    @endif

    <!-- CONTENIDO -->
    <main class="min-h-screen">
        <div class="max-w-7xl mx-auto px-4 py-6">
            {{ $slot }}
        </div>
    </main>

    <x-confirm-modal />

    <!-- FOOTER -->
    <div class="shadow-[0_-4px_10px_rgba(0,0,0,0.05)] dark:shadow-[0_-4px_20px_rgba(255,255,255,0.05)]">
        <x-footer />
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @livewireScripts

</body>

</html>