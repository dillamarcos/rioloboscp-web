    <x-layout>
        <div class="space-y-6 px-4 md:px-8">

            <!-- NOTICIAS SLIDER -->
            <section x-data="newsSlider(@js($ultimasNoticias))" x-init="start()" class="relative">

                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">
                    Últimas noticias
                </h2>

                <div class="relative flex items-center">

                    <!-- IZQUIERDA -->
                    <button @click="prev()"
                        class="mr-3 bg-indigo-700 hover:bg-indigo-600 text-white px-3 py-2 rounded-full shadow transition hover:scale-110">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <!-- SLIDER -->
                    <div class="flex-1 overflow-hidden rounded-xl shadow bg-white dark:bg-gray-800">

                        <template x-for="(news, index) in newsList" :key="index">

                            <div class="min-h-[260px] md:min-h-[280px] grid md:grid-cols-3 gap-6 p-6 md:p-8 items-stretch"
                                :class="current === index ? 'block' : 'hidden'">

                                <!-- IMAGEN -->
                                <div class="md:col-span-1 flex items-center justify-center">
                                    <img :src="`/storage/${news.imagen}`" class="w-full max-h-56 object-cover rounded-lg shadow-sm">
                                </div>

                                <!-- CONTENIDO -->
                                <div class="md:col-span-2 flex flex-col h-full">

                                    <!-- TITULO -->
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white"
                                        x-text="news.titulo">
                                    </h3>

                                    <div class="h-px bg-gray-300 dark:bg-gray-600 my-3"></div>

                                    <!-- DESCRIPCIÓN -->
                                    <p class="text-gray-600 dark:text-gray-300 text-sm md:text-base
                                        line-clamp-4 md:line-clamp-5 overflow-hidden">
                                        <span x-text="news.contenido"></span>
                                    </p>

                                    <!-- ESPACIADOR FLEX -->
                                    <div class="flex-1"></div>

                                    <!-- FOOTER FIJO ABAJO -->
                                    <div class="flex justify-between items-center pt-4 mt-auto">

                                        <span class="text-xs md:text-sm text-gray-500"
                                            x-text="news.fecha_publicacion">
                                        </span>

                                        <a href="{{ route('noticias.index') }}"
                                            class="flex items-center justify-center bg-indigo-700 hover:bg-indigo-600 text-white px-3 py-2 rounded-lg text-sm shadow-md transition hover:scale-105">
                                            Ver más
                                            <i class="fa-solid fa-arrow-up-right-from-square text-xs ml-2"></i>
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </template>

                    </div>

                    <!-- DERECHA -->
                    <button @click="next()" class="ml-3 bg-indigo-700 hover:bg-indigo-600 text-white px-3 py-2 rounded-full shadow transition hover:scale-110">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                </div>
            </section>

            <!-- PARTIDOS -->
            <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- ÚLTIMO PARTIDO -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mt-2">

                    <h3 class="font-bold mb-3 text-gray-800 dark:text-gray-100">
                        Último partido
                    </h3>

                    <div class="h-px bg-gray-300 dark:bg-gray-600 my-3 mb-6"></div>

                    @if($ultimoPartido)

                        <div class="flex items-center justify-center gap-3 text-gray-800 dark:text-gray-200 text-sm md:text-base font-semibold">

                            <!-- LOCAL -->
                            <div class="flex items-center gap-2">

                                <img src="{{ $ultimoPartido->equipoLocal?->escudo ? asset('storage/' . $ultimoPartido->equipoLocal->escudo) : asset('images/default.png') }}"
                                    class="w-8 h-8 rounded-full object-contain">

                                <span class="text-gray-800 dark:text-gray-200">
                                    {{ $ultimoPartido->equipoLocal?->nombre ?? 'Equipo' }}
                                </span>
                            </div>

                            <span class="font-bold text-gray-900 dark:text-white">
                                {{ $ultimoPartido->goles_local ?? 0 }} - {{ $ultimoPartido->goles_visitante ?? 0 }}
                            </span>

                            <!-- VISITANTE -->
                            <div class="flex items-center gap-2">

                                <span class="text-gray-800 dark:text-gray-200">
                                    {{ $ultimoPartido->equipoVisitante?->nombre ?? 'Equipo' }}
                                </span>

                                <img src="{{ $ultimoPartido->equipoVisitante?->escudo ? asset('storage/' . $ultimoPartido->equipoVisitante->escudo) : asset('images/default.png') }}"
                                    class="w-8 h-8 rounded-full object-contain">

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

                <!-- PRÓXIMO PARTIDO -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mt-2">

                    <h3 class="font-bold mb-3 text-gray-800 dark:text-gray-100">
                        Próximo partido
                    </h3>

                    <div class="h-px bg-gray-300 dark:bg-gray-600 my-3 mb-6"></div>

                    @if($proximoPartido)

                        <div class="flex items-center justify-center text-gray-800 dark:text-gray-200 text-sm md:text-base gap-3 font-semibold">

                            <!-- LOCAL -->
                            <div class="flex items-center gap-2">

                                <img src="{{ $proximoPartido->equipoLocal?->escudo ? asset('storage/' . $proximoPartido->equipoLocal->escudo) : asset('images/default.png') }}"
                                    class="w-8 h-8 rounded-full object-contain">

                                <span class="text-gray-800 dark:text-gray-200">
                                    {{ $proximoPartido->equipoLocal?->nombre ?? 'Equipo' }}
                                </span>
                            </div>

                            <span class="text-gray-700 dark:text-gray-300">
                                vs
                            </span>

                            <!-- VISITANTE -->
                            <div class="flex items-center gap-2">

                                <span class="text-gray-800 dark:text-gray-200">
                                    {{ $proximoPartido->equipoVisitante?->nombre ?? 'Equipo' }}
                                </span>

                                <img src="{{ $proximoPartido->equipoVisitante?->escudo ? asset('storage/' . $proximoPartido->equipoVisitante->escudo) : asset('images/default.png') }}"
                                    class="w-8 h-8 rounded-full object-contain">
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
                    class="flex justify-center items-center w-full md:w-auto bg-indigo-700 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-md transition hover:scale-105 -mt-2">

                    Ver calendario completo
                    <i class="fas fa-calendar-alt ml-2 md:ml-1"></i>
                </a>
            </div>

            <!-- SOCIOS + CLASIFICACIÓN -->
            <section class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                <div class="lg:col-span-3 bg-white dark:bg-gray-800 rounded-xl shadow p-6 flex flex-col justify-between">

                    <div>
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">
                            ¿Eres seguidor fiel del CP Riolobos?
                        </h2>

                        <div class="h-px bg-gray-300 dark:bg-gray-600 my-3 mx-1"></div>

                        <p class="text-justify text-gray-600 dark:text-gray-300">
                            Hazte socio y forma parte del equipo desde dentro:
                            vive cada partido con más pasión, apoya al club en cada paso y disfruta de ventajas exclusivas
                            que te harán sentir los colores como nunca.
                        </p>

                        <p class="text-justify text-gray-600 dark:text-gray-300 mt-2">
                            Accede a promociones especiales en merchandising, participa en sorteos únicos para ganar todo tipo de premios,
                            recibe noticias antes que nadie y siente que tu apoyo marca la diferencia en cada jornada.
                            Ser socio no es solo animar desde la grada, es pertenecer a una familia que comparte ilusión, esfuerzo y orgullo por estos colores.
                        </p>
                    </div>

                    <a href="{{ route('socio.index') }}"
                        class="mt-4 self-end w-full md:w-auto text-center md:text-right bg-indigo-700 hover:bg-indigo-600 text-white px-5 py-2 rounded-lg shadow-md transition hover:scale-105">
                        Hazte socio
                        <i class="fa-solid fa-user-group ml-1"></i>
                    </a>
                </div>

                <!-- CLASIFICACIÓN -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">

                    <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-3">
                        Clasificación
                    </h3>

                    <div class="h-px bg-gray-300 dark:bg-gray-600 my-3 mx-1"></div>

                    <div class="text-center mb-4">
                        <div class="flex justify-center gap-14 items-end">

                            <div>
                                <p class="text-3xl font-bold text-indigo-600">
                                    {{ $puesto }}º
                                </p>
                                <p class="text-sm text-gray-500">Puesto</p>
                            </div>

                            <div>
                                <p class="text-3xl font-bold text-indigo-600">
                                    {{ $puntos }}
                                </p>
                                <p class="text-sm text-gray-500">Puntos</p>
                            </div>

                        </div>

                        <p class="text-sm text-gray-500 mt-2">Riolobos CP</p>
                    </div>

                    {{-- RACHA --}}
                    <div class="flex justify-center gap-2 mb-4">

                        @foreach($racha as $r)

                            @if($r == 'V')
                                <div class="w-8 h-8 flex items-center justify-center rounded-md bg-green-500 text-white">
                                    <i class="fas fa-check text-sm"></i>
                                </div>

                            @elseif($r == 'E')
                                <div class="w-8 h-8 flex items-center justify-center rounded-md bg-yellow-500 text-white">
                                    <i class="fas fa-minus text-sm"></i>
                                </div>

                            @else
                                <div class="w-8 h-8 flex items-center justify-center rounded-md bg-red-500 text-white">
                                    <i class="fas fa-xmark text-sm"></i>
                                </div>
                            @endif

                        @endforeach

                    </div>

                    <a href="{{ route('clasificacion.index') }}"
                        class="block text-center bg-indigo-700 hover:bg-indigo-600 text-white py-2 rounded-lg shadow-md transition hover:scale-105">
                        Ver clasificación
                    </a>
                </div>

            </section>


            <!-- INSTALACIONES -->
            <section class="bg-indigo-700 text-white rounded-xl overflow-hidden">

                <div class="grid md:grid-cols-4">

                    <img src="{{ asset('images/Polideportivo1.jpg') }}" class="w-full h-56 md:h-full object-cover">

                    <div class="p-6 md:col-span-3 flex flex-col justify-center">

                        <h2 class="text-2xl font-bold">
                            ¿Dónde nos encontramos?
                        </h2>

                        <div class="h-px bg-white/40 my-3 mx-1"></div>

                        <p class="text-justify opacity-90">
                            Nos encontrarás en el pabellón municipal de Riolobos, situado en la provincia de Cáceres.
                            Ven a visitarnos, conoce nuestras instalaciones y forma parte de la familia que hace crecer al
                            club.
                        </p>

                        <div class="mt-4 flex flex-col sm:flex-row gap-3 sm:justify-end">
                            <a href="https://www.google.com/maps/dir/?api=1&destination=Polideportivo+Municipal+de+Riolobos"
                                target="_blank"
                                class="w-full sm:w-auto text-center bg-white text-indigo-700 px-3 py-2 rounded-lg shadow-md font-semibold transition hover:scale-105">
                                Cómo llegar
                                <i class="fa-solid fa-location-dot ml-1"></i>
                            </a>

                            <a href="{{ route('equipo.index', ['tab' => 'instalaciones']) }}"
                                class="w-full sm:w-auto text-center border border-white px-4 py-2 rounded-lg shadow-md transition hover:scale-105">
                                Más información
                                <i class="fa-solid fa-circle-info ml-1"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </section>


            <!-- MERCH + CLUB -->
            <section class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 flex flex-col justify-between">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">
                        Merchandising oficial
                    </h2>

                    <div class="h-px bg-gray-300 dark:bg-gray-600 my-3 mx-1"></div>

                    <p class="text-justify text-gray-600 dark:text-gray-300">
                        Descubre los productos oficiales del equipo y lleva los colores contigo dentro y fuera del campo.
                        Equipaciones, accesorios y mucho más para apoyar al club en cada momento con estilo y pasión.
                    </p>

                    <a href="{{ route('tienda.index') }}"
                        class="mt-4 bg-indigo-700 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-md w-fit transition hover:scale-105">
                        Ver tienda
                        <i class="fa-solid fa-store"></i>
                    </a>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 flex flex-col justify-between">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">
                        Sobre el club
                    </h2>

                    <div class="h-px bg-gray-300 dark:bg-gray-600 my-3 mx-1"></div>

                    <p class="text-justify text-gray-600 dark:text-gray-300">
                        Accede a toda la información del equipo, apoya desde dentro y no te pierdas nada de la temporada.
                        Sigue cada partido, vive la emoción de la competición y mantente siempre conectado con el club.
                    </p>

                    <a href="{{ route('equipo.index') }}"
                        class="mt-4 bg-indigo-700 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-md w-fit transition hover:scale-105">
                        Ver todo
                        <i class="fa-solid fa-arrow-up-right-from-square text-sm ml-1"></i>
                    </a>
                </div>

            </section>

        </div>


        <!-- JS -->
        <script>
            function newsSlider(newsData) {
                return {
                    current: 0,
                    newsList: newsData,

                    start() {
                        if (this.newsList.length > 1) {
                            setInterval(() => this.next(), 10000);
                        }
                    },

                    next() {
                        this.current = (this.current + 1) % this.newsList.length;
                    },

                    prev() {
                        this.current =
                            (this.current - 1 + this.newsList.length) % this.newsList.length;
                    }
                }
            }
        </script>

    </x-layout>