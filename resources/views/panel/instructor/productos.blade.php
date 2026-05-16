<x-layout>

    <div class="space-y-6 px-4 md:px-8">

        <div class="text-center md:text-start">

            <!-- TÍTULO -->
            <h1 class="text-2xl md:text-3xl font-bold text-gray-700 dark:text-gray-100">
                Gestión de productos
            </h1>

            <hr class="mt-3 border-gray-300 dark:border-gray-600">

            <p class="text-gray-500 dark:text-gray-400 text-lg mt-2 mb-8">
                Gestión de la lista de todos los productos disponibles en la tienda
            </p>

        </div>

        <!-- FILTROS + BOTÓN -->
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-6">

            <!-- FORM -->
            <form method="GET"
                class="grid grid-cols-1 sm:grid-cols-2 lg:flex lg:flex-1 gap-4">

                <!-- BUSCADOR -->
                <input type="text" name="buscar"
                    value="{{ request('buscar') }}"
                    placeholder="Buscar producto..."
                    class="input-modal w-full">

                <!-- CATEGORÍA -->
                <div x-data="{ open:false }" class="relative w-full">
                    <select name="categoria"
                        @click="open = !open"
                        @blur="open = false"
                        class="input-modal appearance-none pr-10 w-full cursor-pointer">

                        <option value="">Todas las categorías</option>
                        @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" @selected(request('categoria')==$categoria->id)>
                            {{ $categoria->nombre }}
                        </option>
                        @endforeach
                    </select>

                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <i class="fa-solid fa-chevron-down text-sm transition"
                            :class="{ 'rotate-180': open }"></i>
                    </div>
                </div>

                <!-- ESTADO -->
                <div x-data="{ open:false }" class="relative w-full">
                    <select name="activo"
                        @click="open = !open"
                        @blur="open = false"
                        class="input-modal appearance-none pr-10 w-full cursor-pointer">

                        <option value="">Todos los estados</option>
                        <option value="1" @selected(request('activo')==='1' )>Activos</option>
                        <option value="0" @selected(request('activo')==='0' )>Inactivos</option>
                    </select>

                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <i class="fa-solid fa-chevron-down text-sm transition"
                            :class="{ 'rotate-180': open }"></i>
                    </div>
                </div>

                <!-- BOTÓN FILTRAR -->
                <button type="submit"
                    class="btn-primary w-full sm:w-auto lg:self-end">
                    Filtrar
                </button>

            </form>

            <!-- BOTÓN NUEVO -->
            <div class="w-full lg:w-auto">
                <button
                    @click="$dispatch('open-create-producto')"
                    class="btn-primary w-full lg:w-auto whitespace-nowrap">
                    <i class="fa-solid fa-plus text-sm"></i>
                    Nuevo producto
                </button>
            </div>

        </div>

        <!-- TABLA -->
        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">

            <table class="min-w-[760px] w-full text-xs sm:text-sm text-left">

                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3">Producto</th>
                        <th class="px-4 py-3">Categoría</th>
                        <th class="px-4 py-3">Precio</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @forelse($productos as $producto)

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">

                        <!-- PRODUCTO -->
                        <td class="px-4 py-3 align-middle">
                            <div class="flex items-center gap-3">

                                <img src="{{ $producto->imagen ? asset('storage/'.$producto->imagen) : asset('images/default.png') }}"
                                    class="w-10 h-10 object-cover rounded">

                                <div>
                                    <p class="font-medium">
                                        {{ $producto->nombre }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1">
                                        {{ $producto->descripcion_corta }}
                                    </p>
                                </div>

                            </div>
                        </td>

                        <!-- CATEGORÍA -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $producto->categoria->nombre }}
                        </td>

                        <!-- PRECIO -->
                        <td class="px-4 py-3 font-semibold whitespace-nowrap">
                            {{ $producto->precio }} €
                        </td>

                        <!-- ESTADO -->
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded
                                {{ $producto->activo ? 'bg-green-200 dark:bg-green-600 text-green-600 dark:text-green-200' : 'bg-red-200 dark:bg-red-600 text-red-600 dark:text-red-200' }}">
                                {{ $producto->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>

                        <!-- ACCIONES -->
                        <td class="px-4 py-3 text-right flex justify-end gap-1">

                            @php
                            $data = [
                            'id' => $producto->id,
                            'nombre' => $producto->nombre,
                            'descripcion_corta' => $producto->descripcion_corta,
                            'descripcion_larga' => $producto->descripcion_larga,
                            'precio' => $producto->precio,
                            'activo' => $producto->activo,
                            'categoria_id' => $producto->categoria_id,
                            ];
                            @endphp

                            <!-- EDITAR -->
                            <button
                                @click='$dispatch("open-edit-producto", @json($data))'
                                class="w-10 h-10 flex items-center justify-center text-indigo-600 hover:scale-105 hover:text-indigo-500 transition">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>

                            <!-- ELIMINAR -->
                            <form id="delete-producto-{{ $producto->id }}"
                                method="POST"
                                action="{{ route('panel.instructor.productos.destroy', $producto->id) }}">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                    @click="$dispatch('open-confirm', {
                                        title: 'Eliminar producto',
                                        message: '¿Seguro que quieres eliminar este producto?',
                                        action: '#delete-producto-{{ $producto->id }}'
                                    })"
                                    class="w-10 h-10 flex items-center justify-center text-red-600 hover:scale-105 hover:text-red-500 transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>

                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">
                            No hay productos
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

            <!-- EDITAR PRODUCTO -->
            <div
                x-data="{ open:false, producto:{} }"
                x-on:open-edit-producto.window="
                    open = true;
                    producto = $event.detail;
                "
                x-show="open"
                x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center">

                <!-- OVERLAY -->
                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="open=false"></div>

                <!-- MODAL -->
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-[92%] sm:w-full max-w-sm sm:max-w-md md:max-w-lg
                    p-4 sm:p-6 border border-gray-200 dark:border-gray-700">

                    <!-- HEADER -->
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-sm sm:text-lg font-bold text-gray-800 dark:text-white">
                            Editar producto<i class="fa-solid fa-boxes-packing ml-2"></i>
                        </h2>

                        <button @click="open=false" class="hover:scale-110 hover:text-red-600 transition">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <!-- FORM -->
                    <form :action="`/panel/instructor/productos/${producto.id}`"
                        method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="space-y-3 text-sm">

                            <input type="text" name="nombre" x-model="producto.nombre"
                                class="input-modal" placeholder="Nombre">

                            <textarea name="descripcion_corta" x-model="producto.descripcion_corta"
                                class="input-modal" placeholder="Descripción corta"></textarea>

                            <textarea name="descripcion_larga" x-model="producto.descripcion_larga"
                                class="input-modal" placeholder="Descripción larga"></textarea>

                            <input type="number" step="0.01" name="precio" x-model="producto.precio"
                                class="input-modal" placeholder="Precio">

                            <input type="file" name="imagen" class="input-modal cursor-pointer">

                            <!-- CATEGORÍA -->
                            <select name="categoria_id" x-model="producto.categoria_id" class="input-modal cursor-pointer">
                                @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                @endforeach
                            </select>

                            <!-- ESTADO -->
                            <select name="activo" x-model="producto.activo" class="input-modal cursor-pointer">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>

                        </div>

                        <!-- BOTONES -->
                        <div class="flex justify-end gap-2 mt-5">
                            <button type="button" @click="open=false" class="btn-secondary">
                                Cancelar
                            </button>

                            <button type="submit" class="btn-primary">
                                Guardar
                            </button>
                        </div>

                    </form>

                </div>
            </div>

            <!-- CREAR PRODUCTO -->
            <div
                x-data="{ open:false }"
                x-on:open-create-producto.window="open=true"
                x-show="open"
                class="fixed inset-0 z-50 flex items-center justify-center"
                style="display:none;">

                <!-- OVERLAY -->
                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="open=false"></div>

                <!-- MODAL -->
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-[92%] sm:w-full max-w-sm sm:max-w-md md:max-w-lg
                        p-4 sm:p-6 border border-gray-200 dark:border-gray-700">

                    <!-- HEADER -->
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-sm sm:text-lg font-bold text-gray-800 dark:text-white">
                            Nuevo producto<i class="fa-solid fa-boxes-packing ml-2"></i>
                        </h2>

                        <button @click="open=false" class="hover:scale-110 hover:text-red-600 transition">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <!-- FORM -->
                    <form action="{{ route('panel.instructor.productos.store') }}"
                        method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-3 text-sm">

                            <input type="text" name="nombre" required
                                class="input-modal" placeholder="Nombre">

                            <textarea name="descripcion_corta" required
                                class="input-modal" placeholder="Descripción corta"></textarea>

                            <textarea name="descripcion_larga" required
                                class="input-modal" placeholder="Descripción larga"></textarea>

                            <input type="number" step="0.01" name="precio" required
                                class="input-modal" placeholder="Precio">

                            <input type="file" name="imagen" class="input-modal cursor-pointer">

                            <!-- CATEGORÍA -->
                            <select name="categoria_id" required class="input-modal cursor-pointer">
                                <option value="">Seleccionar categoría</option>
                                @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                @endforeach
                            </select>

                        </div>

                        <!-- BOTONES -->
                        <div class="flex justify-end gap-2 mt-5">
                            <button type="button" @click="open=false" class="btn-secondary">
                                Cancelar
                            </button>

                            <button type="submit" class="btn-primary">
                                Crear
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>

        <!-- PAGINACIÓN -->
        <div class="mt-6">
            {{ $productos->withQueryString()->links() }}
        </div>

    </div>

</x-layout>