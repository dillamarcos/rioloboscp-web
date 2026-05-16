<x-layout>

    <div class="space-y-6 px-4 md:px-8">

        <div class="text-center md:text-start">
            
            <!-- TÍTULO -->
            <h1 class="text-2xl md:text-3xl font-bold text-gray-700 dark:text-gray-100">
                Gestión de usuarios
            </h1>

            <hr class="mt-3 border-gray-300 dark:border-gray-600">

            <p class="text-gray-500 dark:text-gray-400 text-lg mt-2 mb-8">
                Gestión de la lista de todos los usuarios registrados en el sistema
            </p>
        
        </div>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

            <!-- FILTROS -->
            <form method="GET" class="flex flex-col md:flex-row gap-4 w-full">

                <!-- BUSCADOR -->
                <input type="text" name="buscar" placeholder="Buscar por nombre..."
                    value="{{ request('buscar') }}"
                    class="input-modal w-full md:w-64">

                <!-- SELECT -->
                <div x-data="{ open: false }" class="relative w-full md:w-48">

                    <select name="rol"
                        @click="open = !open"
                        @blur="open = false"
                        class="input-modal appearance-none pr-10 cursor-pointer">

                        <option value="">Todos los roles</option>
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                        <option value="usuario">Usuario</option>

                    </select>

                    <!-- FLECHA -->
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <i class="fa-solid fa-chevron-down text-sm text-gray-700 dark:text-gray-300 transition-transform duration-200"
                            :class="{ 'rotate-180': open }"></i>
                    </div>

                </div>

                <!-- BOTÓN FILTRAR -->
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg 
                hover:bg-indigo-500 hover:scale-105 active:scale-95 transition">
                    Filtrar
                </button>

            </form>

        </div>

        <!-- TABLA -->
        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">

            <table class="w-full text-sm text-left">

                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Correo</th>
                        <th class="px-4 py-3">Rol</th>
                        <th class="px-4 py-3">Registrado</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @forelse($usuarios as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">

                        <td class="px-4 py-3 font-medium whitespace-nowrap">
                            {{ $user->nombre }} {{ $user->apellidos }}
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $user->email }}
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap"
                            x-data="{ editing: false, rol: '{{ $user->rol }}' }">

                            <div class="inline-block">

                                <span class="px-2 py-1 text-xs rounded 
                                    {{ $user->rol === 'admin' ? 'bg-red-200 dark:bg-red-900 text-red-600 dark:text-red-400' : '' }}
                                    {{ $user->rol === 'editor' ? 'bg-blue-200 dark:bg-blue-900 text-blue-600 dark:text-blue-400' : '' }}
                                    {{ $user->rol === 'usuario' ? 'bg-gray-200 dark:bg-gray-900 text-gray-600 dark:text-gray-400' : '' }}">
                                    <span x-text="rol"></span>
                                </span>

                            </div>

                        </td>

                        <td class="px-4 py-3 text-xs md:text-sm">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>

                        <!-- ACCIONES -->
                        <td class="px-4 py-3 text-right flex justify-end gap-1">

                            <!-- EDITAR -->
                            <button type="button"
                                @click="$dispatch('open-edit-user', {
                                    id: {{ $user->id }},
                                    nombre: '{{ $user->nombre }}',
                                    apellidos: '{{ $user->apellidos }}',
                                    email: '{{ $user->email }}',
                                    telefono: '{{ $user->telefono }}',
                                    rol: '{{ $user->rol }}'
                                })"
                                class="w-10 h-10 flex items-center justify-center text-indigo-600 hover:scale-105 hover:text-indigo-500 transition">
                                <i class="fa-solid fa-pen-to-square text-base md:text-lg"></i>
                            </button>

                            <!-- ELIMINAR -->
                            <form id="delete-user-{{ $user->id }}" method="POST" action="{{ route('usuarios.destroy', $user->id) }}">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                    @click="$dispatch('open-confirm', {
                                        title: 'Eliminar usuario',
                                        message: '¿Seguro que quieres eliminar este usuario?',
                                        action: '#delete-user-{{ $user->id }}'
                                    })"
                                    class="w-10 h-10 flex items-center justify-center text-red-600 hover:scale-105 hover:text-red-500 transition">
                                    <i class="fa-solid fa-trash text-base md:text-lg"></i>
                                </button>
                            </form>

                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">
                            No hay usuarios
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

            <div
                x-data="{
                    open: false,
                    user: {}
                }"
                x-on:open-edit-user.window="
                    open = true;
                    user = $event.detail;
                "
                x-show="open"
                class="fixed inset-0 z-50 flex items-center justify-center"
                style="display:none;">

                <!-- OVERLAY -->
                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="open = false"></div>

                <!-- MODAL -->
                <div
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl 
                        w-[92%] sm:w-full max-w-sm sm:max-w-md md:max-w-lg 
                        p-4 sm:p-6 md:p-6 
                        border border-gray-200 dark:border-gray-700">

                    <!-- HEADER -->
                    <div class="flex items-center justify-between mb-6">

                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                            Editar usuario<i class="fa-solid fa-user ml-2"></i>
                        </h2>

                        <!-- BOTÓN CERRAR -->
                        <button
                            @click="open = false"
                            class="w-9 h-9 flex items-center justify-center rounded-full                                 
                                transition hover:scale-110 active:scale-95">
                            <i class="fa-solid fa-xmark text-gray-700 dark:text-gray-300 hover:text-red-700 dark:hover:text-red-500 "></i>
                        </button>

                    </div>

                    <!-- FORM -->
                    <form :action="`/panel/admin/usuarios/${user.id}`" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">

                            <!-- NOMBRE -->
                            <input type="text" name="nombre" x-model="user.nombre"
                                placeholder="Nombre"
                                class="w-full px-4 py-2.5 rounded-lg border 
                                    border-gray-300 dark:border-gray-700
                                    bg-white dark:bg-gray-700
                                    text-gray-800 dark:text-white
                                    placeholder-gray-400 dark:placeholder-gray-500
                                    focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500
                                    transition">

                            <!-- APELLIDOS -->
                            <input type="text" name="apellidos" x-model="user.apellidos"
                                placeholder="Apellidos"
                                class="w-full px-4 py-2.5 rounded-lg border 
                                    border-gray-300 dark:border-gray-700
                                    bg-white dark:bg-gray-700
                                    text-gray-800 dark:text-white
                                    placeholder-gray-400 dark:placeholder-gray-500
                                    focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500
                                    transition">

                            <!-- EMAIL -->
                            <input type="email" name="email" x-model="user.email"
                                placeholder="Correo electrónico"
                                class="w-full px-4 py-2.5 rounded-lg border 
                                    border-gray-300 dark:border-gray-700
                                    bg-white dark:bg-gray-700
                                    text-gray-800 dark:text-white
                                    placeholder-gray-400 dark:placeholder-gray-500
                                    focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500
                                    transition">

                            <!-- TELÉFONO -->
                            <input type="text" name="telefono" x-model="user.telefono"
                                placeholder="Teléfono"
                                class="w-full px-4 py-2.5 rounded-lg border 
                                    border-gray-300 dark:border-gray-700
                                    bg-white dark:bg-gray-700
                                    text-gray-800 dark:text-white
                                    placeholder-gray-400 dark:placeholder-gray-500
                                    focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500
                                    transition">

                            <!-- ROL -->
                            <div x-data="{ openSelect: false }" class="relative">

                                <select name="rol" x-model="user.rol"
                                    @click="openSelect = !openSelect"
                                    @blur="openSelect = false"
                                    class="appearance-none w-full px-4 pr-10 py-2.5 rounded-lg border 
                                        border-gray-300 dark:border-gray-700
                                        bg-white dark:bg-gray-700
                                        text-gray-800 dark:text-white
                                        focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500
                                        transition cursor-pointer">

                                    <option value="admin">Admin</option>
                                    <option value="editor">Editor</option>
                                    <option value="usuario">Usuario</option>

                                </select>

                                <!-- FLECHA -->
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-sm transition-transform duration-200"
                                        :class="{ 'rotate-180': openSelect }"></i>
                                </div>

                            </div>

                        </div>

                        <!-- BOTONES -->
                        <div class="flex justify-end gap-3 mt-6">

                            <!-- CANCELAR -->
                            <button type="button"
                                @click="open = false"
                                class="px-4 py-2 rounded-lg bg-red-600 text-white 
                                    hover:bg-red-500 hover:scale-105 
                                    active:scale-95 transition">
                                Cancelar
                            </button>

                            <!-- GUARDAR -->
                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-indigo-600 text-white 
                                    hover:bg-indigo-500 hover:scale-105 
                                    active:scale-95 transition">
                                Guardar
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>

        <!-- PAGINACIÓN -->
        <div class="mt-6">
            {{ $usuarios->withQueryString()->links() }}
        </div>

    </div>

</x-layout>