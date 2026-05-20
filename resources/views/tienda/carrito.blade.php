<x-layout>

    <div class="space-y-6 px-4 md:px-8">

        <!-- HEADER -->
        <div class="flex items-center justify-between">

            <h1 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
                Tu carrito
            </h1>

        </div>

        <hr class="border-gray-300 dark:border-gray-600">

        @if($items->count())

            <div class="flex flex-col lg:flex-row gap-6">

                <!-- LISTA PRODUCTOS -->
                <div class="lg:w-3/4 space-y-4">

                    @foreach($items as $item)

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition p-4 flex gap-4 items-center">

                            <!-- IMG -->
                            <img src="{{ asset('storage/' . $item->producto->imagen) }}" class="w-24 h-24 object-cover rounded-lg hover:scale-105 transition">

                            <!-- INFO -->
                            <div class="flex-1">

                                <h3 class="font-bold text-gray-800 dark:text-white">
                                    {{ $item->producto->nombre }}
                                </h3>

                                <p class="text-sm text-gray-500 dark:text-gray-300">
                                    {{ $item->producto->descripcion_corta }}
                                </p>

                                <span class="text-gray-700 dark:text-gray-200 font-semibold">
                                    {{ number_format($item->producto->precio, 2) }} €
                                </span>

                            </div>

                            <!-- CANTIDAD -->
                            <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-lg">

                                <form method="POST" action="{{ route('carrito.decrease', $item->id) }}">
                                    @csrf
                                    <button class="w-8 h-8 hover:scale-105 hover:text-red-600 dark:hover:bg-gray-600 rounded transition">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                </form>

                                <span class="px-2 font-semibold">{{ $item->cantidad }}</span>

                                <form method="POST" action="{{ route('carrito.increase', $item->id) }}">
                                    @csrf
                                    <button class="w-8 h-8 hover:scale-105 hover:text-green-600 dark:hover:bg-gray-600 rounded transition">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </form>

                            </div>

                            <!-- SUBTOTAL -->
                            <div class="text-right w-28 font-bold text-gray-700 dark:text-white">
                                {{ number_format($item->producto->precio * $item->cantidad, 2) }} €
                            </div>

                            <!-- ELIMINAR -->
                            <form method="POST" action="{{ route('carrito.remove', $item->id) }}">
                                @csrf
                                <button class="text-gray-400 hover:text-red-600 hover:scale-105 text-xl transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>

                        </div>

                    @endforeach

                    <!-- BOTÓN SOLO SI HAY PRODUCTOS -->
                    <div class="flex justify-start -mb-12">
                        <a href="{{ route('tienda.index') }}"
                            class="inline-flex items-center gap-2 border border-gray-200 dark:border-gray-600 text-indigo-600 dark:text-gray-200 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 font-medium transition
                                bg-white dark:bg-gray-800 dark:hover:bg-gray-600 shadow-md px-4 py-2 rounded-lg hover:scale-105">

                            <i class="fa-solid fa-store"></i>
                            Volver a la tienda

                        </a>
                    </div>

                </div>

                <!-- RESUMEN -->
                <div class="lg:w-1/4">

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 sticky top-4">

                        <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">
                            Resumen del pedido
                        </h3>

                        <!-- SUBTOTAL -->
                        <div class="flex justify-between text-gray-600 dark:text-gray-300 mb-2">
                            <span>Subtotal</span>
                            <span>{{ number_format($total, 2) }} €</span>
                        </div>

                        @php
                            $esSocio = auth()->user()?->socio ?? false;
                            $descuento = $esSocio ? $total * 0.05 : 0;
                            $totalFinal = $total - $descuento;
                        @endphp

                        <!-- DESCUENTO SOCIO -->
                        @if($esSocio)
                            <div class="flex justify-between text-green-600 mb-2">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-ticket"></i>
                                    Descuento socio (5%)
                                </span>
                                <span>-{{ number_format($descuento, 2) }} €</span>
                            </div>
                        @endif

                        <hr class="my-3 border-gray-300 dark:border-gray-600">

                        <!-- TOTAL -->
                        <div class="flex justify-between text-xl font-bold">
                            <span>Total</span>
                            <span class="text-indigo-600">
                                {{ number_format($totalFinal, 2) }} €
                            </span>
                        </div>

                        <button
                            type="button"
                            @click="$dispatch('open-confirm', {
                                title: 'Confirmar solicitud de compra',
                                message: 'Se enviará un correo al equipo con tu pedido. ¿Deseas continuar?',
                                action: '#form-solicitud-compra'
                            })"
                            class="w-full mt-6 bg-indigo-600 hover:bg-indigo-500 hover:scale-105 text-white py-2 rounded-lg shadow-md transition flex items-center justify-center gap-2">

                            <i class="fa-solid fa-credit-card"></i>
                            Solicitar compra
                        </button>

                    </div>

                </div>

            </div>

        @else

            <!-- CARRITO VACÍO -->
            <div class="flex justify-center py-20 mb-[500px]">

                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-10 text-center max-w-md w-full">

                    <i class="fa-solid fa-cart-shopping text-5xl text-gray-400 mb-4"></i>

                    <h2 class="text-xl font-bold text-gray-700 dark:text-white mb-2">
                        Tu carrito está vacío
                    </h2>

                    <p class="text-gray-500 mb-6">
                        Añade productos para poder realizar tu compra
                    </p>

                    <a href="{{ route('tienda.index') }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition inline-flex items-center gap-2">
                        <i class="fa-solid fa-store"></i>
                        Ir a la tienda
                    </a>

                </div>

            </div>

        @endif

        <form id="form-solicitud-compra" method="POST" action="{{ route('carrito.solicitar') }}">
            @csrf
        </form>

    </div>

</x-layout>