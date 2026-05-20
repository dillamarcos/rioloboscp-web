@props([
    'jugadores',
    'equipo',
    'topGoleadores',
    'pichichi',
    'victorias',
    'empates',
    'derrotas',
    'golesPorMes',
])

<x-layout>

    <div
        x-data="{ 
            tab: new URLSearchParams(window.location.search).get('tab') 
                || localStorage.getItem('tab') 
                || 'plantilla' 
        }"
        x-init="$watch('tab', value => localStorage.setItem('tab', value))"
        class="space-y-6 px-4 md:px-8">

        <!-- TÍTULO -->
        <div class="text-center md:text-start">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-700 dark:text-gray-100 ml-0 md:ml-1">
                Conoce nuestro equipo
            </h1>

            <hr class="mt-3 border-gray-300 dark:border-gray-600">
        </div>

        <!-- CARD EQUIPO -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 flex flex-col md:flex-row items-center md:items-start gap-6">

            <!-- ESCUDO -->
            <img src="{{ asset('images/escudo_nav.png') }}"
                class="w-28 h-28 md:w-36 md:h-36 object-contain">

            <!-- INFO -->
            <div class="text-justify md:text-left">

                <h2 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-700 dark:text-gray-100">
                    Riolobos C.P.
                </h2>

                <p class="text-gray-500 text-sm md:text-base lg:text-lg dark:text-gray-400 mt-1">
                    Extremadura, Cáceres
                </p>

                <p class="text-gray-600 dark:text-gray-300 text-xs md:text-sm lg:text-base mt-3 max-w-4xl">
                    El Riolobos C.P. es un club de fútbol sala que representa con orgullo a su localidad,
                    apostando por el esfuerzo, el trabajo en equipo y la formación de sus jugadores.
                    Con el apoyo de su afición, el equipo afronta cada temporada con ilusión y ganas de seguir creciendo
                    dentro y fuera de la pista.
                </p>

            </div>

        </div>

        <!-- FILTRO (TABS) -->
        <div class="bg-gray-300 dark:bg-gray-700 rounded-lg flex flex-wrap md:flex-nowrap w-full md:w-fit">

            <!-- PLANTILLA -->
            <button @click="tab = 'plantilla'" :class="tab === 'plantilla' ? 'bg-indigo-600 text-white shadow' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-500 dark:hover:text-indigo-400 hover:scale-105 transition-transform'"
                class="px-6 py-3 md:py-2 rounded-md text-sm md:text-base font-semibold transition w-1/2 md:w-auto">
                Plantilla
            </button>

            <!-- ESTADÍSTICAS -->
            <button @click="tab = 'estadisticas'" :class="tab === 'estadisticas' ? 'bg-indigo-600 text-white shadow' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-500 dark:hover:text-indigo-400 hover:scale-105 transition-transform'"
                class="px-6 py-3 md:py-2 rounded-md text-sm md:text-base font-semibold transition w-1/2 md:w-auto">
                Estadísticas
            </button>

            <!-- INSTALACIONES -->
            <button @click="tab = 'instalaciones'" :class="tab === 'instalaciones' ? 'bg-indigo-600 text-white shadow' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-500 dark:hover:text-indigo-400 hover:scale-105 transition-transform'"
                class="px-6 py-3 md:py-2 rounded-md text-sm md:text-base font-semibold transition w-1/2 md:w-auto">
                Instalaciones
            </button>

            <!-- SOBRE NOSOTROS -->
            <button @click="tab = 'sobre'" :class="tab === 'sobre' ? 'bg-indigo-600 text-white shadow' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-500 dark:hover:text-indigo-400 hover:scale-105 transition-transform'"
                class="px-6 py-3 md:py-2 rounded-md text-sm md:text-base font-semibold transition w-1/2 md:w-auto">
                Sobre nosotros
            </button>

        </div>

        <!-- PLANTILLA -->
        <div x-show="tab === 'plantilla'" x-transition class="space-y-8">

            @php
                $posiciones = [
                    'portero' => 'Porteros',
                    'cierre' => 'Cierres',
                    'ala' => 'Ala',
                    'delantero' => 'Delanteros',
                ];
            @endphp

            @foreach($posiciones as $key => $titulo)

            <div>

                <!-- TITULO POSICIÓN -->
                <h3 class="text-xl md:text-2xl font-bold text-gray-700 dark:text-gray-200 mb-4">
                    {{ $titulo }}
                </h3>

                <!-- JUGADORES -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">

                    @foreach($jugadores->where('posicion', $key)->sortBy('dorsal') as $jugador)

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-lg transition p-3">

                            <!-- IMAGEN -->
                            <div class="relative">

                                <img src="{{ $jugador->imagen ? asset('storage/'.$jugador->imagen) : asset('storage/default-player.png') }}"
                                    class="w-full h-52 object-contain rounded-lg">

                                <!-- DORSAL -->
                                <div class="absolute bottom-2 right-2 bg-indigo-600 text-white font-bold 
                                        w-8 h-8 flex items-center justify-center rounded-md shadow">
                                    {{ $jugador->dorsal }}
                                </div>

                            </div>

                            <!-- INFO -->
                            <div class="mt-3 text-center">

                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100 leading-tight">
                                    {{ $jugador->nombre }}
                                </p>

                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $jugador->apellidos }}
                                </p>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

            @endforeach


            <!-- CUERPO TÉCNICO -->
            <div>

                <h3 class="text-xl md:text-2xl font-bold text-gray-700 dark:text-gray-200 mb-4">
                    Cuerpo técnico
                </h3>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">

                    <!-- ENTRENADOR -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition p-3">

                        <div class="relative">

                            <img src="{{ asset('images/segundo.png') }}" class="w-full h-52 object-contain rounded-lg">

                        </div>

                        <div class="mt-3 text-center">

                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100 leading-tight">
                                {{ $equipo->entrenador }}
                            </p>

                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Entrenador
                            </p>

                        </div>

                    </div>

                    <!-- SEGUNDO ENTRENADOR -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition p-3">

                        <div class="relative">

                            <img src="{{ asset('images/2entrenador.png') }}" class="w-full h-52 object-contain rounded-lg">

                        </div>

                        <div class="mt-3 text-center">

                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100 leading-tight">
                                Luis Alberto
                            </p>

                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Segundo entrenador
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- ESTADÍSTICAS -->
        <div x-show="tab === 'estadisticas'" x-transition class="space-y-6" id="stats-container"
            data-victorias="{{ $victorias }}"
            data-empates="{{ $empates }}"
            data-derrotas="{{ $derrotas }}"
            data-goles="{{ json_encode(array_values($golesPorMes)) }}">

            <!-- FILA 1 -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                <!-- TABLA GOLEADORES (3/4) -->
                <div class="lg:col-span-3 bg-white dark:bg-gray-800 rounded-xl shadow p-5">

                    <h3 class="text-lg md:text-xl font-bold text-gray-700 dark:text-gray-200 mb-4">
                        Top goleadores
                    </h3>

                    <table class="w-full text-sm text-left">

                        <thead class="text-gray-500 dark:text-gray-400 border-b">
                            <tr>
                                <th class="pb-2">#</th>
                                <th class="pb-2">Jugador</th>
                                <th class="pb-2 text-right">Goles</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y dark:divide-gray-700">

                            @foreach($topGoleadores as $i => $jugador)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition">

                                    <td class="py-2 font-semibold">
                                        {{ $i + 1 }}
                                    </td>

                                    <td class="py-2">
                                        {{ $jugador->nombre }} {{ $jugador->apellidos }}
                                    </td>

                                    <td class="py-2 text-right font-bold text-indigo-600">
                                        {{ $jugador->goles }}
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

                <!-- PICHICHI (1/4) -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 flex flex-col items-center text-center">

                    <h3 class="flex text-start justify-start text-lg font-bold text-gray-700 dark:text-gray-200 mb-3">
                        Pichichi
                    </h3>

                    <img src="{{ $pichichi?->imagen ? asset('storage/'.$pichichi->imagen) : asset('storage/default-player.png') }}"
                        class="w-40 h-40 object-contain rounded-full shadow mb-2">

                    <p class="font-semibold text-gray-800 dark:text-gray-100">
                        {{ $pichichi?->nombre }} {{ $pichichi?->apellidos }}
                    </p>

                    <p class="text-indigo-600 font-bold text-lg -mb-2">
                        {{ $pichichi?->goles }} goles
                    </p>

                </div>

            </div>

            <!-- Tercera fila de la pestaña -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                <!-- IZQUIERDA: IMAGEN -->
                <div class="hidden lg:block bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">

                    <img src="{{ asset('images/equipo.png') }}" class="w-full max-h-64 p-2 object-contain">

                </div>

                <!-- DERECHA: CARD RESUMEN -->
                <div class="lg:col-span-3 bg-white dark:bg-gray-800 rounded-xl shadow p-6 space-y-4">

                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200">
                        Resumen general
                    </h3>

                    <div class="space-y-1 text-sm">

                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 dark:text-gray-300">Partidos jugados:</span>
                            <span class="font-bold">
                                {{ $partidosJugados }}
                                <span class="text-gray-500 dark:text-gray-300 font-normal">
                                    ({{ number_format($golesFavor / max($partidosJugados,1), 2) }} goles/partido)
                                </span>
                            </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 dark:text-gray-300">Goles a favor (casa/fuera):</span>
                            <span class="font-bold text-green-600 dark:text-green-500">
                                {{ $golesFavor }} ({{ $golesCasa }}/{{ $golesFuera }})
                            </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 dark:text-gray-300">Goles en contra (casa/fuera):</span>
                            <span class="font-bold text-red-600 dark:text-red-500">
                                {{ $golesContra }} ({{ $golesContraCasa }}/{{ $golesContraFuera }})
                            </span>
                        </div>

                    </div>

                    <hr class="border-gray-300 dark:border-gray-600">

                    <!-- RACHA + TARJETAS -->
                    <div class="grid grid-cols-5 gap-6 mt-4">

                        <!-- RACHA (3/5) -->
                        <div class="col-span-3">
                            <p class="text-gray-500 dark:text-gray-300 text-sm mb-2">Racha últimos 5 partidos</p>

                            <div class="flex gap-2">
                                @foreach($racha as $r)
                                    <span class="px-3 py-1 rounded-lg text-white font-bold text-sm
                                            {{ $r == 'V' ? 'bg-green-500' : ($r == 'E' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                        {{ $r }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- TARJETAS (2/5) -->
                        <div class="col-span-2 space-y-3">

                            <div class="flex items-center gap-3">
                                <div class="w-5 h-7 bg-yellow-400 rounded shadow"></div>
                                <span class="text-gray-500 dark:text-gray-300 text-sm">Amarillas</span>
                                <span class="font-bold ml-auto">{{ $amarillas }}</span>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="w-5 h-7 bg-red-500 rounded shadow"></div>
                                <span class="text-gray-500 dark:text-gray-300 text-sm">Rojas</span>
                                <span class="font-bold ml-auto">{{ $rojas }}</span>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>

        <!-- SOBRE NOSOTROS -->
        <div x-show="tab === 'sobre'" x-transition class="space-y-6">

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 space-y-4">

                <!-- Título y Separador (Aparte) -->
                <div class="mb-6">
                    <h2 class="text-lg md:text-xl font-bold text-gray-700 dark:text-gray-100">
                        Historia del Club
                    </h2>
                    <hr class="mt-3 border-gray-300 dark:border-gray-600">
                </div>

                <!-- Contenido: Texto e Imagen debajo -->
                <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">

                    <!-- Texto -->
                    <div class="w-full md:w-3/4 text-justify">
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            El Riolobos C.P. nació con la ilusión de fomentar el deporte en nuestra localidad.
                            A lo largo de los años, hemos crecido en valores y compromiso
                            con nuestra comunidad. Lo que empezó como un grupo de amigos apasionados por el fútbol,
                            disputando partidos en el campo de tierra y viviendo auténticos rifi rafes deportivos con pueblos cercanos,
                            se ha convertido hoy en unos chavales que tomaron el relevo y son ya unos referentes en la región.
                        </p>
                        <p class="text-gray-600 dark:text-gray-300 mt-4 leading-relaxed">
                            Nuestra historia no ha sido siempre continua, ya que hubo un periodo en el que el equipo de categoría senior
                            estuvo parado, pero la pasión por el club nunca desapareció. Con el paso del tiempo, esa ilusión volvió a tomar
                            forma hasta consolidar de nuevo un equipo, ya establecido en el fútbol sala, representando al pueblo
                            con orgullo.
                            <br>
                            Esta historia se seguirá escribiendo cada fin de semana en la pista, gracias al esfuerzo de cada jugador que ha vestido
                            nuestra camiseta y al apoyo incondicional de una afición que nunca nos deja solos.
                        </p>
                    </div>

                    <!-- Imagen a la derecha -->
                    <div class="w-full md:w-1/4">
                        <img src="{{ asset('images/historia_club.jpg') }}"
                            alt="Historia del club"
                            class="w-full h-48 md:h-56 lg:h-64 rounded-lg shadow-md object-cover">
                    </div>


                </div>

            </div>

            <!-- VALORES + MISIÓN/VISIÓN -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <!-- VALORES (1/4) -->
                <div class="md:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow p-5">

                    <h4 class="text-lg md:text-xl font-bold text-gray-700 dark:text-gray-200">
                        Valores
                    </h4>

                    <hr class="my-2 border-gray-300 dark:border-gray-600">

                    <ul class="grid grid-cols-2 gap-x-4 gap-y-3 text-sm font-semibold text-gray-600 dark:text-gray-300 mt-4 ml-4">
                        <li>• Esfuerzo</li>
                        <li>• Compañerismo</li>
                        <li>• Sacrificio</li>
                        <li>• Trabajo en equipo</li>
                        <li>• Respeto</li>
                        <li>• Superación</li>
                        <li>• Constancia</li>
                        <li>• Compromiso</li>
                        <li>• Solidaridad</li>
                        <li>• Orgullo</li>
                    </ul>

                </div>

                <!-- MISIÓN + VISIÓN (3/4) -->
                <div class="md:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow p-5 space-y-4">

                    <h4 class="text-lg md:text-xl font-bold text-gray-700 dark:text-gray-200">
                        Misión y visión
                    </h4>

                    <hr class="border-gray-300 dark:border-gray-600">

                    <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed text-justify">
                        <span class="font-semibold">Nuestra misión:</span>
                        Promover el deporte en nuestra comunidad, fomentar valores,
                        y representar al club con orgullo dentro y fuera de la pista, formando no solo jugadores sino también personas comprometidas.
                    </p>

                    <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed text-justify">
                        <span class="font-semibold">Nuestra visión:</span>
                        Seguir creciendo como club, consolidarnos como un referente deportivo en la localidad y en la región,
                        y construir una base sólida de jugadores, aficionados y valores que perduren en el tiempo.
                    </p>

                </div>

            </div>

            <!-- CONTACTO -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">

                <h3 class="text-lg md:text-xl font-bold text-gray-700 dark:text-gray-200">
                    Contacto
                </h3>

                <hr class="my-3 border-gray-300 dark:border-gray-600">

                <div class="flex flex-col md:flex-row gap-6">

                    <!-- TEXTO + EMAIL -->
                    <div class="md:w-1/2 space-y-3">

                        <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                            Si tienes alguna duda, quieres más información
                            o deseas ponerte en contacto con el club, no
                            dudes en escribirnos. Estaremos encantados
                            de atenderte y ayudarte en todo lo que necesites.
                        </p>

                        <p class="flex items-center font-semibold text-gray-600 dark:text-gray-300">
                            <i class="fa-regular fa-envelope mr-1 mt-1"></i>
                            rioloboscp@gmail.com
                        </p>

                    </div>

                    <!-- SEPARADOR -->
                    <div class="hidden md:block w-px bg-gray-300 dark:bg-gray-600"></div>

                    <!-- REDES -->
                    <div class="md:w-1/2 flex flex-col justify-center space-y-3">

                        <span class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                            Síguenos en nuestras redes sociales y no te pierdas ninguna novedad del club,
                            desde resultados y noticias hasta eventos y momentos destacados de la temporada.
                        </span>

                        <div class="flex justify-center gap-6 text-3xl">

                            <a href="https://www.youtube.com/@C.pRiolobos" target="_blank" class="text-gray-500 dark:text-gray-200 hover:text-red-600 dark:hover:text-red-500 hover:scale-105 transition">
                                <i class="fa-brands fa-youtube"></i>
                            </a>

                            <a href="https://www.instagram.com/c.p.riolobos/" target="_blank" class="text-gray-500 dark:text-gray-200 hover:text-pink-500 dark:hover:text-pink-500 hover:scale-105 transition">
                                <i class="fa-brands fa-instagram"></i>
                            </a>

                            <a href="https://www.tiktok.com/@riolobosc.p" target="_blank" class="text-gray-500 dark:text-gray-200 hover:text-black dark:hover:text-white hover:scale-105 transition">
                                <i class="fa-brands fa-tiktok"></i>
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- INSTALACIONES -->
        <div x-show="tab === 'instalaciones'" x-transition
            x-data="instalacionesSlider()"
            x-init="start()"
            class="space-y-10">

            <!-- Sobre nuestras instalaciones -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">

                <h2 class="text-xl font-bold text-gray-700 dark:text-gray-100">
                    Nuestras instalaciones
                </h2>

                <div class="h-px bg-gray-300 dark:bg-gray-600 my-3"></div>

                <p class="text-justify text-gray-600 dark:text-gray-300">
                    Nuestras instalaciones están diseñadas para ofrecer el mejor entorno deportivo posible,
                    combinando comodidad, funcionalidad y un espacio adecuado tanto para entrenamientos
                    como para la competición. El club trabaja continuamente para mejorar cada rincón
                    y ofrecer una experiencia completa a jugadores, técnicos y afición.
                    El club dispone de diversas instalaciones para el desarrollo deportivo. En el exterior del pabellón se
                    encuentran los vestuarios con duchas, baños y un gimnasio para la preparación física de los jugadores.
                    Además, también hay pistas de pádel y frontón que complementan la actividad deportiva.

                </p>
            </div>

            <!-- GALERÍA DE INSTALACIONES -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">

                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-100">
                        Galería
                    </h3>
                </div>

                <div class="h-px bg-gray-300 dark:bg-gray-600 my-3"></div>

                <div class="relative flex items-center justify-center py-4">

                    <!-- IZQUIERDA -->
                    <button @click="prev()"
                        class="absolute left-2 top-1/2 -translate-y-1/2 z-10 bg-indigo-700 hover:bg-indigo-600 text-white 
                    w-8 h-8 md:w-10 md:h-10 text-sm md:text-base rounded-full shadow transition hover:scale-110">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <!-- IMAGEN -->
                    <div class="flex justify-center">
                        <img :src="images[current]"
                            class="max-h-[420px] w-auto object-contain rounded-2xl shadow-lg">
                    </div>

                    <!-- DERECHA -->
                    <button @click="next()"
                        class="absolute right-2 top-1/2 -translate-y-1/2 z-10 bg-indigo-700 hover:bg-indigo-600 text-white w-8 h-8 md:w-10 md:h-10 text-sm md:text-base rounded-full shadow transition hover:scale-110">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                </div>

                <!-- INDICADORES -->
                <div class="flex justify-center gap-2 mt-4">
                    <template x-for="(img, index) in images" :key="index">
                        <div class="w-2.5 h-2.5 rounded-full" :class="current === index ? 'bg-indigo-600' : 'bg-gray-400 dark:bg-gray-600'"></div>
                    </template>
                </div>

            </div>

            <!-- CAMPO -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">

                <h2 class="text-xl font-bold text-gray-700 dark:text-gray-100">
                    Nuestro campo
                </h2>

                <div class="h-px bg-gray-300 dark:bg-gray-600 my-3"></div>

                <p class="text-justify text-gray-600 dark:text-gray-300 mb-3">
                    El pabellón municipal de Riolobos es el corazón deportivo del club,
                    un espacio donde se viven cada entrenamiento y cada partido con intensidad.
                    Situado en una ubicación accesible dentro del municipio, permite a la afición
                    acompañar al equipo en cada jornada y disfrutar del mejor fútbol sala local.
                    El pabellón cuenta con una pista de fútbol sala donde el equipo disputa sus encuentros, equipada con gradas
                    para los aficionados y una zona para los banquillos. Además, permite la práctica de otros deportes como el
                    baloncesto o el voleibol, adaptándose a diferentes actividades deportivas.
                </p>

                <span class="text-gray-700 dark:text-gray-300 font-semibold mt-3 block">
                    ¿Dónde nos encontramos?
                </span>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                    <!-- UBICACIÓN -->
                    <p class="text-sm text-gray-500 dark:text-gray-300 flex items-center gap-2 mt-2 sm:mt-0">
                        <i class="fa-solid fa-map-pin text-red-600 dark:text-red-500"></i>
                        Av. de Plasencia, 1, 10693 Riolobos, Cáceres
                    </p>

                    <!-- BOTÓN -->
                    <a href="https://www.google.com/maps/dir//Polideportivo+Municipal+de+Riolobos,+Av.+de+Plasencia,+1,+10693+Riolobos,+C%C3%A1ceres/@40.4640807,-3.6927541,13z/data=!4m8!4m7!1m0!1m5!1m1!1s0xd3e0558fb5320b3:0xc8012264a76d66c2!2m2!1d-6.302434!2d39.918309?entry=ttu&g_ep=EgoyMDI2MDQyOC4wIKXMDSoASAFQAw%3D%3D"
                        target="_blank"
                        class="flex justify-center items-center mt-2 md:mt-0 bg-indigo-700 hover:bg-indigo-600 text-white px-3 py-2 rounded-lg shadow-md transition hover:scale-105 whitespace-nowrap">
                        Cómo llegar
                        <i class="fa-solid fa-location-dot ml-1"></i>
                    </a>

                </div>

            </div>

        </div>

    </div>

    <script>
        function instalacionesSlider() {
            return {
                current: 0,

                images: [
                    '/images/instalaciones/instalaciones1.jpg',
                    '/images/instalaciones/instalaciones2.jpg',
                    '/images/instalaciones/instalaciones3.jpg',
                    '/images/instalaciones/instalaciones4.jpg'
                ],

                start() {
                    setInterval(() => {
                        this.next();
                    }, 10000);
                },

                next() {
                    this.current = (this.current + 1) % this.images.length;
                },

                prev() {
                    this.current =
                        (this.current - 1 + this.images.length) % this.images.length;
                }
            }
        }
    </script>

</x-layout>