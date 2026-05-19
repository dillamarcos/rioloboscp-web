<x-layout>

    <div class="space-y-8 px-4 md:px-8">

        <!-- TÍTULO -->
        <div class="text-center md:text-start">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-700 dark:text-gray-100">
                Hazte socio
            </h1>
            <hr class="mt-3 border-gray-300 dark:border-gray-600">
        </div>

        <!-- CARD PRINCIPAL -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-600 p-6">

            <div class="flex flex-col md:flex-row gap-6">

                <!-- TEXTO (3/4) -->
                <div class="md:w-3/4">
                    <p class="text-justify text-gray-600 dark:text-gray-300 text-sm md:text-base leading-relaxed">
                        Ser socio es mucho más que apoyar al equipo: es formar parte de una familia que comparte la misma
                        pasión por el deporte. Tendrás acceso a ventajas exclusivas, vivirás cada partido de una forma diferente
                        y contribuirás directamente al crecimiento del club.
                        <br><br>
                        Como socio, estarás presente en cada momento importante del equipo, formando parte de su crecimiento,
                        su esfuerzo diario y su evolución temporada tras temporada.
                        <br>
                        Además, disfrutarás de un ambiente único junto a otros aficionados que sienten los mismos colores,
                        creando una experiencia mucho más cercana, auténtica y emocionante dentro y fuera del campo.
                        <br><br>
                        Únete a nosotros y siente los colores desde dentro.
                        Pincha en el siguiente botón, rellena el formulario y empieza a formar parte de la historia del club.
                    </p>
                </div>

                <!-- IMAGEN + BOTÓN (1/4) -->
                <div class="md:w-1/4 flex flex-col justify-center -mt-10 gap-4">

                    <!-- IMAGEN -->
                    <img src="{{ asset('images/socio.jpg') }}"
                        class="hidden md:block max-h-[220px] w-auto object-contain rounded-lg mt-8">

                    <!-- BOTÓN -->
                    @auth
                    @if(auth()->user()->socio)
                    <button
                        class="w-full bg-gray-400 text-white px-4 py-2 mt-8 md:mt-0 rounded-lg cursor-not-allowed opacity-80">
                        Ya eres socio
                        <i class="fa-solid fa-check ml-1"></i>
                    </button>
                    @else
                    <a href="{{ route('socio.create') }}"
                        class="w-full text-center bg-indigo-700 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg transition hover:scale-105 shadow">
                        Hazte socio
                        <i class="fa-solid fa-user-plus ml-1"></i>
                    </a>
                    @endif
                    @endauth

                    @guest
                    <a href="{{ route('socio.create') }}"
                        class="w-full text-center bg-indigo-700 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg transition hover:scale-105 shadow">
                        Hazte socio
                        <i class="fa-solid fa-user-plus ml-1"></i>
                    </a>
                    @endguest

                </div>

            </div>
        </div>

        <!-- BENEFICIOS + PRECIO -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- BENEFICIOS -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-600 p-6">

                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                    Beneficios
                </h3>

                <div class="h-px bg-gray-300 dark:bg-gray-600 my-3"></div>

                <ul class="space-y-2 text-gray-600 dark:text-gray-300 text-sm md:text-base">
                    <li>✔ Acceso preferente a partidos</li>
                    <li>✔ Descuentos en desplazamientos en bus</li>
                    <li>✔ Descuentos en tienda oficial</li>
                    <li>✔ Regalos exclusivos en productos del club</li>
                    <li>✔ Participación en decisiones del club</li>
                    <li>✔ Entrada a sorteos exclusivos</li>
                </ul>

            </div>

            <!-- PRECIO -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-600 p-6">

                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                    Precio
                </h3>

                <div class="h-px bg-gray-300 dark:bg-gray-600 my-3"></div>

                <p class="text-justify text-gray-600 dark:text-gray-300 text-sm md:text-base leading-relaxed">
                    Hazte socio por solo <b>10€ al año</b> y disfruta de todas las ventajas del club.

                    No existen compromisos ni permanencia: podrás darte de baja en cualquier momento de forma sencilla.

                    Es una forma accesible de apoyar al equipo y vivir la pasión del Riolobos CP de una manera más cercana,
                    formando parte activa de una comunidad que comparte los mismos colores.
                </p>

            </div>

        </div>

        <!-- CARD: ÁREA SOCIO -->
        @auth
        @if(auth()->user()->socio)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-600 p-6">

            <!-- TÍTULO -->
            <h3 class="text-lg md:text-xl font-bold text-gray-800 dark:text-gray-100">
                Área de socio
            </h3>

            <!-- SEPARADOR FULL WIDTH -->
            <div class="h-px bg-gray-300 dark:bg-gray-600 my-3"></div>

            <!-- CONTENIDO -->
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">

                <!-- TEXTO -->
                <div class="md:w-2/3">
                    <p class="text-gray-600 dark:text-gray-300 text-sm md:text-base leading-relaxed">
                        Desde aquí puedes consultar toda tu información como socio:
                        estado de tu cuota, fecha de alta, ventajas activas y datos de tu suscripción.

                        También podrás gestionar tu perfil de socio de forma rápida y sencilla en cualquier momento.
                    </p>
                </div>

                <!-- BOTÓN -->
                <div class="md:w-1/3 flex md:justify-end">
                    <a href="{{ route('socio.show') }}"
                        class="w-full md:w-auto text-center md:text-sm lg:text-base bg-indigo-700 hover:bg-indigo-600 text-white px-5 py-2 rounded-lg transition hover:scale-105 shadow">
                        Ir a mi área de socio
                        <i class="fa-solid fa-users ml-1"></i>
                    </a>
                </div>

            </div>

        </div>
        @endif
        @endauth

    </div>

</x-layout>