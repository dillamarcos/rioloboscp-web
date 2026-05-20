<!-- OVERLAY -->
<div x-show="open" x-cloak @click="open = false"
    class="fixed inset-0 bg-black/10 dark:bg-black/40 backdrop-blur-sm z-40" x-transition.opacity>
</div>

<!-- MENÚ LATERAL -->
<div x-show="open"
    class="fixed top-0 left-0 h-full w-64 bg-white dark:bg-gray-900 shadow-lg dark:shadow-black/50 z-50 p-3 text-gray-900 dark:text-gray-100"
    x-transition:enter="transition transform duration-300" x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0" x-transition:leave="transition transform duration-300"
    x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">

    <!-- HEADER DEL MENÚ -->
    <div class="flex items-center justify-between mb-3 mt-3">

        <!-- TÍTULO -->
        <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100 ml-1">
            Menú
        </h2>

        <!-- BOTÓN CERRAR -->
        <button @click="open = false" class="cursor-pointer text-gray-600 dark:text-gray-300 hover:text-red-500 hover:scale-105 dark:hover:text-red-400 transition">
            <i class="fas fa-times text-xl"></i>
        </button>

    </div>

    <hr class="mb-2">

    <!-- LINKS -->
    <nav class="flex flex-col space-y-2 text-lg font-semibold">

        <a href="{{ route('home') }}" class="relative flex items-center justify-start px-4 py-2 rounded-md transition overflow-hidden
                {{ request()->routeIs('home') ? 'text-indigo-600 dark:text-indigo-200 font-semibold bg-indigo-500/10' : 
                    'text-gray-700 dark:text-gray-200 hover:bg-indigo-100/50 hover:scale-105 hover:text-indigo-500 dark:hover:text-indigo-300 dark:hover:bg-indigo-500/20' }}">

            <!-- BARRA IZQUIERDA ACTIVA -->
            @if(request()->routeIs('home'))
                <span class="absolute left-0 top-0 h-full w-1 bg-indigo-600 rounded-r"></span>
            @endif

            <span>
                Inicio
            </span>

        </a>

        <a href="{{ route('equipo.index') }}" class="relative flex items-center justify-start px-4 py-2 rounded-md transition overflow-hidden
                {{ request()->routeIs('equipo.*') ? 'text-indigo-600 dark:text-indigo-200 font-semibold bg-indigo-500/10' : 
                    'text-gray-700 dark:text-gray-200 hover:bg-indigo-100/50 hover:scale-105 hover:text-indigo-500 dark:hover:text-indigo-300 dark:hover:bg-indigo-500/20' }}">

            <!-- BARRA IZQUIERDA ACTIVA -->
            @if(request()->routeIs('equipo.*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-indigo-600 rounded-r"></span>
            @endif

            <span>
                Equipo
            </span>

        </a>

        <a href="{{ route('socio.index') }}" class="relative flex items-center justify-start px-4 py-2 rounded-md transition overflow-hidden
                {{ request()->routeIs('socio.*') ? 'text-indigo-600 dark:text-indigo-200 font-semibold bg-indigo-500/10' : 
                    'text-gray-700 dark:text-gray-200 hover:bg-indigo-100/50 hover:scale-105 hover:text-indigo-500 dark:hover:text-indigo-300 dark:hover:bg-indigo-500/20' }}">

            <!-- BARRA IZQUIERDA ACTIVA -->
            @if(request()->routeIs('socio.*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-indigo-600 rounded-r"></span>
            @endif

            <span>
                Socios
            </span>

        </a>

        <a href="{{ route('clasificacion.index') }}" class="relative flex items-center justify-start px-4 py-2 rounded-md transition overflow-hidden
                {{ request()->routeIs('clasificacion.*') ? 'text-indigo-600 dark:text-indigo-200 font-semibold bg-indigo-500/10' : 
                    'text-gray-700 dark:text-gray-200 hover:bg-indigo-100/50 hover:scale-105 hover:text-indigo-500 dark:hover:text-indigo-300 dark:hover:bg-indigo-500/20' }}">

            <!-- BARRA IZQUIERDA ACTIVA -->
            @if(request()->routeIs('clasificacion.*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-indigo-600 rounded-r"></span>
            @endif

            <span>
                Clasificación
            </span>

        </a>

        <a href="{{ route('calendario.index') }}" class="relative flex items-center justify-start px-4 py-2 rounded-md transition overflow-hidden
                {{ request()->routeIs('calendario.*') ? 'text-indigo-600 dark:text-indigo-200 font-semibold bg-indigo-500/10' : 
                    'text-gray-700 dark:text-gray-200 hover:bg-indigo-100/50 hover:scale-105 hover:text-indigo-500 dark:hover:text-indigo-300 dark:hover:bg-indigo-500/20' }}">

            <!-- BARRA IZQUIERDA ACTIVA -->
            @if(request()->routeIs('calendario.*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-indigo-600 rounded-r"></span>
            @endif

            <span>
                Calendario
            </span>

        </a>

        <a href="{{ route('noticias.index') }}" class="relative flex items-center justify-start px-4 py-2 rounded-md transition overflow-hidden
                {{ request()->routeIs('noticias.*') ? 'text-indigo-600 dark:text-indigo-200 font-semibold bg-indigo-500/10' : 
                    'text-gray-700 dark:text-gray-200 hover:bg-indigo-100/50 hover:scale-105 hover:text-indigo-500 dark:hover:text-indigo-300 dark:hover:bg-indigo-500/20' }}">

            <!-- BARRA IZQUIERDA ACTIVA -->
            @if(request()->routeIs('noticias.*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-indigo-600 rounded-r"></span>
            @endif

            <span>
                Noticias
            </span>

        </a>

        <a href="{{ route('tienda.index') }}" class="relative flex items-center justify-start px-4 py-2 rounded-md transition overflow-hidden
                {{ request()->routeIs('tienda.*') || request()->routeIs('favoritos.*') || request()->routeIs('carrito.*') ? 'text-indigo-600 dark:text-indigo-200 font-semibold bg-indigo-500/10' : 
                    'text-gray-700 dark:text-gray-200 hover:bg-indigo-100/50 hover:scale-105 hover:text-indigo-500 dark:hover:text-indigo-300 dark:hover:bg-indigo-500/20' }}">
            
            <!-- BARRA IZQUIERDA ACTIVA -->
            @if(request()->routeIs('tienda.*') || request()->routeIs('favoritos.*') || request()->routeIs('carrito.*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-indigo-600 rounded-r"></span>
            @endif

            <span>
                Tienda
            </span>

        </a>

    </nav>

</div>