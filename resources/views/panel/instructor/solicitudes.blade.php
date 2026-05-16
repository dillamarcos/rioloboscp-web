<x-layout>

    <div class="space-y-6 px-4 md:px-8">

        <!-- TÍTULO -->
        <div class="text-center md:text-start">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-700 dark:text-gray-100">
                Panel de solicitudes
            </h1>

            <hr class="mt-3 border-gray-300 dark:border-gray-600">

            <p class="text-gray-500 dark:text-gray-400 text-lg mt-2 mb-8">
                Gestión de solicitudes de alta de socios
            </p>
        </div>

        <!-- FILTROS -->
        <div class="mb-6">

            <form method="GET"
                class="flex flex-col md:flex-row md:items-center gap-4">

                <!-- BUSCADOR -->
                <input type="text"
                    name="buscar"
                    value="{{ request('buscar') }}"
                    placeholder="Buscar por nombre, DNI o email..."
                    class="input-modal w-full md:flex-1">

                <!-- ESTADO -->
                <div x-data="{ open:false }" class="relative w-full md:w-64">

                    <select name="estado"
                        @click="open = !open"
                        @blur="open = false"
                        class="input-modal w-full appearance-none cursor-pointer pr-10">

                        <option value="">Todos los estados</option>
                        <option value="pendiente" @selected(request('estado')=='pendiente' )>Pendiente</option>
                        <option value="aceptada" @selected(request('estado')=='aceptada' )>Aceptadas</option>
                        <option value="rechazada" @selected(request('estado')=='rechazada' )>Rechazadas</option>

                    </select>

                    <!-- FLECHA -->
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <i class="fa-solid fa-chevron-down text-sm transition-transform duration-200"
                            :class="{ 'rotate-180': open }"></i>
                    </div>

                </div>

                <!-- BOTÓN -->
                <button type="submit"
                    class="btn-primary w-full md:w-auto md:self-stretch">
                    Filtrar
                </button>

            </form>

        </div>

        <!-- LISTADO -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            @forelse($solicitudes as $solicitud)

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-5 transition">

                <!-- HEADER -->
                <div class="flex items-start justify-between gap-3 mb-3">

                    <!-- NOMBRE + APELLIDOS -->
                    <h2 class="flex-1 min-w-0 font-bold text-gray-800 dark:text-gray-100 text-sm sm:text-base lg:text-lg leading-tight">

                        <span class="whitespace-nowrap">
                            {{ $solicitud->user->nombre }}
                        </span>

                        <span class="whitespace-nowrap">
                            {{ $solicitud->user->apellidos }}
                        </span>

                    </h2>

                    <!-- ESTADO -->
                    <span class="text-[10px] sm:text-xs px-2 py-1 rounded-full font-semibold whitespace-nowrap shrink-0
                        {{ $solicitud->estado == 'pendiente' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $solicitud->estado == 'aceptada' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $solicitud->estado == 'rechazada' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ ucfirst($solicitud->estado) }}
                    </span>

                </div>

                <div class="h-px bg-gray-200 dark:bg-gray-700 mb-4"></div>

                <!-- INFO -->
                <div class="space-y-1 text-xs sm:text-sm text-gray-600 dark:text-gray-300">

                    <p class="break-words">
                        <span class="font-semibold">DNI:</span> {{ $solicitud->dni }}
                    </p>

                    <p class="break-words">
                        <span class="font-semibold">Teléfono:</span> {{ $solicitud->telefono }}
                    </p>

                    <p class="break-words">
                        <span class="font-semibold">Email:</span>
                        <span class="break-all">{{ $solicitud->user->email }}</span>
                    </p>

                </div>

                <!-- ACCIONES -->
                @if($solicitud->estado === 'pendiente')

                <div class="mt-5 flex flex-col sm:flex-row gap-2">

                    <form method="POST"
                        action="{{ route('panel.instructor.solicitudes.aceptar', $solicitud->id) }}"
                        class="w-full">
                        @csrf

                        <button class="w-full bg-green-600 hover:bg-green-500 text-white py-2 rounded-lg
                                transition hover:scale-105 active:scale-95 text-sm sm:text-base">
                            Aceptar
                        </button>
                    </form>

                    <form method="POST"
                        action="{{ route('panel.instructor.solicitudes.rechazar', $solicitud->id) }}"
                        class="w-full">
                        @csrf

                        <button class="w-full bg-red-600 hover:bg-red-500 text-white py-2 rounded-lg
                                transition hover:scale-105 active:scale-95 text-sm sm:text-base">
                            Rechazar
                        </button>
                    </form>

                </div>

                @endif

            </div>

            @empty

            <div class="col-span-full text-center py-10 text-gray-500 dark:text-gray-400">
                No hay solicitudes pendientes
            </div>

            @endforelse

        </div>

    </div>

</x-layout>