<x-layout>

    <div class="space-y-6 px-4 md:px-8">

        {{-- =======================
        TÍTULO
        ======================== --}}
        <div class="text-center md:text-start">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-700 dark:text-gray-100 ml-0 md:ml-1">
                Clasificación
            </h1>

            <hr class="mt-3 border-gray-300 dark:border-gray-600">

            <p class="text-gray-500 dark:text-gray-400 text-lg mt-2 md:-mb-4 lg:-mb-6 ml-0 md:ml-2">
                Primera División Extremeña de Fútbol Sala
            </p>
        </div>

        <form method="GET" class="flex justify-center md:justify-end">

            <div class="flex items-center gap-3 -mb-2">

                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 whitespace-nowrap">
                    Temporada:
                </span>

                <div x-data="{ open:false }" class="relative w-56">

                    <select name="temporada"
                        onchange="this.form.submit()"
                        @click="open = !open"
                        @blur="open = false"
                        class="input-modal appearance-none pr-10 w-full cursor-pointer">

                        @foreach($temporadas as $temporada)

                        <option value="{{ $temporada->id }}"
                            @selected($temporadaSeleccionada==$temporada->id)>

                            {{ $temporada->nombre }}

                        </option>

                        @endforeach

                    </select>

                    <!-- FLECHA -->
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">

                        <i class="fa-solid fa-chevron-down text-sm transition"
                            :class="{ 'rotate-180': open }"></i>

                    </div>

                </div>

            </div>

        </form>

        {{-- =======================
        TABLA
        ======================== --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-x-auto scroll-smooth">

            <table class="min-w-[700px] w-full text-sm md:text-base text-center">

                {{-- HEADER --}}
                <thead class="bg-indigo-700 text-white">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3 text-left">Equipo</th>
                        <th class="p-3">PJ</th>
                        <th class="p-3">V</th>
                        <th class="p-3">E</th>
                        <th class="p-3">D</th>
                        <th class="p-3">GF</th>
                        <th class="p-3">GC</th>
                        <th class="p-3">DG</th>
                        <th class="p-3">PTS</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @foreach($clasificacion as $i => $equipo)

                    <tr class="
                            {{ $equipo->nombre == 'Riolobos C.P.' ? 'bg-gray-200 dark:bg-gray-700 font-semibold' : '' }}
                            hover:bg-gray-100 dark:hover:bg-gray-700 transition
                        ">

                        <td class="p-3 font-bold">
                            {{ $i + 1 }}
                        </td>

                        <td class="p-3 flex items-center gap-3 text-left">

                            @if($equipo->escudo)
                            <img src="{{ asset('storage/' . $equipo->escudo) }}"
                                class="w-10 h-10 object-contain">
                            @else
                            <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                            @endif

                            <span class="font-semibold">
                                {{ $equipo->nombre }}
                            </span>
                        </td>

                        <td class="p-3">{{ $equipo->partidos_jugados }}</td>
                        <td class="p-3 text-green-600 font-semibold">{{ $equipo->victorias }}</td>
                        <td class="p-3 text-yellow-500 font-semibold">{{ $equipo->empates }}</td>
                        <td class="p-3 text-red-500 font-semibold">{{ $equipo->derrotas }}</td>

                        <td class="p-3">{{ $equipo->goles_a_favor }}</td>
                        <td class="p-3">{{ $equipo->goles_en_contra }}</td>

                        <td class="p-3 font-semibold
                                {{ ($equipo->goles_a_favor - $equipo->goles_en_contra) >= 0 ? 'text-green-500' : 'text-red-500' }}">
                            {{ $equipo->goles_a_favor - $equipo->goles_en_contra }}
                        </td>

                        <td class="p-3 font-bold text-lg">
                            {{ $equipo->puntos }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>
            </table>

        </div>

        {{-- =======================
        PARTIDOS
        ======================== --}}
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- =======================
            ÚLTIMO PARTIDO
            ======================== --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mt-2">

                <h3 class="font-bold mb-3 text-gray-800 dark:text-gray-100">
                    Último partido
                </h3>

                <div class="h-px bg-gray-300 dark:bg-gray-600 my-3 mb-6"></div>

                @if($ultimoPartido)

                <div class="flex items-center justify-center gap-3 text-gray-800 dark:text-gray-200 text-sm md:text-base font-semibold">

                    {{-- LOCAL --}}
                    <div class="flex items-center gap-2">

                        <img src="{{ $ultimoPartido->equipoLocal?->escudo 
                            ? asset('storage/' . $ultimoPartido->equipoLocal->escudo) 
                            : asset('images/default.png') }}"
                            class="w-8 h-8 rounded-full object-cover">

                        <span class="text-gray-800 dark:text-gray-200">
                            {{ $ultimoPartido->equipoLocal?->nombre ?? 'Equipo' }}
                        </span>
                    </div>

                    <span class="font-bold text-gray-900 dark:text-white">
                        {{ $ultimoPartido->goles_local ?? 0 }} - {{ $ultimoPartido->goles_visitante ?? 0 }}
                    </span>

                    {{-- VISITANTE --}}
                    <div class="flex items-center gap-2">

                        <span class="text-gray-800 dark:text-gray-200">
                            {{ $ultimoPartido->equipoVisitante?->nombre ?? 'Equipo' }}
                        </span>

                        <img src="{{ $ultimoPartido->equipoVisitante?->escudo 
                            ? asset('storage/' . $ultimoPartido->equipoVisitante->escudo) 
                            : asset('images/default.png') }}"
                            class="w-8 h-8 rounded-full object-cover">

                    </div>

                </div>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 text-center">
                    {{ $ultimoPartido->fecha ?? '' }}
                </p>

                @else
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    No hay partidos jugados
                </p>
                @endif

            </div>

            {{-- =======================
            PRÓXIMO PARTIDO
            ======================== --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mt-2">

                <h3 class="font-bold mb-3 text-gray-800 dark:text-gray-100">
                    Próximo partido
                </h3>

                <div class="h-px bg-gray-300 dark:bg-gray-600 my-3 mb-6"></div>

                @if($proximoPartido)

                <div class="flex items-center justify-center text-gray-800 dark:text-gray-200 text-sm md:text-base gap-3 font-semibold">

                    {{-- LOCAL --}}
                    <div class="flex items-center gap-2">

                        <img src="{{ $proximoPartido->equipoLocal?->escudo 
                            ? asset('storage/' . $proximoPartido->equipoLocal->escudo) 
                            : asset('images/default.png') }}"
                            class="w-8 h-8 rounded-full object-cover">

                        <span class="text-gray-800 dark:text-gray-200">
                            {{ $proximoPartido->equipoLocal?->nombre ?? 'Equipo' }}
                        </span>
                    </div>

                    <span class="text-gray-700 dark:text-gray-300">
                        vs
                    </span>

                    {{-- VISITANTE --}}
                    <div class="flex items-center gap-2">

                        <span class="text-gray-800 dark:text-gray-200">
                            {{ $proximoPartido->equipoVisitante?->nombre ?? 'Equipo' }}
                        </span>

                        <img src="{{ $proximoPartido->equipoVisitante?->escudo 
                            ? asset('storage/' . $proximoPartido->equipoVisitante->escudo) 
                            : asset('images/default.png') }}"
                            class="w-8 h-8 rounded-full object-cover">
                    </div>

                </div>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 text-center">
                    {{ $proximoPartido->fecha ?? '' }}
                </p>

                @else
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    No hay próximo partido programado
                </p>
                @endif

            </div>

        </section>

        <div class="flex justify-center md:justify-end">
            <a href="{{ route('calendario.index') }}"
                class="flex justify-center items-center w-full md:w-auto bg-indigo-700 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg transition hover:scale-105 -mt-2 -mb-8">
                <i class="fas fa-calendar-alt mr-2 md:mr-1"></i>
                Ver calendario completo
            </a>
        </div>

    </div>

</x-layout>