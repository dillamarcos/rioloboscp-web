@php
$isPanelRoute = request()->routeIs('panel.*')
@endphp

<div x-data="{ open:false, userMenu:false, panelOpen: false }" x-cloak>

    <!-- HEADER -->
    <div class="fixed top-0 left-0 right-0 z-50 w-full h-16 md:h-20 
        bg-white dark:bg-gray-900 
        text-gray-700 dark:text-gray-200 
        flex items-center justify-between 
        border border-b-1 border-gray-200 dark:border-gray-700 
        shadow-md dark:shadow-[0_4px_12px_rgba(0,0,0,0.6)] 
        mb-4 md:mb-6 px-4 md:px-10 
        transition-colors duration-300">

        <!-- LOGO -->
        <div class="flex items-center">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/escudo_nav.png') }}" alt="Logo"
                    class="cursor-pointer h-12 md:h-16 lg:h-18 hover:scale-105 transition">
            </a>

            <!-- HAMBURGUESA -->
            <button @click="open = !open" class="cursor-pointer lg:hidden p-2 
                text-gray-700 dark:text-gray-200 
                text-2xl flex items-center justify-center 
                w-9 h-9 ml-2 
                hover:text-indigo-500 transition 
                hover:scale-110 active:scale-95">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <x-menu-navegacion />

        @php
        function navActive($route) {
        return request()->routeIs($route) ? 'text-indigo-500 dark:text-indigo-400 font-bold' : 'hover:text-indigo-500 hover:font-bold dark:hover:text-indigo-400';
        }
        @endphp

        @php
        function panelActive($route) {
        return request()->routeIs($route)
        ? 'bg-indigo-50 dark:bg-indigo-500/10 border-l-4 border-indigo-600 text-indigo-700 dark:text-indigo-400 font-bold rounded-md'
        : 'border-l-4 border-transparent hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300';
        }
        @endphp

        @php
        $isTiendaActive = request()->routeIs('tienda.*') || request()->routeIs('favoritos.*') || request()->routeIs('carrito.*');
        @endphp

        <!-- NAV DESKTOP -->
        <nav class="hidden lg:flex items-center 
            space-x-4 lg:space-x-6 xl:space-x-12 
            text-xs lg:text-sm xl:text-base">

            <a href="{{ route('home') }}" class="font-inknut font-semibold transition hover:scale-105 {{ navActive('home') }}">
                Inicio
            </a>

            <a href="{{ route('equipo.index') }}" class="font-inknut font-semibold transition hover:scale-105 {{ navActive('equipo.*') }}">
                Equipo
            </a>

            <a href="{{ route('socio.index') }}" class="font-inknut font-semibold transition hover:scale-105 {{ navActive('socio.*') }}">
                Socios
            </a>

            <a href="{{ route('clasificacion.index') }}" class="font-inknut font-semibold transition hover:scale-105 {{ navActive('clasificacion.*') }}">
                Clasificación
            </a>

            <a href="{{ route('calendario.index') }}" class="font-inknut font-semibold transition hover:scale-105 {{ navActive('calendario.*') }}">
                Calendario
            </a>

            <a href="{{ route('noticias.index') }}" class="font-inknut font-semibold transition hover:scale-105 {{ navActive('noticias.*') }}">
                Noticias
            </a>

            <a href="{{ route('tienda.index') }}" class="font-inknut font-semibold transition hover:scale-105 
                {{ $isTiendaActive ? 'text-indigo-500 dark:text-indigo-400 font-bold' : 'hover:text-indigo-500 hover:font-bold dark:hover:text-indigo-400' }}">
                Tienda
            </a>

        </nav>

        <!-- ICONOS -->
        <div class="flex items-center space-x-3 ml-3 lg:ml-0">

            @auth
            @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'instructor')

            <button @click="panelOpen = !panelOpen"
                class="mr-2 text-xl transition flex items-center justify-center hover:scale-105
                {{ $isPanelRoute
                    ? 'text-indigo-500 hover:text-indigo-400'
                    : 'text-gray-700 dark:text-gray-200 hover:text-indigo-500' }}
            ">
                <i class="fa-solid fa-screwdriver-wrench"></i>
            </button>

            @endif
            @endauth

            <!-- INVITADO -->
            @guest
            <button @click="userMenu = !userMenu" class="cursor-pointer border 
                            border-gray-300 dark:border-gray-600 
                            rounded-full 
                            text-indigo-500 
                            hover:bg-gray-100 dark:hover:bg-gray-800 
                            flex items-center justify-center
                            w-10 h-10 sm:w-11 sm:h-11 md:w-12 md:h-12 
                            transition hover:scale-110 active:scale-95">

                <i class="fas fa-user text-lg sm:text-xl md:text-3xl"></i>
            </button>
            @endguest

            <!-- MENU INVITADO -->
            <div x-show="userMenu" x-cloak @click.away="userMenu = false" class="absolute right-2 md:right-4 top-14 md:top-16 
                w-25 md:w-40 bg-white dark:bg-gray-800 shadow-lg dark:shadow-black/50 rounded-lg 
                border border-gray-200 dark:border-gray-700 z-50 mt-0 md:mt-2">

                <a href="{{ route('login') }}" class="block px-4 py-2 text-xs md:text-base 
                    hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                    Iniciar sesión
                </a>

                <a href="{{ route('register') }}" class="block px-4 py-2 text-xs md:text-base 
                    hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                    Registrarse
                </a>
            </div>

            <!-- USUARIO LOGUEADO -->
            @auth
            <div class="relative" x-data="{ userMenu: false }">

                <button @click="userMenu = !userMenu"
                    class="relative cursor-pointer flex items-center justify-center rounded-full 
                        bg-gradient-to-br from-indigo-600 via-indigo-700 to-indigo-900 
                        text-white shadow-md dark:shadow-black/60
                        w-10 h-10 sm:w-11 sm:h-11 md:w-12 md:h-12
                        hover:shadow-lg hover:shadow-indigo-500/30 transition-all duration-300 hover:scale-105 active:scale-95
                        ring-2 ring-white dark:ring-gray-800 ring-offset-2 dark:ring-offset-gray-900">

                    @if(auth()->user()->foto_perfil)
                    <img src="{{ asset('storage/' . auth()->user()->foto_perfil) }}"
                        class="rounded-full w-full h-full object-cover">
                    @else
                    <span class="text-sm sm:text-base md:text-lg font-black tracking-tighter drop-shadow-md">
                        {{ strtoupper(substr(auth()->user()->nombre, 0, 1)) }}{{ strtoupper(substr(auth()->user()->apellidos, 0, 1)) }}
                    </span>
                    @endif
                </button>

                <div x-show="userMenu"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    x-cloak @click.away="userMenu = false"
                    class="absolute right-0 mt-3 w-52 bg-white dark:bg-gray-800 shadow-xl dark:shadow-black/70 rounded-xl border border-gray-200 dark:border-gray-700 z-50 overflow-hidden">

                    <div class="px-4 py-3 bg-gray-50/50 dark:bg-gray-700/30 border-b border-gray-200 dark:border-gray-700">
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider">Usuario</p>
                        <p class="text-sm font-bold text-gray-800 dark:text-gray-100 truncate">
                            {{ auth()->user()->nombre }} {{ auth()->user()->apellidos }}
                        </p>
                    </div>

                    <div class="">
                        @if(auth()->user()->socio)
                        <a href="{{ route('socio.show') }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm transition-all
                {{ request()->routeIs('socio.show') 
                    ? 'bg-indigo-50 dark:bg-indigo-500/10 border-l-4 rounded-md border-indigo-600 text-indigo-700 dark:text-indigo-400 font-bold' 
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 border-l-4 border-transparent' }}">
                            <i class="fas fa-users w-5 text-center text-xs"></i>
                            Mi equipo
                        </a>
                        @endif

                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm transition-all
                {{ request()->routeIs('profile.edit') 
                    ? 'bg-indigo-50 dark:bg-indigo-500/10 border-l-4 rounded-md border-indigo-600 text-indigo-700 dark:text-indigo-400 font-bold' 
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 border-l-4 border-transparent' }}">
                            <i class="fas fa-cog w-5 text-center text-xs"></i>
                            Ajustes de perfil
                        </a>

                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 bg-gray-50/30 dark:bg-gray-900/10">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-sm font-semibold text-red-500 hover:bg-red-50 dark:hover:bg-red-950/20 transition-colors border-l-4 border-transparent">
                                <i class="fas fa-sign-out-alt w-5 text-center text-xs"></i>
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endauth

        </div>

    </div>

    <!-- OVERLAY -->
    <div x-show="panelOpen"
        @click="panelOpen = false"
        class="fixed inset-0 bg-black/40 z-40"></div>

    <!-- PANEL LATERAL -->
    <aside x-show="panelOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="-translate-x-full opacity-0"
        x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="translate-x-0 opacity-100"
        x-transition:leave-end="-translate-x-full opacity-0"
        class="fixed top-0 left-0 h-full w-72 bg-white dark:bg-gray-800 z-50 shadow-2xl overflow-y-auto border-r border-gray-200 dark:border-gray-700">

        <div class="p-5">

            <div class="flex items-center justify-between mb-6">

                <h2 class="text-lg font-bold text-gray-800 dark:text-white">
                    Panel de control
                </h2>

                <button @click="panelOpen = false"
                    class="text-gray-500 hover:text-red-500 transition text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>


            <nav class="space-y-2 text-sm">

                @auth
                <!-- ADMIN -->
                @if(auth()->user()->rol === 'admin')
                <div class="mt-4">

                    <p class="px-3 text-xs uppercase text-gray-500 dark:text-gray-400 mb-2">
                        Administración
                    </p>

                    <a href="{{ route('panel.admin.usuarios') }}"
                        class="block px-3 py-2 mb-4 transition-all font-semibold {{ panelActive('panel.admin.*') }}">
                        Usuarios
                    </a>

                </div>
                @endif

                <!-- SOCIOS -->
                <p class="px-3 text-xs uppercase text-gray-500 dark:text-gray-400 mt-8 mb-2">
                    Gestión deportiva
                </p>

                <div x-data="{ openSocios: {{ request()->routeIs('panel.instructor.socios*','panel.instructor.solicitudes*') ? 'true' : 'false' }} }">

                    <button @click="openSocios = !openSocios"
                        class="w-full flex justify-between items-center px-3 py-2 transition-all font-semibold
                            border-l-4 border-transparent rounded-md
                            text-gray-700 dark:text-gray-300
                            hover:bg-gray-100 dark:hover:bg-gray-700">

                        <span>Socios</span>

                        <i class="fa-solid fa-chevron-down text-xs transition"
                            :class="{ 'rotate-180': openSocios }"></i>

                    </button>

                    <div x-show="openSocios"
                        x-transition
                        class="ml-3 mt-2 space-y-1">

                        <a href="{{ route('panel.instructor.socios') }}"
                            class="block px-3 py-1 transition-all rounded-md {{ panelActive('panel.instructor.socios*') }}">
                            Todos los socios
                        </a>

                        <a href="{{ route('panel.instructor.solicitudes') }}"
                            class="block px-3 py-1 transition-all rounded-md {{ panelActive('panel.instructor.solicitudes*') }}">
                            Solicitudes
                        </a>

                    </div>

                </div>

                <!-- RESTO -->
                <a href="{{ route('panel.instructor.partidos') }}"
                    class="block px-3 py-2 transition-all font-semibold {{ panelActive('panel.instructor.partidos*') }}">
                    Partidos
                </a>

                <a href="{{ route('panel.instructor.jugadores') }}"
                    class="block px-3 py-2 transition-all font-semibold {{ panelActive('panel.instructor.jugadores*') }}">
                    Jugadores
                </a>

                <a href="{{ route('panel.instructor.equipos') }}"
                    class="block px-3 py-2 transition-all font-semibold {{ panelActive('panel.instructor.equipos*') }}">
                    Equipos y temporadas
                </a>

                <a href="{{ route('panel.instructor.productos') }}"
                    class="block px-3 py-2 transition-all font-semibold {{ panelActive('panel.instructor.productos*') }}">
                    Productos
                </a>

                <a href="{{ route('panel.instructor.noticias') }}"
                    class="block px-3 py-2 transition-all font-semibold {{ panelActive('panel.instructor.noticias*') }}">
                    Noticias
                </a>

                @endauth

            </nav>
        </div>
    </aside>

</div>