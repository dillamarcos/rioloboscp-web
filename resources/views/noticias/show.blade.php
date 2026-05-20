<x-layout>

    <div class="max-w-6xl mx-auto px-4 md:px-8 space-y-6">

        @if($noticia)

            <!-- CARD PRINCIPAL -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-600 overflow-hidden">

                <div class="grid grid-cols-1 lg:grid-cols-2">

                    <!-- IMAGEN -->
                    <div class="bg-gray-100 dark:bg-gray-700 h-72 lg:h-full min-h-[320px] overflow-hidden">

                        <img src="{{ $noticia->imagen ? asset('storage/'.$noticia->imagen) : asset('images/default.png') }}"
                            class="w-full h-full object-cover sm:object-contain lg:object-cover">

                    </div>

                    <!-- CONTENIDO -->
                    <div class="p-4 md:p-6 flex flex-col">

                        <!-- TÍTULO -->
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-gray-100 leading-tight">
                            {{ $noticia->titulo }}
                        </h1>

                        <div class="h-px bg-gray-300 dark:bg-gray-600 my-3"></div>

                        <!-- TEXTO -->
                        <div class="flex-1">

                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line text-justify -mt-5">
                                {{ $noticia->contenido }}
                            </p>

                        </div>

                        <!-- FOOTER -->
                        <div class="flex justify-end mt-4 -mb-2">

                            <div class="text-xs text-right text-gray-400 dark:text-gray-400">

                                <p class="font-medium">
                                    {{ $noticia->user->nombre }}
                                    {{ $noticia->user->apellidos }} · 
                                    {{ $noticia->fecha_publicacion }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        @else

            <p class="text-gray-500">
                La noticia no existe o ha sido eliminada.
            </p>

        @endif

        <!-- BOTÓN VOLVER -->
        <a href="{{ route('noticias.index') }}"
            class="inline-flex items-center text-sm bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 shadow-sm rounded-lg py-2 px-3 font-semibold text-indigo-600 dark:text-indigo-400 
                    hover:text-indigo-500 hover:bg-gray-100 hover:scale-105 transition">
            <i class="fa-solid fa-arrow-left mr-2 translate-y-0.5"></i>
            Volver a noticias
        </a>

    </div>

</x-layout>