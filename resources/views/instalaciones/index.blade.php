<x-layout>

    <div x-data="instalacionesSlider()" x-init="start()" class="space-y-10 px-4 md:px-8">

        <!-- TÍTULO -->
        <div class="text-center md:text-start">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-700 dark:text-gray-100">
                Conoce nuestra casa
            </h1>

            <hr class="mt-3 border-gray-300 dark:border-gray-600">
        </div>

        <!-- Sobre nuestras instalaciones -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">

            <h2 class="text-xl font-bold text-gray-700 dark:text-gray-100">
                Sobre nuestras instalaciones
            </h2>

            <div class="h-px bg-gray-300 dark:bg-gray-600 my-3"></div>

            <p class="text-gray-600 dark:text-gray-300">
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
                    class="absolute right-2 top-1/2 -translate-y-1/2 z-10 bg-indigo-700 hover:bg-indigo-600 text-white 
                    w-8 h-8 md:w-10 md:h-10 text-sm md:text-base rounded-full shadow transition hover:scale-110">
                    <i class="fas fa-chevron-right"></i>
                </button>

            </div>

            <!-- INDICADORES -->
            <div class="flex justify-center gap-2 mt-4">
                <template x-for="(img, index) in images" :key="index">
                    <div class="w-2.5 h-2.5 rounded-full"
                        :class="current === index ? 'bg-indigo-600' : 'bg-gray-400 dark:bg-gray-600'">
                    </div>
                </template>
            </div>

        </div>

        <!-- CAMPO -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">

            <h2 class="text-xl font-bold text-gray-700 dark:text-gray-100">
                Nuestro campo
            </h2>

            <div class="h-px bg-gray-300 dark:bg-gray-600 my-3"></div>

            <p class="text-gray-600 dark:text-gray-300 mb-3">
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
                <a href="https://www.google.com/maps/dir/?api=1&destination=39.918309,-6.302434"
                    target="_blank"
                    class="flex justify-center items-center mt-2 md:mt-0 bg-indigo-700 hover:bg-indigo-600 text-white px-3 py-2 rounded-lg shadow-md transition hover:scale-105 whitespace-nowrap">
                    Cómo llegar
                    <i class="fa-solid fa-location-dot ml-1"></i>
                </a>

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