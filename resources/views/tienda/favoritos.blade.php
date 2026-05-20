<x-layout>

    <div class="space-y-6 px-4 md:px-8">

        <!-- HEADER -->
        <h1 class="text-3xl font-bold text-gray-700 dark:text-white flex items-center gap-2">
            Tus productos favoritos
        </h1>

        <hr class="border-gray-300 dark:border-gray-600">

        @if($favoritos->count())

            <!-- PRODUCTOS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach($favoritos as $producto)

                    <a href="{{ route('tienda.show', $producto->id) }}" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl shadow-md overflow-hidden cursor-pointer
                                        hover:-translate-y-1 hover:shadow-xl hover:border hover:border-indigo-600 dark:hover:border-indigo-600 transition transition flex flex-col p-4">

                        <img src="{{ asset('storage/' . $producto->imagen) }}" class="h-48 w-full object-contain rounded-lg">

                        <h3 class="mt-3 font-bold text-gray-800 dark:text-white">
                            {{ $producto->nombre }}
                        </h3>

                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            {{ $producto->descripcion_corta }}
                        </p>

                        <div class="flex justify-between items-center mt-3">

                            <span class="text-gray-700 dark:text-gray-300 font-bold">
                                {{ number_format($producto->precio, 2) }} €
                            </span>

                            <form action="{{ route('favoritos.toggle', $producto->id) }}" method="POST">
                                @csrf

                                <button class="group text-red-500 hover:text-red-700 transition relative">

                                    <!-- CORAZÓN NORMAL -->
                                    <i class="fa-solid fa-heart group-hover:hidden"></i>

                                    <!-- CORAZÓN ROTO -->
                                    <i class="fa-solid fa-heart-crack hidden group-hover:inline"></i>

                                </button>

                            </form>

                        </div>

                    </a>

                @endforeach

            </div>

            <!-- BOTÓN SOLO SI HAY PRODUCTOS -->
            <div class="flex justify-start -mb-12">
                <a href="{{ route('tienda.index') }}"
                    class="inline-flex items-center gap-2 border border-gray-200 dark:border-gray-600 text-indigo-600 dark:text-gray-200 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 font-medium transition
                    bg-white dark:bg-gray-800 dark:hover:bg-gray-600 shadow-md px-4 py-2 rounded-lg hover:scale-105">

                    <i class="fa-solid fa-store"></i>
                    Volver a la tienda

                </a>
            </div>

        @else

            <!-- CARD VACÍO -->
            <div class="flex justify-center py-20">

                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-10 text-center max-w-md w-full hover:shadow-xl transition">

                    <i class="fa-solid fa-heart text-5xl text-gray-400 mb-4"></i>

                    <h2 class="text-xl font-bold text-gray-700 dark:text-white mb-2">
                        No tienes productos en favoritos
                    </h2>

                    <p class="text-gray-500 mb-6">
                        Guarda productos para verlos más tarde aquí
                    </p>

                    <a href="{{ route('tienda.index') }}"
                        class="bg-indigo-600 hover:bg-indigo-500 hover:scale-105 text-white px-6 py-2 rounded-lg transition inline-flex items-center gap-2">

                        <i class="fa-solid fa-store"></i>
                        Ir a la tienda

                    </a>

                </div>

            </div>

        @endif

    </div>

</x-layout>