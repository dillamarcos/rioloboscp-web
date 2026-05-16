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
                    <i class="fa-regular fa-heart text-2xl text-gray-700 dark:text-gray-200 group-hover:text-red-500 transition"></i>

                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-1.5 rounded-full">
                        {{ $favoritosCount }}
                    </span>
                </a>

                <!-- CARRITO -->
                <a href="{{ route('carrito.index') }}" class="relative group">
                    <i class="fa-solid fa-cart-shopping text-2xl text-gray-700 dark:text-gray-200 group-hover:text-indigo-500 transition"></i>

                    <span class="absolute -top-2 -right-2 bg-indigo-600 text-white text-xs px-1.5 rounded-full">
                        {{ $carritoCount }}
                    </span>
                </a>

            </div>

        </div>

        <hr class="border-gray-300 dark:border-gray-700">

        <!-- FILTROS -->
        <form method="GET" action="{{ route('tienda.index') }}">

            <div class="flex flex-col lg:flex-row gap-6">

                <!-- SIDEBAR -->
                <div class="w-full lg:w-1/4">

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 space-y-5 sticky top-4">

                        <h3 class="text-lg font-bold text-gray-700 dark:text-white">
                            Filtros
                        </h3>

                        <!-- BUSCADOR -->
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Buscar productos..."
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600
                                bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">

                        <!-- PRECIO MIN -->
                        <div>
                            <label class="text-sm text-gray-600 dark:text-gray-300">
                                Precio mínimo: {{ request('precio_min', 0) }}€
                            </label>

                            <input type="range"
                                name="precio_min"
                                min="0"
                                max="200"
                                value="{{ request('precio_min', 0) }}"
                                class="w-full cursor-pointer accent-indigo-600">
                        </div>

                        <!-- PRECIO MAX -->
                        <div>
                            <label class="text-sm text-gray-600 dark:text-gray-300">
                                Precio máximo: {{ request('precio_max', 200) }}€
                            </label>

                            <input type="range"
                                name="precio_max"
                                min="0"
                                max="200"
                                value="{{ request('precio_max', 200) }}"
                                class="w-full cursor-pointer accent-indigo-600">
                        </div>

                        <!-- TIPO -->
                        <div x-data="{ open:false }" class="relative w-full">

                            <select name="categoria"
                                @click="open = !open"
                                @blur="open = false"
                                class="w-full appearance-none border text-gray-700 dark:text-white rounded-lg px-3 py-2 pr-10 dark:bg-gray-700 dark:border-gray-600
                                focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition cursor-pointer">

                                <option value="">Todas las categorías</option>

                                @foreach($categorias as $cat)

                                <option value="{{ $cat->id }}"
                                    @selected(request('categoria')==$cat->id)>

                                    {{ $cat->nombre }}

                                </option>

                                @endforeach

                            </select>

                            <!-- FLECHA -->
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">

                                <i class="fa-solid fa-chevron-down text-sm transition"
                                    :class="{ 'rotate-180': open }"></i>

                            </div>

                        </div>

                        <!-- BOTÓN -->
                        <button class="w-full bg-indigo-600 hover:bg-indigo-700 hover:scale-[1.02] text-white py-2 rounded-lg transition">
                            Aplicar filtros
                        </button>

                        <!-- LIMPIAR -->
                        <a href="{{ route('tienda.index') }}"
                            class="block text-center bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600
                        text-gray-700 dark:text-gray-200 py-2 rounded-lg
                        hover:bg-gray-100 dark:hover:bg-gray-600 hover:scale-[1.02] transition">
                            Limpiar filtros
                        </a>

                    </div>

                </div>

                <!-- PRODUCTOS -->
                <div class="w-full lg:w-3/4">

                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">

                        @forelse($productos as $producto)

                        <a href="{{ route('tienda.show', $producto->id) }}" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl shadow-md overflow-hidden cursor-pointer
                            hover:-translate-y-1 hover:shadow-xl hover:border hover:border-indigo-600 dark:hover:border-indigo-600 transition transition flex flex-col">

                            <!-- IMAGEN -->
                            <div class="overflow-hidden">
                                <img src="{{ asset('storage/' . $producto->imagen) }}"
                                    class="h-48 w-full object-contain">
                            </div>

                            <!-- INFO -->
                            <div class="p-4 flex flex-col flex-1 justify-between">

                                <div>
                                    <h3 class="font-bold text-gray-800 dark:text-white">
                                        {{ $producto->nombre }}
                                    </h3>

                                    <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                                        {{ $producto->descripcion_corta }}
                                    </p>
                                </div>

                                <!-- FOOTER -->
                                <div class="mt-4 flex justify-between items-center">

                                    <span class="font-semibold text-gray-700 dark:text-white">
                                        {{ number_format($producto->precio, 2) }} €
                                    </span>

                                    <div class="flex gap-3 items-center text-xl">

                                        @php
                                        $isFav = auth()->check() && auth()->user()->favoritos->contains($producto->id);
                                        $inCart = auth()->check() && auth()->user()->carrito->contains('producto_id', $producto->id);
                                        @endphp

                                        <!-- FAVORITO -->
                                        <form method="POST" action="{{ route('favoritos.toggle', $producto->id) }}">
                                            @csrf
                                            <button type="submit" class="group transition">

                                                @if($isFav)
                                                <i class="fa-solid fa-heart text-red-500 group-hover:hidden"></i>
                                                <i class="fa-solid fa-heart-crack text-red-600 hidden group-hover:inline"></i>
                                                @else
                                                <i class="fa-regular fa-heart text-gray-400 group-hover:text-red-500"></i>
                                                @endif

                                            </button>
                                        </form>

                                        <!-- CARRITO -->
                                        <form method="POST" action="{{ route('carrito.toggle', $producto->id) }}">
                                            @csrf
                                            <button type="submit" class="group transition">

                                                @if($inCart)
                                                <i class="fa-solid fa-cart-shopping text-indigo-600 group-hover:hidden"></i>
                                                <i class="fa-solid fa-cart-arrow-down text-red-500 hidden group-hover:inline"></i>
                                                @else
                                                <i class="fa-solid fa-cart-plus text-gray-400 group-hover:text-indigo-600"></i>
                                                @endif

                                            </button>
                                        </form>

                                    </div>

                                </div>

                            </div>

                        </a>

                        @empty

                        <div class="col-span-full text-center text-gray-500 py-10">
                            No hay productos con estos filtros
                        </div>

                        @endforelse

                    </div>

                    <!-- PAGINACIÓN -->
                    <div class="mt-8">
                        {{ $productos->links() }}
                    </div>

                </div>

            </div>

        </form>

    </div>

</x-layout>