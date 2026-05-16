<x-layout>

    <div class="space-y-6 px-4 md:px-8">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 dark:text-gray-100">
                Tienda oficial Riolobos CP
            </h1>

            <div class="flex items-center gap-5">

                <!-- FAVORITOS -->
                <a href="{{ route('favoritos.index') }}" class="relative group">
                    <i class="fa-regular fa-heart text-2xl text-gray-700 dark:text-gray-200 
                        group-hover:text-red-500 transition"></i>

                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-1.5 rounded-full">
                        {{ $favoritosCount }}
                    </span>
                </a>

                <!-- CARRITO -->
                <a href="{{ route('carrito.index') }}" class="relative group">
                    <i class="fa-solid fa-cart-shopping text-2xl text-gray-700 dark:text-gray-200 
                        group-hover:text-indigo-500 transition"></i>

                    <span class="absolute -top-2 -right-2 bg-indigo-600 text-white text-xs px-1.5 rounded-full">
                        {{ $carritoCount }}
                    </span>
                </a>

            </div>

        </div>

        <hr class="border-gray-300 dark:border-gray-700">

        <!-- CONTENIDO -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 lg:p-8">

            <div class="flex flex-col lg:flex-row gap-6">

                <!-- IMAGEN -->
                <div class="lg:w-2/5 flex justify-center">
                    <img src="{{ asset('storage/' . $producto->imagen) }}"
                        class="w-full max-w-sm object-cover rounded-lg">
                </div>

                <!-- INFO -->
                <div class="lg:w-3/5 flex flex-col justify-between space-y-6">

                    <!-- DATOS -->
                    <div class="space-y-4">

                        <!-- TÍTULO -->
                        <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $producto->nombre }}
                        </h2>

                        <hr class="border-gray-300 dark:border-gray-600">

                        <!-- PRECIO -->
                        <div class="space-y-1">

                            <span class="text-2xl md:text-3xl font-bold text-gray-700 dark:text-gray-200">
                                {{ number_format($producto->precio, 2) }} €
                            </span>

                            @php
                            $esSocio = auth()->user()?->socio ?? false;
                            $descuento = $esSocio ? $producto->precio * 0.05 : 0;
                            $precioFinal = $producto->precio - $descuento;
                            @endphp

                            @if($esSocio)
                            <div class="text-green-600 text-sm flex items-center gap-2">
                                <i class="fa-solid fa-tag"></i>
                                Precio socio: {{ number_format($precioFinal, 2) }} €
                            </div>
                            @endif

                        </div>

                        <!-- DESCRIPCIÓN -->
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            {{ $producto->descripcion_corta }}
                        </p>

                    </div>

                    <!-- BOTONES -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">

                        @php
                        $isFav = auth()->check() && auth()->user()->favoritos->contains($producto->id);
                        $inCart = auth()->check() && auth()->user()->carrito->contains('producto_id', $producto->id);
                        @endphp

                        <!-- FAVORITO -->
                        <form method="POST" action="{{ route('favoritos.toggle', $producto->id) }}" class="w-full sm:flex-1">
                            @csrf
                            <button class="w-full group flex items-center justify-center gap-2 px-4 py-2 rounded-lg shadow-md transition hover:scale-105 text-sm sm:text-base
                            {{ $isFav 
                                ? 'bg-red-500 text-white hover:bg-red-600' 
                                : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600' }}">

                                @if($isFav)
                                <i class="fa-solid fa-heart group-hover:hidden"></i>
                                <i class="fa-solid fa-heart-crack hidden group-hover:inline"></i>
                                @else
                                <i class="fa-regular fa-heart group-hover:text-red-500"></i>
                                @endif

                                <span>
                                    {{ $isFav ? 'Quitar de favoritos' : 'Añadir a favoritos' }}
                                </span>
                            </button>
                        </form>

                        <!-- CARRITO -->
                        <form method="POST" action="{{ route('carrito.toggle', $producto->id) }}" class="w-full sm:flex-1">
                            @csrf
                            <button class="w-full group flex items-center justify-center gap-2 px-4 py-2 rounded-lg shadow-md transition hover:scale-105 text-sm sm:text-base
                                {{ $inCart 
                                    ? 'bg-indigo-600 text-white hover:bg-red-500' 
                                    : 'bg-indigo-600 text-white hover:bg-indigo-500' }}">

                                @if($inCart)
                                <i class="fa-solid fa-cart-shopping group-hover:hidden"></i>
                                <i class="fa-solid fa-cart-arrow-down hidden group-hover:inline"></i>
                                @else
                                <i class="fa-solid fa-cart-plus"></i>
                                @endif

                                <span>
                                    {{ $inCart ? 'Quitar del carrito' : 'Añadir al carrito' }}
                                </span>
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        </div>

        <!-- DESCRIPCIÓN LARGA -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 lg:p-8 space-y-4 mb-12">

            <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                Detalles del producto
            </h2>

            <hr class="border-gray-300 dark:border-gray-600">

            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                {{ $producto->descripcion_larga }}
            </p>

        </div>

        <a href="{{ route('tienda.index') }}"
            class="w-full sm:w-auto sm:flex-1 inline-flex justify-center sm:justify-start items-center gap-2 text-indigo-600 dark:text-gray-200 dark:hover:text-gray-100 hover:bg-gray-100 font-medium transition
                    bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 shadow-md px-4 py-2 rounded-lg hover:scale-105 text-sm sm:text-base">

            <i class="fa-solid fa-store"></i>
            Volver a la tienda

        </a>

    </div>

</x-layout>