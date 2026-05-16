<x-layout>

    <div class="space-y-6 px-4 md:px-8">

        <div class="text-center md:text-start">

            <!-- TÍTULO -->
            <h1 class="text-2xl md:text-3xl font-bold text-gray-700 dark:text-gray-100">
                Gestión de socios
            </h1>

            <hr class="mt-3 border-gray-300 dark:border-gray-600">

            <p class="text-gray-500 dark:text-gray-400 text-lg mt-2 mb-8">
                Gestión de la lista de todos los socios
            </p>

        </div>

        <!-- FILTROS -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

            <form method="GET" class="flex flex-col md:flex-row gap-4 w-full">

                <!-- BUSCADOR -->
                <input type="text" name="buscar"
                    value="{{ request('buscar') }}"
                    placeholder="Buscar por nombre o DNI..."
                    class="w-full md:w-64 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 
                    bg-white dark:bg-gray-800 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">

                <!-- ESTADO -->
                <div x-data="{ open: false }" class="relative w-full md:w-48">

                    <select name="estado"
                        @click="open = !open"
                        @blur="open = false"
                        class="appearance-none w-full px-4 pr-10 py-2 rounded-lg border border-gray-300 dark:border-gray-700 
                        bg-white dark:bg-gray-800 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 cursor-pointer">

                        <option value="">Todos los estados</option>
                        <option value="activo" @selected(request('estado')=='activo' )>Activo</option>
                        <option value="inactivo" @selected(request('estado')=='inactivo' )>Inactivo</option>

                    </select>

                    <!-- FLECHA -->
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <i class="fa-solid fa-chevron-down text-sm transition-transform duration-200"
                            :class="{ 'rotate-180': open }"></i>
                    </div>

                </div>

                <!-- CANCELADO -->
                <div x-data="{ open: false }" class="relative w-full md:w-48">

                    <select name="cancelado"
                        @click="open = !open"
                        @blur="open = false"
                        class="appearance-none w-full px-4 pr-10 py-2 rounded-lg border border-gray-300 dark:border-gray-700 
                        bg-white dark:bg-gray-800 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 cursor-pointer">

                        <option value="">Cancelación</option>
                        <option value="0" @selected(request('cancelado')==='0' )>No cancelado</option>
                        <option value="1" @selected(request('cancelado')==='1' )>Cancelado</option>

                    </select>

                    <!-- FLECHA -->
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <i class="fa-solid fa-chevron-down text-sm transition-transform duration-200"
                            :class="{ 'rotate-180': open }"></i>
                    </div>

                </div>

                <!-- BOTÓN -->
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg 
                    hover:bg-indigo-500 hover:scale-105 active:scale-95 transition">
                    Filtrar
                </button>

            </form>

            <!-- BOTÓN NUEVO -->
            <button
                @click="$dispatch('open-create-socio')"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg 
                hover:bg-indigo-500 hover:scale-105 active:scale-95 transition whitespace-nowrap">
                <i class="fa-solid fa-plus text-sm"></i>
                Nuevo socio
            </button>

        </div>

        <!-- TABLA -->
        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">

            <table class="w-full text-sm text-left">

                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3">Socio</th>
                        <th class="px-4 py-3">DNI</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3">Cancelado</th>
                        <th class="px-4 py-3">Cuota</th>
                        <th class="px-4 py-3">Alta</th>
                        <th class="px-4 py-3">Fin</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @forelse($socios as $socio)

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">

                        <!-- SOCIO -->
                        <td class="px-4 py-3 font-medium whitespace-nowrap">
                            {{ $socio->user->nombre }} {{ $socio->user->apellidos }}
                        </td>

                        <!-- DNI -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $socio->dni }}
                        </td>

                        <!-- ESTADO -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded
                                {{ $socio->estado === 'activo' ? 'bg-green-200 dark:bg-green-900 text-green-600 dark:text-green-400' : 'bg-red-200 dark:bg-red-900 text-red-600 dark:text-red-400' }}">
                                {{ ucfirst($socio->estado) }}
                            </span>
                        </td>

                        <!-- CANCELADO -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded
                                {{ $socio->cancelado ? 'bg-red-200 dark:bg-red-900 text-red-600 dark:text-red-400' : 'bg-green-200 dark:bg-green-900 text-green-600 dark:text-green-400' }}">
                                {{ $socio->cancelado ? 'Sí' : 'No' }}
                            </span>
                        </td>

                        <!-- CUOTA -->
                        <td class="px-4 py-3 font-semibold whitespace-nowrap">
                            {{ $socio->cuota }} €
                        </td>

                        <!-- FECHAS -->
                        <td class="px-4 py-3 text-xs md:text-sm whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($socio->fecha_alta)->format('d/m/Y') }}
                        </td>

                        <td class="px-4 py-3 text-xs md:text-sm whitespace-nowrap">
                            {{ $socio->fecha_fin ? \Carbon\Carbon::parse($socio->fecha_fin)->format('d/m/Y') : '-' }}
                        </td>

                        <td class="px-4 py-3 text-right flex justify-end gap-1">

                            <!-- EDITAR -->
                            <button type="button"
                                @click="$dispatch('open-edit-socio', {
                                    id: {{ $socio->id }},
                                    nombre: '{{ $socio->user->nombre }}',
                                    apellidos: '{{ $socio->user->apellidos }}',
                                    dni: '{{ $socio->dni }}',
                                    estado: '{{ $socio->estado }}',
                                    cuota: '{{ $socio->cuota }}',
                                    cancelado: '{{ $socio->cancelado }}'
                                })"
                                class="w-10 h-10 flex items-center justify-center text-indigo-600 hover:scale-105 hover:text-indigo-500 transition">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>

                            <!-- ELIMINAR -->
                            <form id="delete-socio-{{ $socio->id }}" method="POST"
                                action="{{ route('panel.instructor.socios.destroy', $socio->id) }}">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                    @click="$dispatch('open-confirm', {
                                        title: 'Eliminar socio',
                                        message: '¿Seguro que quieres eliminar este socio?',
                                        action: '#delete-socio-{{ $socio->id }}'
                                    })"
                                    class="w-10 h-10 flex items-center justify-center text-red-600 hover:scale-105 hover:text-red-500 transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">
                            No hay socios
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

            <!-- EDITAR SOCIO -->
            <div
                x-data="{ open:false, socio:{} }"
                x-on:open-edit-socio.window="
                    open = true;
                    socio = $event.detail;
                "
                x-show="open"
                class="fixed inset-0 z-50 flex items-center justify-center"
                style="display:none;">

                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="open=false"></div>

                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl
                        w-[92%] sm:w-full max-w-sm sm:max-w-md md:max-w-lg p-4 sm:p-6 border border-gray-200 dark:border-gray-700 max-h-[90vh] overflow-y-auto">

                    <h2 class="text-base sm:text-lg md:text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Editar socio<i class="fa-solid fa-user-group ml-2"></i></h2>

                    <form :action="`/panel/instructor/socios/${socio.id}`" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">

                            <input type="text" name="nombre" x-model="socio.nombre"
                                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100
                                        placeholder-gray-400 dark:placeholder-gray-500 shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 transition duration-200">

                            <input type="text" name="apellidos" x-model="socio.apellidos"
                                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100
                                        placeholder-gray-400 dark:placeholder-gray-500 shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 transition duration-200">

                            <input type="text" name="dni" x-model="socio.dni"
                                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100
                                        placeholder-gray-400 dark:placeholder-gray-500 shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 transition duration-200">

                            <!-- ESTADO -->
                            <select name="estado" x-model="socio.estado"
                                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100
                                        placeholder-gray-400 dark:placeholder-gray-500 shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 transition duration-200 cursor-pointer">
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>

                            <!-- CANCELADO -->
                            <select name="cancelado" x-model="socio.cancelado"
                                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100
                                        placeholder-gray-400 dark:placeholder-gray-500 shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 transition duration-200 cursor-pointer">
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>

                        </div>

                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" @click="open=false"
                                class="px-3 sm:px-4 py-2 text-sm sm:text-base bg-red-600 text-white rounded-lg hover:bg-red-500 hover:scale-105 active:scale-95 transition">
                                Cancelar
                            </button>

                            <button type="submit"
                                class="px-3 sm:px-4 py-2 text-sm sm:text-base bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 hover:scale-105 active:scale-95 transition">
                                Guardar
                            </button>
                        </div>

                    </form>

                </div>
            </div>

            <!-- CREAR SOCIO -->
            <div
                x-data="{ open:false }"
                x-on:open-create-socio.window="open=true"
                x-show="open"
                class="fixed inset-0 z-50 flex items-center justify-center"
                style="display:none;">

                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="open=false"></div>

                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl
                        w-[92%] sm:w-full max-w-sm sm:max-w-md md:max-w-lg p-4 sm:p-6 border border-gray-200 dark:border-gray-700 max-h-[90vh] overflow-y-auto">

                    <h2 class="text-lg font-bold mb-4">Nuevo socio<i class="fa-solid fa-user-group ml-2"></i></h2>

                    <form action="{{ route('panel.instructor.socios.store') }}" method="POST">
                        @csrf

                        <div class="space-y-4">

                            <input type="text" name="nombre" placeholder="Nombre"
                                required class="w-full px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100
                                        placeholder-gray-400 dark:placeholder-gray-500 shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 transition duration-200">

                            <input type="text" name="apellidos" placeholder="Apellidos"
                                required class="w-full px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100
                                        placeholder-gray-400 dark:placeholder-gray-500 shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 transition duration-200">

                            <input type="email" name="email" placeholder="Email"
                                required class="w-full px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100
                                        placeholder-gray-400 dark:placeholder-gray-500 shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 transition duration-200">

                            <input type="text" name="dni" placeholder="DNI"
                                required class="w-full px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100
                                        placeholder-gray-400 dark:placeholder-gray-500 shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 transition duration-200">

                            <input type="text" name="telefono" placeholder="Teléfono (opcional)"
                                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100
                                        placeholder-gray-400 dark:placeholder-gray-500 shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 transition duration-200">

                            <input type="date" name="fecha_alta"
                                required
                                class="input-modal scheme-light dark:scheme-dark cursor-pointer">

                        </div>

                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" @click="open=false"
                                class="px-3 sm:px-4 py-2 text-sm sm:text-base bg-red-600 text-white rounded-lg hover:bg-red-500 hover:scale-105 active:scale-95 transition">
                                Cancelar
                            </button>

                            <button type="submit"
                                class="px-3 sm:px-4 py-2 text-sm sm:text-base bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 hover:scale-105 active:scale-95 transition">
                                Crear
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>

        <!-- PAGINACIÓN -->
        <div class="mt-6">
            {{ $socios->withQueryString()->links() }}
        </div>

    </div>

</x-layout>