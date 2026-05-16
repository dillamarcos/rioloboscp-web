<x-layout>

    <div class="space-y-6 px-4 md:px-8">

        <div class="text-center md:text-start">

            <!-- TÍTULO -->
            <h1 class="text-2xl md:text-3xl font-bold text-gray-700 dark:text-gray-100">
                Gestión de equipos
            </h1>

            <hr class="mt-3 border-gray-300 dark:border-gray-600">

            <p class="text-gray-500 dark:text-gray-400 text-lg mt-2 mb-8">
                Gestión de todos los equipos por temporada
            </p>

        </div>

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-6">

            <form method="GET"
                class="flex flex-col md:flex-row items-stretch md:items-center gap-4 w-full lg:flex-1">

                <div class="w-full md:flex-1 min-w-[200px]">
                    <input type="text"
                        name="buscar"
                        value="{{ request('buscar') }}"
                        placeholder="Buscar equipo..."
                        class="input-modal w-full">
                </div>

                <div x-data="{ open:false }" class="relative w-full md:w-64 shrink-0">
                    <select name="temporada_id"
                        @click="open = !open"
                        @blur="open = false"
                        class="input-modal appearance-none pr-10 w-full cursor-pointer">

                        <option value="">Todas las temporadas</option>

                        @foreach($temporadas as $temporada)
                        <option value="{{ $temporada->id }}"
                            @selected(request('temporada_id')==$temporada->id)>
                            {{ $temporada->nombre }}
                        </option>
                        @endforeach

                    </select>

                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <i class="fa-solid fa-chevron-down text-sm transition"
                            :class="{ 'rotate-180': open }"></i>
                    </div>
                </div>

                <div class="w-full md:w-auto shrink-0">
                    <button type="submit" class="btn-primary w-full md:w-auto whitespace-nowrap">
                        Filtrar
                    </button>
                </div>

            </form>

            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto justify-end shrink-0">
                <button type="button"
                    @click="$dispatch('open-create-temporada')"
                    class="btn-primary w-full md:w-auto whitespace-nowrap">
                    <i class="fa-solid fa-calendar-plus mr-1"></i>
                    Nueva temporada
                </button>

                <button type="button"
                    @click="$dispatch('open-asignar-equipo')"
                    class="btn-primary w-full md:w-auto whitespace-nowrap">
                    <i class="fa-solid fa-plus mr-1"></i>
                    Asignar equipo
                </button>
            </div>

        </div>

        <!-- INFO TEMPORADA -->
        @if($temporadaSeleccionada)

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 mb-6 shadow-sm">

            <div class="flex flex-row items-center justify-between gap-4">

                @php
                $pivot = null;

                if ($temporadaSeleccionada) {
                $pivot = $temporadaSeleccionada->equipos()
                ->wherePivot('temporada_id', $temporadaSeleccionada->id)
                ->first()?->pivot;
                }
                @endphp

                <!-- INFO -->
                <div class="min-w-0">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-100 truncate">
                        Temporada: {{ $temporadaSeleccionada->nombre }}
                    </h2>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 mt-2">

                        <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 px-3 py-1.5 rounded-lg text-xs sm:text-sm">
                            <i class="fa-solid fa-trophy text-indigo-500"></i>
                            <span>
                                <span class="font-semibold">Liga:</span>
                                {{ $pivot->liga ?? 'Sin definir' }} - {{ $pivot->grupo ?? 'Sin definir' }}
                            </span>
                        </div>

                    </div>
                </div>

                <!-- ACCIONES (SIEMPRE EN UNA FILA) -->
                <div class="flex flex-row flex-nowrap items-center gap-2 shrink-0">

                    <!-- EDITAR -->
                    <button
                        @click="$dispatch('open-edit-temporada', {
                    id: {{ $temporadaSeleccionada->id }},
                    nombre: '{{ $temporadaSeleccionada->nombre }}',
                    fecha_inicio: '{{ $temporadaSeleccionada->fecha_inicio }}',
                    fecha_fin: '{{ $temporadaSeleccionada->fecha_fin }}',
                    activa: {{ $temporadaSeleccionada->activa ? 1 : 0 }}
                })"
                        class="w-9 h-9 flex items-center justify-center text-indigo-600 hover:scale-105 transition">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    <!-- ELIMINAR -->
                    <form id="delete-temporada-{{ $temporadaSeleccionada->id }}"
                        method="POST"
                        action="{{ route('panel.instructor.temporadas.destroy', $temporadaSeleccionada->id) }}">
                        @csrf
                        @method('DELETE')

                        <button type="button"
                            @click="$dispatch('open-confirm', {
                        title: 'Eliminar temporada',
                        message: '¿Seguro que quieres eliminar esta temporada?',
                        action: '#delete-temporada-{{ $temporadaSeleccionada->id }}'
                    })"
                            class="w-9 h-9 flex items-center justify-center text-red-600 hover:scale-105 transition">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>

                </div>

            </div>

        </div>

        @endif

        <!-- TABLA EQUIPOS -->
        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">

            <table class="w-full text-xs sm:text-sm text-left table-fixed">

                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-300 text-xs sm:text-sm">
                    <tr>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 w-[45%]">Equipo</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 w-[35%]">Entrenador</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 w-[20%]">Localización</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 w-[20%] text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @forelse($equipos as $equipo)

                    @php
                    $pivot = $equipo->temporadas
                    ->where('id', $temporadaSeleccionada?->id)
                    ->first()?->pivot;
                    @endphp

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">

                        <!-- EQUIPO -->
                        <td class="px-3 sm:px-4 py-2 sm:py-3 align-middle">
                            <div class="flex items-center gap-2 sm:gap-3 min-w-0">

                                <img src="{{ $equipo->escudo ? asset('storage/'.$equipo->escudo) : asset('images/default.png') }}"
                                    class="w-9 h-9 object-contain rounded">

                                <div class="min-w-0">
                                    <p class="font-medium truncate text-xs sm:text-sm">
                                        {{ $equipo->nombre }}
                                    </p>
                                    <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400 line-clamp-1">
                                        {{ $equipo->descripcion }}
                                    </p>
                                </div>

                            </div>
                        </td>

                        <!-- ENTRENADOR -->
                        <td class="px-3 sm:px-4 py-2 sm:py-3 whitespace-nowrap text-xs sm:text-sm">
                            {{ $equipo->entrenador }}
                        </td>

                        <!-- LOCALIZACIÓN -->
                        <td class="px-3 sm:px-4 py-2 sm:py-3 whitespace-nowrap text-xs sm:text-sm">
                            {{ $equipo->localizacion }}
                        </td>

                        <!-- ACCIONES -->
                        <td class="px-3 sm:px-4 py-2 sm:py-3 text-right">
                            <div class="flex justify-end gap-1 sm:gap-2">

                                @php
                                $data = [
                                'id' => $equipo->id,
                                'nombre' => $equipo->nombre,
                                'descripcion' => $equipo->descripcion,
                                'localizacion' => $equipo->localizacion,
                                'entrenador' => $equipo->entrenador,
                                'escudo' => $equipo->escudo ? asset('storage/'.$equipo->escudo) : null,
                                ];
                                @endphp

                                <!-- EDITAR -->
                                <button
                                    @click='$dispatch("open-edit-equipo", @json($data))'
                                    class="w-10 h-10 flex items-center justify-center text-indigo-600 hover:scale-105 transition">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <!-- ELIMINAR DE TEMPORADA -->
                                <form id="remove-equipo-{{ $equipo->id }}" method="POST"
                                    action="{{ route('panel.instructor.equipos.remove', [$equipo->id, $temporadaSeleccionada->id]) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                        @click="$dispatch('open-confirm', {
                                title: 'Eliminar equipo de temporada',
                                message: '¿Seguro que quieres quitar este equipo de la temporada?',
                                action: '#remove-equipo-{{ $equipo->id }}'
                            })"
                                        class="w-10 h-10 flex items-center justify-center text-red-600 hover:scale-105 transition">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">
                            No hay equipos en esta temporada
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- MODAL ASIGNAR EQUIPO -->
        <div
            x-data="{ open:false, crear:false }"
            x-on:open-asignar-equipo.window="open = true"
            x-show="open"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto p-4">

            <!-- OVERLAY -->
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="open = false"></div>

            <!-- MODAL -->
            <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">

                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-800 dark:text-white">
                        Asignar equipo a temporada<i class="fa-solid fa-people-group ml-2"></i>
                    </h2>

                    <button @click="open=false"
                        class="text-gray-400 hover:text-red-600 transition">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form method="POST" enctype="multipart/form-data" action="{{ route('panel.instructor.equipos.store') }}">
                    @csrf

                    <!-- TEMPORADA -->
                    <select name="temporada_id" required class="input-modal mb-3 w-full">
                        <option value="">Seleccionar temporada</option>

                        @foreach($temporadas as $temp)
                        <option value="{{ $temp->id }}"
                            @selected(
                            old('temporada_id', $temporadaActiva?->id) == $temp->id
                            )>
                            {{ $temp->nombre }}
                        </option>
                        @endforeach
                    </select>

                    <!-- SWITCH -->
                    <div class="flex gap-4 mb-3 text-sm">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio"
                                name="modo_ui"
                                value="existente"
                                checked
                                @click="crear=false"
                                class="accent-indigo-600">
                            <span>Equipo existente</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio"
                                name="modo_ui"
                                value="nuevo"
                                @click="crear=true"
                                class="accent-indigo-600">
                            <span>Nuevo equipo</span>
                        </label>
                    </div>

                    <!-- EXISTENTE -->
                    <div x-show="!crear">
                        <select name="equipo_id" class="input-modal mb-3 w-full">
                            <option value="">Seleccionar equipo</option>
                            @foreach($todosEquipos as $eq)
                            <option value="{{ $eq->id }}">{{ $eq->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- NUEVO EQUIPO -->
                    <div x-show="crear" class="space-y-2 mb-2">

                        <input type="text" name="nombre"
                            placeholder="Nombre del equipo"
                            class="input-modal w-full">

                        <input type="text" name="descripcion"
                            placeholder="Descripción"
                            class="input-modal w-full">

                        <input type="text" name="localizacion"
                            placeholder="Localización"
                            class="input-modal w-full">

                        <input type="text" name="entrenador"
                            placeholder="Entrenador"
                            class="input-modal w-full">

                        <input type="file" name="escudo"
                            class="input-modal w-full cursor-pointer"">
                    </div>

                    <!-- DATOS TEMPORADA -->
                    <input type=" text" name="categoria" placeholder="Categoría"
                            class="input-modal mb-2 w-full">

                        <input type="text" name="liga" placeholder="Liga"
                            class="input-modal mb-2 w-full">

                        <input type="text" name="grupo" placeholder="Grupo"
                            class="input-modal mb-4 w-full">

                        <input type="hidden" name="crear_nuevo" :value="crear ? 1 : 0">

                        <!-- BOTONES -->
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="open=false" class="btn-secondary">
                                Cancelar
                            </button>

                            <button type="submit" class="btn-primary">
                                Añadir
                            </button>
                        </div>

                </form>

            </div>

        </div>

        <!-- MODAL CREAR TEMPORADA -->
        <div
            x-data="{ open:false }"
            x-on:open-create-temporada.window="open = true"
            x-show="open"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto p-4">

            <!-- overlay -->
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="open=false"></div>

            <!-- modal -->
            <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 w-full max-w-md">

                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-800 dark:text-white">
                        Nueva temporada<i class="fa-solid fa-table-list ml-2"></i>
                    </h2>

                    <button @click="open=false"
                        class="text-gray-400 hover:text-red-600 transition">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form method="POST" action="{{ route('panel.instructor.temporadas.store') }}">
                    @csrf

                    <input type="text"
                        name="nombre"
                        placeholder="Ej: 2025/26"
                        class="input-modal w-full mb-3"
                        pattern="^\d{4}\/\d{2}$"
                        maxlength="7"
                        required>

                    <input type="date" name="fecha_inicio"
                        class="input-modal w-full mb-3">

                    <input type="date" name="fecha_fin"
                        class="input-modal w-full mb-3">

                    <label class="flex items-center gap-2 mb-4">
                        <input type="checkbox" name="activa" value="1" class="accent-indigo-600">
                        Temporada activa
                    </label>

                    <div class="flex justify-end gap-2">
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

        <!-- MODAL EDITAR TEMPORADA -->
        <div
            x-data="{ open:false, temporada:{} }"
            x-on:open-edit-temporada.window="
                open = true;
                temporada = $event.detail;
            "
            x-show="open"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center">

            <!-- OVERLAY -->
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="open=false"></div>

            <!-- MODAL -->
            <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 w-full max-w-md">

                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-800 dark:text-white">
                        Editar temporada<i class="fa-solid fa-table-list ml-2"></i>
                    </h2>

                    <button @click="open=false"
                        class="text-gray-400 hover:text-red-600 transition">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form :action="`/panel/instructor/temporadas/${temporada.id}`"
                    method="POST">
                    @csrf
                    @method('PUT')

                    <input type="text" name="nombre"
                        x-model="temporada.nombre"
                        class="input-modal w-full mb-3">

                    <input type="date" name="fecha_inicio"
                        x-model="temporada.fecha_inicio"
                        class="input-modal w-full mb-3">

                    <input type="date" name="fecha_fin"
                        x-model="temporada.fecha_fin"
                        class="input-modal w-full mb-3">

                    <label class="flex items-center gap-2 mb-4">
                        <input type="checkbox"
                            name="activa"
                            value="1"
                            :checked="temporada.activa == 1"
                            class="accent-indigo-600">
                        Temporada activa
                    </label>

                    <div class="flex justify-end gap-2">
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

        <!-- MODAL EDITAR EQUIPO -->
        <div
            x-data="{ open:false, equipo:{} }"
            x-on:open-edit-equipo.window="
                open = true;
                equipo = $event.detail;
            "
            x-show="open"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center">

            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="open=false"></div>

            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-[92%] sm:w-full max-w-md p-6">

                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-bold text-gray-800 dark:text-white">
                        Editar equipo<i class="fa-solid fa-people-group ml-2"></i>
                    </h2>

                    <button @click="open=false"
                        class="text-gray-400 hover:text-red-600 transition">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form :action="`/panel/instructor/equipos/${equipo.id}`"
                    method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="text" name="nombre" x-model="equipo.nombre" class="input-modal mb-2">
                    <input type="text" name="descripcion" x-model="equipo.descripcion" class="input-modal mb-2">
                    <input type="text" name="localizacion" x-model="equipo.localizacion" class="input-modal mb-2">
                    <input type="text" name="entrenador" x-model="equipo.entrenador" class="input-modal mb-2">

                    <!-- ESCUDO -->
                    <div class="flex items-center gap-4">

                        <!-- PREVIEW -->
                        <img
                            :src="equipo.escudo
                                ? (equipo.escudo.startsWith('http')
                                    ? equipo.escudo
                                    : '/storage/' + equipo.escudo)
                                : '/images/default.png'"
                            class="w-20 h-20 rounded-xl object-contain border border-gray-300 dark:border-gray-600 shadow-sm p-1">

                        <!-- INPUT -->
                        <input type="file"
                            name="escudo"
                            class="input-modal cursor-pointer flex-1">

                    </div>

                    <div class="flex justify-end gap-2">
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

</x-layout>