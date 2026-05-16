<x-layout>

    <div class="space-y-6 px-4 md:px-8">

        <!-- HEADER -->
        <div class="text-center md:text-start">

            <h1 class="text-2xl md:text-3xl font-bold text-gray-700 dark:text-gray-100">
                Gestión de jugadores
            </h1>

            <hr class="mt-3 border-gray-300 dark:border-gray-600">

            <p class="text-gray-500 dark:text-gray-400 text-lg mt-2 mb-8">
                Gestión de la plantilla del Riolobos C.P.
            </p>

        </div>

        <!-- FILTROS -->
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-6">

            <form method="GET"
                class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 lg:flex lg:flex-1 gap-4">

                <!-- BUSCAR -->
                <input type="text"
                    name="buscar"
                    value="{{ request('buscar') }}"
                    placeholder="Buscar jugador..."
                    class="input-modal w-full">

                <!-- POSICIÓN -->
                <div x-data="{ open:false }" class="relative w-full">

                    <select name="posicion"
                        @click="open = !open"
                        @blur="open = false"
                        class="input-modal appearance-none pr-10 w-full cursor-pointer">

                        <option value="">Todas las posiciones</option>

                        <option value="portero"
                            @selected(request('posicion')=='portero' )>
                            Portero
                        </option>

                        <option value="cierre"
                            @selected(request('posicion')=='cierre' )>
                            Cierre
                        </option>

                        <option value="ala"
                            @selected(request('posicion')=='ala' )>
                            Ala
                        </option>

                        <option value="delantero"
                            @selected(request('posicion')=='delantero' )>
                            Delantero
                        </option>

                    </select>

                    <!-- FLECHA -->
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <i class="fa-solid fa-chevron-down text-sm transition"
                            :class="{ 'rotate-180': open }"></i>
                    </div>

                </div>

                <!-- ORDEN GOLES -->
                <div x-data="{ open:false }" class="relative w-full">

                    <select name="goles"
                        @click="open = !open"
                        @blur="open = false"
                        class="input-modal appearance-none pr-10 w-full cursor-pointer">

                        <option value="">
                            Ordenar por goles
                        </option>

                        <option value="desc"
                            @selected(request('goles')=='desc' )>
                            Más goles
                        </option>

                        <option value="asc"
                            @selected(request('goles')=='asc' )>
                            Menos goles
                        </option>

                    </select>

                    <!-- FLECHA -->
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

            <!-- NUEVO -->
            <div class="w-full lg:w-auto">

                <button
                    @click="$dispatch('open-create-jugador')"
                    class="btn-primary w-full lg:w-auto whitespace-nowrap">

                    <i class="fa-solid fa-plus text-sm"></i>
                    Nuevo jugador

                </button>

            </div>

        </div>

        <!-- TABLA -->
        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">

            <table class="min-w-[980px] w-full text-xs sm:text-sm text-left">

                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap">Jugador</th>
                        <th class="px-4 py-3 whitespace-nowrap">Nacimiento</th>
                        <th class="px-4 py-3 whitespace-nowrap">Altura</th>
                        <th class="px-4 py-3 whitespace-nowrap">Goles</th>
                        <th class="px-4 py-3 whitespace-nowrap">Tarjetas</th>
                        <th class="px-4 py-3 whitespace-nowrap text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @forelse($jugadores as $jugador)

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">

                        <!-- JUGADOR -->
                        <td class="px-4 py-3 min-w-[300px]">

                            <div class="flex items-center gap-3">

                                <img src="{{ $jugador->imagen 
                                    ? asset('storage/'.$jugador->imagen) 
                                    : asset('images/default.png') }}"
                                    class="w-10 h-10 sm:w-12 sm:h-12 rounded object-contain flex-shrink-0">

                                <div>

                                    <p class="font-medium text-xs sm:text-sm md:text-base whitespace-nowrap">
                                        {{ $jugador->nombre }} {{ $jugador->apellidos }}
                                    </p>

                                    <p class="text-[11px] sm:text-xs text-gray-500 dark:text-gray-400">
                                        #{{ $jugador->dorsal }} - {{ ucfirst($jugador->posicion) }}
                                    </p>

                                </div>

                            </div>

                        </td>

                        <!-- NACIMIENTO -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($jugador->fecha_nacimiento)->format('d/m/Y') }}
                        </td>

                        <!-- ALTURA -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $jugador->altura }} m
                        </td>

                        <!-- GOLES -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $jugador->goles }}
                        </td>

                        <!-- TARJETAS -->
                        <td class="px-4 py-3 whitespace-nowrap">

                            <div class="flex items-center gap-4">

                                <!-- AMARILLAS -->
                                <div class="flex items-center gap-1">

                                    <div class="w-4 h-6 rounded-sm bg-yellow-400 border border-yellow-500 shadow-sm"></div>

                                    <span class="text-xs sm:text-sm font-medium">
                                        {{ $jugador->amarillas }}
                                    </span>

                                </div>

                                <!-- ROJAS -->
                                <div class="flex items-center gap-1 ml-2">

                                    <div class="w-4 h-6 rounded-sm bg-red-500 border border-red-600 shadow-sm"></div>

                                    <span class="text-xs sm:text-sm font-medium">
                                        {{ $jugador->rojas }}
                                    </span>

                                </div>

                            </div>

                        </td>

                        <!-- ACCIONES -->
                        <td class="px-4 py-3 text-right flex justify-end gap-1">

                            @php
                            $data = [
                            'id' => $jugador->id,
                            'nombre' => $jugador->nombre,
                            'apellidos' => $jugador->apellidos,
                            'dorsal' => $jugador->dorsal,
                            'posicion' => $jugador->posicion,
                            'fecha_nacimiento' => $jugador->fecha_nacimiento,
                            'altura' => $jugador->altura,
                            'goles' => $jugador->goles,
                            'amarillas' => $jugador->amarillas,
                            'rojas' => $jugador->rojas,
                            'imagen' => $jugador->imagen,
                            ];
                            @endphp

                            <!-- EDITAR -->
                            <button
                                @click='$dispatch("open-edit-jugador", @json($data))'
                                class="w-10 h-10 flex items-center justify-center text-indigo-600 hover:scale-105 hover:text-indigo-500 transition">

                                <i class="fa-solid fa-pen-to-square"></i>

                            </button>

                            <!-- ELIMINAR -->
                            <form id="delete-jugador-{{ $jugador->id }}"
                                method="POST"
                                action="{{ route('panel.instructor.jugadores.destroy', $jugador->id) }}">

                                @csrf
                                @method('DELETE')

                                <button type="button"
                                    @click="$dispatch('open-confirm', {
                                        title: 'Eliminar jugador',
                                        message: '¿Seguro que quieres eliminar este jugador?',
                                        action: '#delete-jugador-{{ $jugador->id }}'
                                    })"
                                    class="w-10 h-10 flex items-center justify-center text-red-600 hover:scale-105 hover:text-red-500 transition">

                                    <i class="fa-solid fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6"
                            class="text-center py-6 text-gray-500">
                            No hay jugadores
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- EDITAR JUGADOR -->
        <div
            x-data="{
                open:false,
                jugador:{},
                preview:'',

                updatePreview(event) {

                    const file = event.target.files[0];

                    if(file){
                        this.preview = URL.createObjectURL(file);
                    }
                }
            }"

                    x-on:open-edit-jugador.window="
                open = true;
                jugador = $event.detail;

                preview = jugador.imagen
                    ? '/storage/' + jugador.imagen
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
                        Editar jugador
                        <i class="fa-solid fa-user-pen ml-2"></i>
                    </h2>

                    <button @click="open=false"
                        class="hover:scale-110 hover:text-red-600 transition">

                        <i class="fa-solid fa-xmark"></i>

                    </button>

                </div>

                <!-- FORM -->
                <form :action="`/panel/instructor/jugadores/${jugador.id}`"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">

                        <input type="text"
                            name="nombre"
                            x-model="jugador.nombre"
                            class="input-modal"
                            placeholder="Nombre">

                        <input type="text"
                            name="apellidos"
                            x-model="jugador.apellidos"
                            class="input-modal"
                            placeholder="Apellidos">

                        <input type="number"
                            name="dorsal"
                            x-model="jugador.dorsal"
                            class="input-modal"
                            placeholder="Dorsal">

                        <input type="date"
                            name="fecha_nacimiento"
                            x-model="jugador.fecha_nacimiento"
                            class="input-modal cursor-text">

                        <!-- POSICIÓN -->
                        <div class="space-y-1">

                            <select name="posicion"
                                x-model="jugador.posicion"
                                class="input-modal cursor-pointer">

                                <option value="portero">Portero</option>
                                <option value="cierre">Cierre</option>
                                <option value="ala">Ala</option>
                                <option value="delantero">Delantero</option>

                            </select>

                        </div>

                        <input type="number"
                            step="0.01"
                            name="altura"
                            x-model="jugador.altura"
                            class="input-modal"
                            placeholder="Altura">

                        <!-- GOLES -->
                        <div class="relative">

                            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 bg-white dark:bg-gray-800">
                                <i class="fa-solid fa-futbol text-sm"></i>
                            </div>

                            <input type="number"
                                name="goles"
                                x-model="jugador.goles"
                                class="input-modal pl-10"
                                placeholder="Goles">

                        </div>

                        <!-- AMARILLAS -->
                        <div class="relative">

                            <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                <div class="w-4 h-6 rounded-sm bg-yellow-400 border border-yellow-500 shadow-sm"></div>
                            </div>

                            <input type="number"
                                name="amarillas"
                                x-model="jugador.amarillas"
                                class="input-modal pl-10"
                                placeholder="Amarillas">

                        </div>

                        <!-- ROJAS -->
                        <div class="relative">

                            <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                <div class="w-4 h-6 rounded-sm bg-red-500 border border-red-600 shadow-sm"></div>
                            </div>

                            <input type="number"
                                name="rojas"
                                x-model="jugador.rojas"
                                class="input-modal pl-10"
                                placeholder="Rojas">

                        </div>

                    </div>

                    <!-- IMAGEN -->
                    <div class="flex items-center gap-4 mt-4">

                        <img :src="preview"
                            class="w-20 h-20 rounded-xl object-cover border border-gray-300 dark:border-gray-600 shadow-sm p-1">

                        <input type="file"
                            name="imagen"
                            @change="updatePreview($event)"
                            class="input-modal cursor-pointer flex-1">

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

        <!-- CREAR JUGADOR -->
        <div
            x-data="{
                open:false,
                preview:null,

                updatePreview(event) {

                    const file = event.target.files[0];

                    if(file){
                        this.preview = URL.createObjectURL(file);
                    }
                }
            }"

            x-on:open-create-jugador.window="open=true;preview=null"
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
                        Nuevo jugador
                        <i class="fa-solid fa-user-plus ml-2"></i>
                    </h2>

                    <button @click="open=false"
                        class="hover:scale-110 hover:text-red-600 transition">

                        <i class="fa-solid fa-xmark"></i>

                    </button>

                </div>

                <!-- FORM -->
                <form action="{{ route('panel.instructor.jugadores.store') }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">

                        <input type="text"
                            name="nombre"
                            required
                            class="input-modal"
                            placeholder="Nombre">

                        <input type="text"
                            name="apellidos"
                            required
                            class="input-modal"
                            placeholder="Apellidos">

                        <input type="number"
                            name="dorsal"
                            required
                            class="input-modal"
                            placeholder="Dorsal">

                        <input type="date"
                            name="fecha_nacimiento"
                            required
                            class="input-modal">

                        <select name="posicion"
                            required
                            class="input-modal cursor-pointer">

                            <option value="">Seleccionar posición</option>
                            <option value="portero">Portero</option>
                            <option value="cierre">Cierre</option>
                            <option value="ala">Ala</option>
                            <option value="delantero">Delantero</option>

                        </select>

                        <input type="number"
                            step="0.01"
                            name="altura"
                            required
                            class="input-modal"
                            placeholder="Altura">

                        <!-- GOLES -->
                        <div class="relative">

                            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 bg-white dark:bg-gray-800">
                                <i class="fa-solid fa-futbol text-sm"></i>
                            </div>

                            <input type="number"
                                name="goles"
                                value="0"
                                class="input-modal pl-10"
                                placeholder="Goles">

                        </div>

                        <!-- AMARILLAS -->
                        <div class="relative">

                            <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                <div class="w-4 h-6 rounded-sm bg-yellow-400 border border-yellow-500 shadow-sm"></div>
                            </div>

                            <input type="number"
                                name="amarillas"
                                value="0"
                                class="input-modal pl-10"
                                placeholder="Amarillas">

                        </div>

                        <!-- ROJAS -->
                        <div class="relative">

                            <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                <div class="w-4 h-6 rounded-sm bg-red-500 border border-red-600 shadow-sm"></div>
                            </div>

                            <input type="number"
                                name="rojas"
                                value="0"
                                class="input-modal pl-10"
                                placeholder="Rojas">

                        </div>

                    </div>

                    <!-- IMAGEN -->
                    <div class="flex items-center gap-4 mt-4">

                        <template x-if="preview">
                            <img :src="preview"
                                class="w-20 h-20 rounded-xl object-cover border border-gray-300 dark:border-gray-600 shadow-sm p-1">
                        </template>

                        <input type="file"
                            name="imagen"
                            @change="updatePreview($event)"
                            class="input-modal cursor-pointer flex-1">

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
            {{ $jugadores->withQueryString()->links() }}
        </div>

    </div>

</x-layout>