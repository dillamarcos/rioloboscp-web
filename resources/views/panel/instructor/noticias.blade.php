<x-layout>

    <div class="space-y-6 px-4 md:px-8">

        <div class="text-center md:text-start">

            <h1 class="text-2xl md:text-3xl font-bold text-gray-700 dark:text-gray-100">
                Gestión de noticias
            </h1>

            <hr class="mt-3 border-gray-300 dark:border-gray-600">

            <p class="text-gray-500 dark:text-gray-400 text-lg mt-2 mb-8">
                Gestión de noticias del club
            </p>

        </div>

        <!-- FILTROS -->
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-6">

            <form method="GET"
                class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 lg:flex lg:flex-1 gap-4">

                <!-- BUSCAR NOTICIA -->
                <input type="text"
                    name="buscar"
                    value="{{ request('buscar') }}"
                    placeholder="Buscar noticia..."
                    class="input-modal w-full">

                <!-- BUSCAR AUTOR -->
                <input type="text"
                    name="autor"
                    value="{{ request('autor') }}"
                    placeholder="Buscar autor..."
                    class="input-modal w-full">

                <!-- ORDEN -->
                <div x-data="{ open:false }" class="relative w-full">

                    <select name="orden"
                        @click="open = !open"
                        @blur="open = false"
                        class="input-modal appearance-none pr-10 w-full cursor-pointer">

                        <option value="desc" @selected(request('orden')==='desc' )>
                            Más recientes
                        </option>

                        <option value="asc" @selected(request('orden')==='asc' )>
                            Más antiguas
                        </option>

                    </select>

                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <i class="fa-solid fa-chevron-down text-sm transition"
                            :class="{ 'rotate-180': open }"></i>
                    </div>

                </div>

                <!-- BOTÓN -->
                <button type="submit"
                    class="btn-primary w-full sm:w-auto">

                    Filtrar

                </button>

            </form>

            <!-- NUEVA -->
            <div class="w-full lg:w-auto">
                <button
                    @click="$dispatch('open-create-noticia')"
                    class="btn-primary w-full lg:w-auto whitespace-nowrap">

                    <i class="fa-solid fa-plus text-sm"></i>
                    Nueva noticia

                </button>
            </div>

        </div>

        <!-- TABLA -->
        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">

            <table class="min-w-[760px] w-full text-xs sm:text-sm text-left">

                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap">Noticia</th>
                        <th class="px-4 py-3 whitespace-nowrap">Fecha</th>
                        <th class="px-4 py-3 whitespace-nowrap">Autor</th>
                        <th class="px-4 py-3 whitespace-nowrap text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @forelse($noticias as $noticia)

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">

                        <!-- NOTICIA -->
                        <td class="px-4 py-3 min-w-[320px]">

                            <div class="flex items-center gap-3">

                                <img src="{{ $noticia->imagen ? asset('storage/'.$noticia->imagen) : asset('images/default.png') }}"
                                    class="w-10 h-10 sm:w-12 sm:h-12 rounded object-contain flex-shrink-0">

                                <div>
                                    <p class="font-medium text-xs sm:text-sm md:text-base">
                                        {{ $noticia->titulo }}
                                    </p>

                                    <p class="text-[11px] sm:text-xs text-gray-500 dark:text-gray-400 line-clamp-1">
                                        {{ $noticia->contenido }}
                                    </p>
                                </div>

                            </div>

                        </td>

                        <!-- FECHA -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($noticia->fecha_publicacion)->format('d/m/Y') }}
                        </td>

                        <!-- AUTOR -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $noticia->user?->nombre }} {{ $noticia->user?->apellidos }}
                        </td>

                        <!-- ACCIONES -->
                        <td class="px-4 py-3 text-right flex justify-end gap-1">

                            @php
                            $data = [
                            'id' => $noticia->id,
                            'titulo' => $noticia->titulo,
                            'contenido' => $noticia->contenido,
                            'fecha_publicacion' => $noticia->fecha_publicacion,
                            'equipo_id' => $noticia->equipo_id,
                            'imagen' => $noticia->imagen,
                            ];
                            @endphp

                            <!-- EDITAR -->
                            <button
                                @click='$dispatch("open-edit-noticia", @json($data))'
                                class="w-10 h-10 flex items-center justify-center text-indigo-600 hover:scale-105 hover:text-indigo-500 transition">

                                <i class="fa-solid fa-pen-to-square"></i>

                            </button>

                            <!-- ELIMINAR -->
                            <form id="delete-noticia-{{ $noticia->id }}"
                                method="POST"
                                action="{{ route('panel.instructor.noticias.destroy', $noticia->id) }}">

                                @csrf
                                @method('DELETE')

                                <button type="button"
                                    @click="$dispatch('open-confirm', {
                                        title: 'Eliminar noticia',
                                        message: '¿Seguro que quieres eliminar esta noticia?',
                                        action: '#delete-noticia-{{ $noticia->id }}'
                                    })"
                                    class="w-10 h-10 flex items-center justify-center text-red-600 hover:scale-105 hover:text-red-500 transition">

                                    <i class="fa-solid fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="5"
                            class="text-center py-6 text-gray-500">
                            No hay noticias
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- EDITAR NOTICIA -->
        <div
            x-data="{
                open:false,
                noticia:{},
                preview:'',

                updatePreview(event) {
                    const file = event.target.files[0];

                    if(file){
                        this.preview = URL.createObjectURL(file);
                    }
                }
            }"

            x-on:open-edit-noticia.window="
                open = true;
                noticia = $event.detail;
                preview = noticia.imagen
                    ? (noticia.imagen.startsWith('http')
                        ? noticia.imagen
                        : '/storage/' + noticia.imagen)
                    : '/images/default.png';
            "
            x-show="open"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto">

            <!-- OVERLAY -->
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"
                @click="open=false"></div>

            <!-- MODAL -->
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl
                    w-full max-w-sm sm:max-w-md md:max-w-2xl
                    p-4 sm:p-6 border border-gray-200 dark:border-gray-700">

                <!-- HEADER -->
                <div class="flex items-center justify-between mb-4">

                    <h2 class="text-sm sm:text-lg font-bold text-gray-800 dark:text-white">
                        Editar noticia
                        <i class="fa-solid fa-newspaper ml-2"></i>
                    </h2>

                    <button @click="open=false"
                        class="hover:scale-110 hover:text-red-600 transition">

                        <i class="fa-solid fa-xmark"></i>

                    </button>

                </div>

                <!-- FORM -->
                <form :action="`/panel/instructor/noticias/${noticia.id}`"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="space-y-3 text-sm">

                        <!-- TÍTULO -->
                        <input type="text"
                            name="titulo"
                            x-model="noticia.titulo"
                            class="input-modal"
                            placeholder="Título">

                        <!-- CONTENIDO -->
                        <textarea
                            name="contenido"
                            rows="4"
                            x-model="noticia.contenido"
                            class="input-modal resize-none"
                            placeholder="Contenido de la noticia"></textarea>

                        <!-- FECHA -->
                        <input type="date"
                            name="fecha_publicacion"
                            x-model="noticia.fecha_publicacion"
                            class="input-modal cursor-text">

                        <!-- IMAGEN -->
                        <div class="flex items-center gap-4">

                            <!-- PREVIEW -->
                            <img
                                :src="preview"
                                class="w-20 h-20 rounded-xl object-cover border border-gray-300 dark:border-gray-600 shadow-sm">

                            <!-- INPUT -->
                            <input type="file"
                                name="imagen"
                                @change="updatePreview($event)"
                                class="input-modal cursor-pointer flex-1">

                        </div>

                    </div>

                    <!-- BOTONES -->
                    <div class="flex justify-end gap-2 mt-5">

                        <button type="button"
                            @click="open=false"
                            class="btn-secondary">

                            Cancelar

                        </button>

                        <button type="submit"
                            class="btn-primary">

                            Guardar

                        </button>

                    </div>

                </form>

            </div>

        </div>

        <!-- CREAR NOTICIA -->
        <div
            x-data="{ 
                open:false,
                today: '{{ now()->format('Y-m-d') }}',
                preview: null,

                updatePreview(event) {
                    const file = event.target.files[0];

                    if (file) {
                        this.preview = URL.createObjectURL(file);
                    }
                }
            }"
            x-on:open-create-noticia.window="open=true;preview=null;"
            x-show="open"
            class="fixed inset-0 z-50 flex items-center justify-center"
            x-cloak>

            <!-- OVERLAY -->
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"
                @click="open=false"></div>

            <!-- MODAL -->
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl
                        w-[92%] sm:w-full max-w-sm sm:max-w-md md:max-w-2xl
                        p-4 sm:p-6 border border-gray-200 dark:border-gray-700">

                <!-- HEADER -->
                <div class="flex items-center justify-between mb-4">

                    <h2 class="text-sm sm:text-lg font-bold text-gray-800 dark:text-white">
                        Nueva noticia
                        <i class="fa-solid fa-newspaper ml-2"></i>
                    </h2>

                    <button @click="open=false"
                        class="hover:scale-110 hover:text-red-600 transition">

                        <i class="fa-solid fa-xmark"></i>

                    </button>

                </div>

                <!-- FORM -->
                <form action="{{ route('panel.instructor.noticias.store') }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="space-y-3 text-sm">

                        <!-- TÍTULO -->
                        <input type="text"
                            name="titulo"
                            required
                            class="input-modal"
                            placeholder="Título">

                        <!-- CONTENIDO -->
                        <textarea
                            name="contenido"
                            rows="4"
                            required
                            class="input-modal resize-none"
                            placeholder="Contenido de la noticia"></textarea>

                        <!-- FECHA -->
                        <input type="date"
                            name="fecha_publicacion"
                            required
                            value="{{ now()->format('Y-m-d') }}"
                            class="input-modal cursor-text">

                        <!-- IMAGEN -->
                        <div class="flex items-center gap-4">

                            <!-- PREVIEW SOLO SI SE SELECCIONA UNA IMAGEN -->
                            <template x-if="preview">
                                <img
                                    :src="preview"
                                    class="w-20 h-20 rounded-xl object-cover border border-gray-300 dark:border-gray-600 shadow-sm">
                            </template>

                            <!-- INPUT -->
                            <input type="file"
                                name="imagen"
                                @change="updatePreview($event)"
                                class="input-modal cursor-pointer flex-1">

                        </div>

                    </div>

                    <!-- BOTONES -->
                    <div class="flex justify-end gap-2 mt-5">

                        <button type="button"
                            @click="open=false"
                            class="btn-secondary">

                            Cancelar

                        </button>

                        <button type="submit"
                            class="btn-primary">

                            Crear

                        </button>

                    </div>

                </form>

            </div>

        </div>

        <!-- PAGINACIÓN -->
        <div class="mt-6">
            {{ $noticias->withQueryString()->links() }}
        </div>

    </div>

</x-layout>