<div class="flex min-h-screendark:bg-gray-900">

    <!-- SIDEBAR -->
    <aside class="left-0 top-16 md:top-20 w-64 h-[calc(100vh-5rem)]
        bg-white dark:bg-gray-800 shadow-xl border-r border-gray-200 dark:border-gray-700 overflow-y-auto z-40">

        <div class="p-4">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">
                Panel
            </h2>

            <nav class="space-y-1">

                @if(auth()->user()->rol === 'admin')
                <div class="mb-4">

                    <p class="px-3 text-xs uppercase text-gray-500 dark:text-gray-400 mb-2">
                        Administración
                    </p>

                    <a href="#"
                        class="block px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 font-semibold">
                        Usuarios
                    </a>

                </div>
                @endif

                <p class="px-3 text-xs uppercase text-gray-500 dark:text-gray-400 mb-2">
                    Instructor
                </p>

                <div x-data="{ open: {{ request()->routeIs('socios.*','solicitudes.*') ? 'true' : 'false' }} }" class="mb-2">

                    <button @click="open = !open"
                        class="w-full flex justify-between items-center px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 font-semibold">
                        Socios
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>

                    <div x-show="open" x-transition class="ml-3 mt-2 space-y-1">

                        <a href="#"
                            class="block px-3 py-1 text-sm rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                            Todos los socios
                        </a>

                        <a href="{{ route('dashboard.solicitudes') }}"
                            class="block px-3 py-1 text-sm rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                            Solicitudes
                        </a>

                    </div>
                </div>

                <a href="#"
                    class="block px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 font-semibold">
                    Partidos
                </a>

                <a href="#"
                    class="block px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 font-semibold">
                    Jugadores
                </a>

                <a href="#"
                    class="block px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 font-semibold">
                    Productos
                </a>

                <a href="#"
                    class="block px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 font-semibold">
                    Noticias
                </a>

            </nav>
        </div>
    </aside>

    <!-- CONTENIDO -->
    <div class="ml-52 flex-1 min-h-screen">

        <!-- HEADER DASHBOARD -->
        <div class="top-16 md:top-20 z-10 bg-white dark:bg-gray-900 
                border-b border-gray-200 dark:border-gray-700 px-6 py-4">

            @isset($header)
            {{ $header }}
            @endisset

        </div>

        <!-- BODY -->
        <main class="p-6">
            {{ $slot }}
        </main>

    </div>

</div>