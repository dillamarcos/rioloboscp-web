<x-layout>

    <div class="space-y-8 px-4 md:px-8">

        <!-- TÍTULO -->
        <div class="text-center md:text-start">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-700 dark:text-gray-100 ml-1">
                Novedades
            </h1>

            <hr class="mt-3 border-gray-300 dark:border-gray-600">
        </div>

        <!-- ÚLTIMA NOTICIA -->
        @if($ultimaNoticia)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-600 hover:shadow-lg hover:scale-105 transition overflow-hidden">

                <a href="{{ route('noticias.show', $ultimaNoticia->id) }}" class="grid md:grid-cols-3">

                    <!-- IMAGEN -->
                    <div class="md:col-span-1 bg-gray-100 dark:bg-gray-700 overflow-hidden max-h-[250px]">
                        <img src="{{ $ultimaNoticia->imagen ? asset('storage/'.$ultimaNoticia->imagen) : asset('images/default.png') }}"
                            class="w-full h-full object-fit-contain sm:object-cover md:object-fit-contain">
                    </div>

                    <!-- CONTENIDO -->
                    <div class="md:col-span-2 p-6 flex flex-col">

                        <!-- TÍTULO -->
                        <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-gray-100">
                            {{ $ultimaNoticia->titulo }}
                        </h2>

                        <div class="h-px bg-gray-300 dark:bg-gray-600 my-3 -mb-2"></div>

                        <!-- CONTENIDO -->
                        <p class="text-gray-600 dark:text-gray-300 text-sm md:text-base whitespace-pre-line">
                            {{ $ultimaNoticia->contenido }}
                        </p>

                        <!-- ESPACIADOR -->
                        <div class="flex-1"></div>

                        <!-- FOOTER -->
                        <div class="flex justify-end text-xs text-gray-500 dark:text-gray-400 mt-4">
                            <span>
                                {{ $ultimaNoticia->fecha_publicacion }} ·
                                {{ $ultimaNoticia->user->nombre }} {{ $ultimaNoticia->user->apellidos }}
                            </span>
                        </div>

                    </div>

                </a>

            </div>
        @else
            <p class="text-gray-500">No hay noticias disponibles</p>
        @endif

        <!-- LISTADO DE NOTICIAS -->
        @if($noticias->count())

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                @foreach($noticias as $noticia)
                    <a class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-600 overflow-hidden hover:shadow-lg hover:scale-105 transition" 
                        href="{{ route('noticias.show', $noticia->id) }}">

                        <!-- IMAGEN -->
                        <div class="h-40 bg-gray-100 dark:bg-gray-700 overflow-hidden">
                            <img src="{{ $noticia->imagen ? asset('storage/'.$noticia->imagen) : asset('images/default.png') }}"
                                class="w-full h-full object-cover sm:object-fit-contain">
                        </div>

                        <!-- TÍTULO -->
                        <div class="flex justify-center p-3">
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100 line-clamp-2">
                                {{ $noticia->titulo }}
                            </p>
                        </div>

                    </a>
                @endforeach

            </div>

            <!-- PAGINACIÓN -->
            <div class="mt-6">
                {{ $noticias->links() }}
            </div>

        @endif

    </div>

</x-layout>