@props(['partidos', 'equipoId'])

<x-layout>

    <div
        x-data="calendarFilters()"
        x-init="initMatches({{ Js::from(
            $partidos->map(function ($p) use ($equipoId) {

                $played = $p->fecha < now();
                $isHome = $p->equipo_local_id == $equipoId;

                if ($played) {
                    if ($p->goles_local > $p->goles_visitante) $result = 'W';
                    elseif ($p->goles_local == $p->goles_visitante) $result = 'D';
                    else $result = 'L';
                } else {
                    $result = 'N';
                }

                return [
                    'played' => $played,
                    'home' => $isHome,
                    'result' => $result
                ];
            })
        ) }})"
        class="space-y-6 px-4 md:px-8">

        <!-- TÍTULO -->
        <div class="text-center md:text-start">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-700 dark:text-gray-100">
                Calendario completo
            </h1>
            <hr class="mt-3 border-gray-300 dark:border-gray-600">
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            <!-- FILTROS -->
            <aside x-data="{ open: false }" class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 h-fit">

                <!-- HEADER -->
                <div class="flex justify-between items-center cursor-pointer" @click="open = !open">

                    <h2 class="font-bold text-gray-800 dark:text-gray-100">
                        Filtros
                    </h2>

                    <div class="flex items-center gap-2">

                        <button @click.stop="reset()"
                            class="text-sm text-indigo-600 hover:text-indigo-500 hover:scale-105 transition mr-2 lg:mr-0">
                            Borrar filtros
                        </button>

                        <!-- FLECHA SOLO PANTALLAS PEQUEÑAS -->
                        <svg class="w-5 h-5 text-gray-600 transition-transform duration-200 lg:hidden"
                            :class="open ? 'rotate-180' : ''"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>

                    </div>
                </div>

                <!-- CONTENIDO -->
                <div class="space-y-3 text-sm mt-4"
                    :class="open ? 'block' : 'hidden lg:block'">

                    <div x-data="{ open: false }" class="relative w-full">

                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Temporada
                        </label>

                        <form method="GET">

                            <div class="relative">

                                <select
                                    name="temporada"
                                    onchange="this.form.submit()"
                                    @click="open = !open"
                                    @blur="open = false"
                                    class="input-modal w-full cursor-pointer appearance-none pr-10">

                                    @foreach($temporadas as $temporada)

                                    <option
                                        value="{{ $temporada->id }}"
                                        @selected($temporadaSeleccionada?->id == $temporada->id)>

                                        {{ $temporada->nombre }}

                                    </option>

                                    @endforeach

                                </select>

                                <!-- FLECHA -->
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">

                                    <svg class="w-4 h-4 text-gray-500 transition-transform duration-200"
                                        :class="open ? 'rotate-180' : ''"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 9l-7 7-7-7" />

                                    </svg>

                                </div>

                            </div>

                        </form>

                    </div>

                    <hr>

                    <template x-for="(value, key) in {
                        jugado:'Jugado',
                        porJugar:'Por jugar',
                        ganado:'Ganado',
                        empatado:'Empatado',
                        perdido:'Perdido'
                    }">

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox"
                                x-model="filters[key]"
                                class="w-4 h-4 accent-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">

                            <span x-text="value"></span>

                            <span class="ml-auto text-gray-400 text-xs" x-text="'(' + counts[key] + ')'"></span>
                        </label>

                    </template>

                    <hr>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" x-model="filters.casa"
                            class="w-4 h-4 accent-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
                        En casa <span class="ml-auto text-gray-400 text-xs" x-text="'(' + counts.casa + ')'"></span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" x-model="filters.fuera" class="w-4 h-4 accent-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
                        Fuera <span class="ml-auto text-gray-400 text-xs" x-text="'(' + counts.fuera + ')'"></span>
                    </label>

                </div>
            </aside>

            <!-- PARTIDOS -->
            <div class="lg:col-span-3">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    @foreach($partidos as $index => $partido)

                    <div x-show="visibleMatches.includes({{ $index }})" class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5">

                        <p class="text-sm text-gray-500 text-center mb-3">
                            {{ \Carbon\Carbon::parse($partido->fecha)->format('d/m/Y') }}
                        </p>

                        <div class="flex justify-between items-center font-semibold gap-2 whitespace-nowrap">

                            <div class="flex items-center gap-2 min-w-0">
                                <img src="{{ $partido->equipoLocal?->escudo ? asset('storage/'.$partido->equipoLocal->escudo) : asset('images/default.png') }}"
                                    class="w-8 h-8 object-contain">
                                <span class="truncate max-w-[140px] sm:max-w-[220px] md:max-w-[120px]">
                                    {{ $partido->equipoLocal->nombre }}
                                </span>
                            </div>

                            <div class="w-16 text-center flex-shrink-0">
                                @if($partido->fecha < now())
                                    {{ $partido->goles_local }} - {{ $partido->goles_visitante }}
                                @else
                                    vs
                                @endif
                            </div>

                            <div class="flex items-center gap-2 min-w-0 justify-end">
                                <span class="truncate max-w-[140px] sm:max-w-[220px] md:max-w-[120px]">
                                    {{ $partido->equipoVisitante->nombre }}
                                </span>
                                <img src="{{ $partido->equipoVisitante?->escudo ? asset('storage/'.$partido->equipoVisitante->escudo) : asset('images/default.png') }}"
                                    class="w-8 h-8 object-contain">
                            </div>

                            </div>
                        </div>

                        @endforeach

                    </div>
                </div>

            </div>
            
        </div>

        <!-- Alpine.js -->
        <script>
            function calendarFilters() {
                return {

                    matches: [],

                    filters: {
                        jugado: false,
                        porJugar: false,
                        ganado: false,
                        empatado: false,
                        perdido: false,
                        casa: false,
                        fuera: false
                    },

                    initMatches(data) {
                        this.matches = data;
                    },

                    get counts() {
                        return {
                            jugado: this.matches.filter(m => m.played).length,
                            porJugar: this.matches.filter(m => !m.played).length,
                            ganado: this.matches.filter(m => m.result === 'W').length,
                            empatado: this.matches.filter(m => m.result === 'D').length,
                            perdido: this.matches.filter(m => m.result === 'L').length,
                            casa: this.matches.filter(m => m.home).length,
                            fuera: this.matches.filter(m => !m.home).length
                        }
                    },

                    get visibleMatches() {
                        return this.matches
                            .map((m, i) => ({
                                ...m,
                                i
                            }))
                            .filter(m => {

                                if (this.filters.jugado && !m.played) return false;
                                if (this.filters.porJugar && m.played) return false;

                                if (this.filters.ganado && m.result !== 'W') return false;
                                if (this.filters.empatado && m.result !== 'D') return false;
                                if (this.filters.perdido && m.result !== 'L') return false;

                                if (this.filters.casa && !m.home) return false;
                                if (this.filters.fuera && m.home) return false;

                                return true;
                            })
                            .map(m => m.i);
                    },

                    reset() {
                        this.filters = {
                            jugado: false,
                            porJugar: false,
                            ganado: false,
                            empatado: false,
                            perdido: false,
                            casa: false,
                            fuera: false
                        };
                    }
                }
            }
        </script>

</x-layout>