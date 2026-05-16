<x-layout>

    <div class="space-y-6 px-4 md:px-8">

        <!-- HEADER -->
        <div class="text-center md:text-start">

            <h1 class="text-2xl md:text-3xl font-bold text-gray-700 dark:text-gray-100">
                Gestión de partidos
            </h1>

            <hr class="mt-3 border-gray-300 dark:border-gray-600">

            <p class="text-gray-500 dark:text-gray-400 text-lg mt-2 mb-8">
                Gestión de partidos en la liga del Riolobos C.P.
            </p>

        </div>

        <!-- FILTROS -->
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-6">

            <form method="GET"
                class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 lg:flex lg:flex-1 gap-4">

                <!-- BUSCADOR -->
                <input type="text"
                    name="buscar"
                    value="{{ request('buscar') }}"
                    placeholder="Buscar partido..."
                    class="input-modal w-full">

                <!-- JORNADA -->
                <div x-data="{ open:false }" class="relative w-full">

                    <select name="jornada"
                        @click="open = !open"
                        @blur="open = false"
                        class="input-modal appearance-none pr-10 w-full cursor-pointer">

                        <option value="">
                            Todas las jornadas
                        </option>

                        @foreach($jornadas as $jornada)

                        <option value="{{ $jornada }}"
                            @selected(request('jornada')==$jornada)>

                            Jornada {{ $jornada }}

                        </option>

                        @endforeach

                    </select>

                    <!-- FLECHA -->
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">

                        <i class="fa-solid fa-chevron-down text-sm transition"
                            :class="{ 'rotate-180': open }"></i>

                    </div>

                </div>

                <!-- EQUIPO -->
                <div x-data="{ open:false }" class="relative w-full">

                    <select name="equipo"
                        @click="open = !open"
                        @blur="open = false"
                        class="input-modal appearance-none pr-10 w-full cursor-pointer">

                        <option value="">
                            Todos los equipos
                        </option>

                        @foreach($equipos as $equipo)

                        <option value="{{ $equipo->id }}"
                            @selected(request('equipo')==$equipo->id)>

                            {{ $equipo->nombre }}

                        </option>

                        @endforeach

                    </select>

                    <!-- FLECHA -->
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">

                        <i class="fa-solid fa-chevron-down text-sm transition"
                            :class="{ 'rotate-180': open }"></i>

                    </div>

                </div>

                <!-- TEMPORADA -->
                <div x-data="{ open:false }" class="relative w-full">

                    <select name="temporada"
                        @click="open = !open"
                        @blur="open = false"
                        class="input-modal appearance-none pr-10 w-full cursor-pointer">

                        <option value="">Todas las temporadas</option>

                        @foreach($temporadas as $temporada)

                        <option value="{{ $temporada->id }}"
                            @selected(request('temporada')==$temporada->id)>

                            {{ $temporada->nombre }}

                        </option>

                        @endforeach

                    </select>

                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <i class="fa-solid fa-chevron-down text-sm transition"
                            :class="{ 'rotate-180': open }"></i>
                    </div>

                </div>

                <!-- BOTÓN -->
                <button type="submit"
                    class="btn-primary w-full sm:w-auto">

                    Filtrar

                </button>

            </form>

            <!-- NUEVO -->
            <div class="w-full lg:w-auto">

                <button
                    @click="$dispatch('open-create-partido')"
                    class="btn-primary w-full lg:w-auto whitespace-nowrap">

                    <i class="fa-solid fa-plus text-sm"></i>
                    Nuevo partido

                </button>

            </div>

        </div>

        <!-- TABLA -->
        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">

            <table class="min-w-[1000px] w-full text-xs sm:text-sm text-left">

                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">

                    <tr>

                        <th class="px-4 py-3 whitespace-nowrap">
                            Temporada
                        </th>

                        <th class="px-4 py-3 whitespace-nowrap">
                            Partido
                        </th>

                        <th class="px-4 py-3 whitespace-nowrap">
                            Jornada
                        </th>

                        <th class="px-4 py-3 whitespace-nowrap">
                            Fecha
                        </th>

                        <th class="px-4 py-3 whitespace-nowrap">
                            Campo
                        </th>

                        <th class="px-4 py-3 whitespace-nowrap">
                            Resultado
                        </th>

                        <th class="px-4 py-3 whitespace-nowrap text-right">
                            Acciones
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @forelse($partidos as $partido)

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">

                        <!-- TEMPORADA -->
                        <td class="px-4 py-3 whitespace-nowrap">

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">

                                {{ $partido->temporada->nombre ?? 'Sin temporada' }}

                            </span>

                        </td>

                        <!-- PARTIDO -->
                        <td class="px-4 py-3 min-w-[280px]">

                            <div class="flex items-center gap-3">

                                <!-- LOCAL -->
                                <div class="flex items-center gap-2 min-w-0">

                                    <img src="{{ $partido->equipoLocal->escudo
                                        ? asset('storage/'.$partido->equipoLocal->escudo)
                                        : asset('images/default-team.png') }}"
                                        class="w-8 h-8 object-contain flex-shrink-0">

                                    <span class="font-medium text-xs sm:text-sm truncate max-w-[100px] sm:max-w-[180px] md:max-w-[280px]">
                                        {{ $partido->equipoLocal->nombre }}
                                    </span>

                                </div>

                                <!-- VS -->
                                <span class="text-[10px] sm:text-xs font-semibold text-gray-400">
                                    VS
                                </span>

                                <!-- VISITANTE -->
                                <div class="flex items-center gap-2 min-w-0">

                                    <span class="font-medium text-xs sm:text-sm truncate max-w-[100px] sm:max-w-[180px] md:max-w-[280px] text-right">
                                        {{ $partido->equipoVisitante->nombre }}
                                    </span>

                                    <img src="{{ $partido->equipoVisitante->escudo
                                            ? asset('storage/'.$partido->equipoVisitante->escudo)
                                            : asset('images/default-team.png') }}"
                                        class="w-8 h-8 object-contain flex-shrink-0">

                                </div>

                            </div>

                        </td>

                        <!-- JORNADA -->
                        <td class="px-4 py-3 whitespace-nowrap">

                            Jornada {{ $partido->jornada }}

                        </td>

                        <!-- FECHA -->
                        <td class="px-4 py-3 whitespace-nowrap">

                            {{ \Carbon\Carbon::parse($partido->fecha)->format('d/m/Y') }}

                        </td>

                        <!-- CAMPO -->
                        <td class="px-4 py-3 whitespace-nowrap">

                            {{ $partido->campo ?? 'Sin campo' }}

                        </td>

                        <!-- RESULTADO -->
                        <td class="px-4 py-3 whitespace-nowrap">

                            @if(!$partido->esta_jugado)

                                <span class="text-gray-500 italic">
                                    Por jugar
                                </span>

                            @else

                                <span class="font-semibold text-sm">
                                    {{ $partido->goles_local }} - {{ $partido->goles_visitante }}
                                </span>

                            @endif

                        </td>

                        <!-- ACCIONES -->
                        <td class="px-4 py-3 text-right flex justify-end gap-1">

                            @php
                            $data = [
                            'id' => $partido->id,
                            'fecha' => $partido->fecha,
                            'jornada' => $partido->jornada,
                            'campo' => $partido->campo,
                            'goles_local' => $partido->goles_local,
                            'goles_visitante' => $partido->goles_visitante,
                            'equipo_local_id' => $partido->equipo_local_id,
                            'equipo_visitante_id' => $partido->equipo_visitante_id,
                            'temporada_id' => $partido->temporada_id,
                            ];
                            @endphp

                            <!-- EDITAR -->
                            <button
                                @click='$dispatch("open-edit-partido", @json($data))'
                                class="w-10 h-10 flex items-center justify-center text-indigo-600 hover:scale-105 hover:text-indigo-500 transition">

                                <i class="fa-solid fa-pen-to-square"></i>

                            </button>

                            <!-- ELIMINAR -->
                            <form id="delete-partido-{{ $partido->id }}"
                                method="POST"
                                action="{{ route('panel.instructor.partidos.destroy', $partido->id) }}">

                                @csrf
                                @method('DELETE')

                                <button type="button"
                                    @click="$dispatch('open-confirm', {
                                        title: 'Eliminar partido',
                                        message: '¿Seguro que quieres eliminar este partido?',
                                        action: '#delete-partido-{{ $partido->id }}'
                                    })"
                                    class="w-10 h-10 flex items-center justify-center text-red-600 hover:scale-105 hover:text-red-500 transition">

                                    <i class="fa-solid fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6"
                            class="text-center py-6 text-gray-500">

                            No hay partidos

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- EDITAR PARTIDO -->
        <div
            x-data="{
                open:false,
                partido:{}
            }"

            x-on:open-edit-partido.window="
                open = true;
                partido = $event.detail;
            "

            x-show="open"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto">

            <!-- OVERLAY -->
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"
                @click="open=false"></div>

            <!-- MODAL -->
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl
                w-full max-w-sm sm:max-w-md md:max-w-2xl
                p-4 sm:p-6 border border-gray-200 dark:border-gray-700">

                <!-- HEADER -->
                <div class="flex items-center justify-between mb-4">

                    <h2 class="text-sm sm:text-lg font-bold text-gray-800 dark:text-white">
                        Editar partido
                        <i class="fa-solid fa-futbol ml-2"></i>
                    </h2>

                    <button @click="open=false"
                        class="hover:scale-110 hover:text-red-600 transition">

                        <i class="fa-solid fa-xmark"></i>

                    </button>

                </div>

                <!-- FORM -->
                <form :action="`/panel/instructor/partidos/${partido.id}`"
                    method="POST">

                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">

                        <!-- EQUIPO LOCAL -->
                        <select name="equipo_local_id"
                            x-model="partido.equipo_local_id"
                            class="input-modal cursor-pointer">

                            @foreach($equipos as $equipo)

                            <option value="{{ $equipo->id }}">
                                {{ $equipo->nombre }}
                            </option>

                            @endforeach

                        </select>

                        <!-- EQUIPO VISITANTE -->
                        <select name="equipo_visitante_id"
                            x-model="partido.equipo_visitante_id"
                            class="input-modal cursor-pointer">

                            @foreach($equipos as $equipo)

                            <option value="{{ $equipo->id }}">
                                {{ $equipo->nombre }}
                            </option>

                            @endforeach

                        </select>

                        <select name="temporada_id"
                            x-model="partido.temporada_id"
                            required
                            class="input-modal cursor-pointer">

                            <option value="">
                                Seleccionar temporada
                            </option>

                            @foreach($temporadas as $temporada)

                            <option value="{{ $temporada->id }}">
                                {{ $temporada->nombre }}
                            </option>

                            @endforeach

                        </select>

                        <input type="date"
                            name="fecha"
                            x-model="partido.fecha"
                            class="input-modal cursor-pointer">

                        <!-- GOLES LOCAL -->
                        <div class="relative">

                            <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-1 text-gray-500 bg-white dark:bg-gray-800">
                                <i class="fa-solid fa-futbol text-sm"></i>
                                <span class="text-xs font-medium">Local</span>
                            </div>

                            <input type="number"
                                name="goles_local"
                                x-model="partido.goles_local"
                                class="input-modal pr-20"
                                placeholder="0">
                        </div>

                        <!-- GOLES VISITANTE -->
                        <div class="relative">

                            <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-1 text-gray-500 bg-white dark:bg-gray-800">
                                <i class="fa-solid fa-futbol text-sm"></i>
                                <span class="text-xs font-medium">Visitante</span>
                            </div>

                            <input type="number"
                                name="goles_visitante"
                                x-model="partido.goles_visitante"
                                class="input-modal pr-24"
                                placeholder="0">
                        </div>

                        <div class="relative">

                            <div class="absolute p-1 right-3 top-1/2 -translate-y-1/2 flex items-center gap-2 text-gray-500 bg-white dark:bg-gray-800">
                                <span class="text-xs font-medium">Jornada</span>
                            </div>

                            <input type="number"
                                name="jornada"
                                x-model="partido.jornada"
                                class="input-modal"
                                placeholder="Jornada">
                        </div>

                        <input type="text"
                            name="campo"
                            x-model="partido.campo"
                            class="input-modal"
                            placeholder="Campo">

                    </div>

                    <!-- BOTONES -->
                    <div class="flex justify-end gap-2 mt-5">

                        <button type="button"
                            @click="open=false"
                            class="btn-secondary">

                            Cancelar

                        </button>

                        <button type="submit"
                            class="btn-primary">

                            Guardar

                        </button>

                    </div>

                </form>

            </div>

        </div>

        <!-- CREAR PARTIDO -->
        <div
            x-data="{
                open:false,
                temporadaSeleccionada: '{{ $temporadaActiva?->id }}',
                equiposPorTemporada: {
                    @foreach($temporadas as $temporada)
                        '{{ $temporada->id }}': [
                            @foreach($temporada->equipos as $equipo)
                                {
                                    id: {{ $equipo->id }},
                                    nombre: '{{ $equipo->nombre }}'
                                },
                            @endforeach
                        ],
                    @endforeach
                }
            }"

            x-on:open-create-partido.window="open=true"
            x-show="open"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto">

            <!-- OVERLAY -->
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"
                @click="open=false"></div>

            <!-- MODAL -->
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl
                w-full max-w-sm sm:max-w-md md:max-w-2xl
                p-4 sm:p-6 border border-gray-200 dark:border-gray-700">

                <!-- HEADER -->
                <div class="flex items-center justify-between mb-4">

                    <h2 class="text-sm sm:text-lg font-bold text-gray-800 dark:text-white">
                        Nuevo partido
                        <i class="fa-solid fa-futbol ml-2"></i>
                    </h2>

                    <button @click="open=false"
                        class="hover:scale-110 hover:text-red-600 transition">

                        <i class="fa-solid fa-xmark"></i>

                    </button>

                </div>

                <!-- FORM -->
                <form action="{{ route('panel.instructor.partidos.store') }}"
                    method="POST">

                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">

                        <!-- EQUIPO LOCAL -->
                        <select
                            name="equipo_local_id"
                            required
                            class="input-modal cursor-pointer">

                            <option value="">
                                Equipo local
                            </option>

                            <template
                                x-for="equipo in (equiposPorTemporada[temporadaSeleccionada] || [])"
                                :key="equipo.id">

                                <option
                                    :value="equipo.id"
                                    x-text="equipo.nombre">
                                </option>

                            </template>

                        </select>

                        <!-- EQUIPO VISITANTE -->
                        <select
                            name="equipo_visitante_id"
                            required
                            class="input-modal cursor-pointer">

                            <option value="">
                                Equipo visitante
                            </option>

                            <template
                                x-for="equipo in (equiposPorTemporada[temporadaSeleccionada] || [])"
                                :key="equipo.id">

                                <option
                                    :value="equipo.id"
                                    x-text="equipo.nombre">
                                </option>

                            </template>

                        </select>

                        <select
                            name="temporada_id"
                            required
                            x-model="temporadaSeleccionada"
                            class="input-modal cursor-pointer">

                            <option value="">
                                Seleccionar temporada
                            </option>

                            @foreach($temporadas as $temporada)

                            <option value="{{ $temporada->id }}">
                                {{ $temporada->nombre }}
                            </option>

                            @endforeach

                        </select>

                        <input type="date"
                            name="fecha"
                            required
                            class="input-modal">

                        <!-- GOLES LOCAL -->
                        <div class="relative">

                            <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-1 text-gray-500 bg-white dark:bg-gray-800">
                                <i class="fa-solid fa-futbol text-sm"></i>
                                <span class="text-xs font-medium">Local</span>
                            </div>

                            <input type="number"
                                name="goles_local"
                                x-model="partido.goles_local"
                                class="input-modal pr-20"
                                placeholder="0">
                        </div>

                        <!-- GOLES VISITANTE -->
                        <div class="relative">

                            <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-1 text-gray-500 bg-white dark:bg-gray-800">
                                <i class="fa-solid fa-futbol text-sm"></i>
                                <span class="text-xs font-medium">Visitante</span>
                            </div>

                            <input type="number"
                                name="goles_visitante"
                                x-model="partido.goles_visitante"
                                class="input-modal pr-24"
                                placeholder="0">
                        </div>

                        <input type="number"
                            name="jornada"
                            required
                            class="input-modal"
                            placeholder="Jornada">

                        <input type="text"
                            name="campo"
                            class="input-modal"
                            placeholder="Campo">

                    </div>

                    <!-- BOTONES -->
                    <div class="flex justify-end gap-2 mt-5">

                        <button type="button"
                            @click="open=false"
                            class="btn-secondary">

                            Cancelar

                        </button>

                        <button type="submit"
                            class="btn-primary">

                            Crear

                        </button>

                    </div>

                </form>

            </div>

        </div>

        <!-- PAGINACIÓN -->
        <div class="mt-6">

            {{ $partidos->withQueryString()->links() }}

        </div>

    </div>

</x-layout>