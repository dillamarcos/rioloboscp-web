<x-layout>
    <div class="max-w-4xl mx-auto py-2 px-4">

        <!-- TÍTULO -->
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6">
            Mi equipo / Suscripción
        </h1>

        <!-- CARD USUARIO -->
        <div class="bg-white dark:bg-gray-900 shadow rounded-xl p-6 mb-6 
            border border-gray-100 dark:border-gray-700">

            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">
                <i class="fas fa-user text-indigo-600 dark:text-indigo-400"></i>
                Información personal
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">
                <p><span class="font-semibold">Nombre:</span> {{ $user->nombre }}</p>
                <p><span class="font-semibold">Apellidos:</span> {{ $user->apellidos }}</p>
                <p><span class="font-semibold">Email:</span> {{ $user->email }}</p>
                <p><span class="font-semibold">Teléfono:</span> {{ $user->telefono ?? 'No disponible' }}</p>
                <p><span class="font-semibold">DNI:</span> {{ $user->socio->dni }}</p>
            </div>

            <!-- BOTÓN EDITAR -->
            <div class="-mb-2 -mr-2 -mt-8 flex justify-end">
                <a href="{{ route('profile.edit') }}" class="bg-indigo-600 text-white px-2 py-2 rounded-lg text-xs lg:text-sm
                    hover:bg-indigo-500 hover:scale-105 transition flex items-center gap-2">

                    <i class="fas fa-pen"></i>
                    Editar datos
                </a>
            </div>
        </div>

        <!-- CARD SOCIO -->
        <div class="bg-white dark:bg-gray-900 shadow rounded-xl p-6 border border-gray-100 dark:border-gray-700">

            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">
                <i class="fas fa-id-card text-indigo-600 dark:text-indigo-400"></i>
                Datos de socio
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">

                <p>
                    <span class="font-semibold">Estado:</span>
                    <span class="{{ $user->socio->estado === 'activo' ? 'text-green-600' : 'text-red-500' }} font-bold">
                        {{ ucfirst($user->socio->estado) }}
                    </span>
                </p>

                <p><span class="font-semibold">Fecha alta:</span>
                    {{ \Carbon\Carbon::parse($user->socio->fecha_alta)->format('d/m/Y') }}
                </p>

                <p><span class="font-semibold">Cuota:</span> {{ $user->socio->cuota }} €</p>                

                <p><span class="font-semibold">Fecha fin:</span>
                    {{ $user->socio->fecha_fin ? \Carbon\Carbon::parse($user->socio->fecha_fin)->format('d/m/Y') : 'Indefinida' }}
                </p>

            </div>

            <!-- ESTADO VISUAL -->
            <div class="mt-6">
                @if($user->socio->estado === 'activo')
                    <div class="bg-green-100 dark:bg-green-900/30 
                            text-green-700 dark:text-green-300 p-3 rounded-lg">
                        Tu suscripción está activa
                        <i class="fas fa-check-circle"></i>
                    </div>
                @else
                    <div class="bg-red-100 dark:bg-red-900/30 
                            text-red-700 dark:text-red-300 p-3 rounded-lg">
                        Tu suscripción está inactiva
                        <i class="fas fa-times-circle"></i>
                    </div>
                @endif
            </div>

        </div>

        <!-- CARDS EXTRA -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- INFO SUSCRIPCIÓN -->
            <div class="bg-white dark:bg-gray-900 shadow rounded-xl p-6 
                border border-gray-100 dark:border-gray-700">

                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-indigo-600 dark:text-indigo-400"></i>
                    Información de suscripción
                </h2>

                @php
                    $fechaAlta = \Carbon\Carbon::parse($user->socio->fecha_alta)->startOfDay();
                    $fechaFin = $user->socio->fecha_fin
                        ? \Carbon\Carbon::parse($user->socio->fecha_fin)->startOfDay()
                        : $fechaAlta->copy()->addYear();

                    
                    $diasRestantes = (int) now()->startOfDay()->diffInDays($fechaFin, false);

                    $diasTotal = (int) $fechaAlta->diffInDays(now());
                    $mesesTotal = (int) $fechaAlta->diffInMonths(now());

                    if ($diasTotal <= 1) {
                        $diasTotal = 1;
                    }

                    if ($mesesTotal >= 2) {
                        $tiempo = $mesesTotal . ' meses';
                    } else {
                        $tiempo = $diasTotal . ' días';
                    }
                @endphp

                <div class="space-y-2 text-gray-700 dark:text-gray-300">

                    <p>
                        <span class="font-semibold">Te quedan:</span>
                        <span class="{{ $diasRestantes > 30 ? 'text-green-600' : 'text-red-500' }} font-bold">
                            {{ $diasRestantes > 0 ? $diasRestantes . ' días' : 'Caducada' }}
                        </span>
                    </p>

                    <p>
                        <span class="font-semibold">Tiempo con nosotros:</span>
                        {{ $tiempo }}
                    </p>

                    <p>
                        <span class="font-semibold">Gracias por formar parte de nuestra comunidad</span>
                    </p>

                </div>

            </div>

            <!-- GESTIONAR SUSCRIPCIÓN -->
            <div class="bg-white dark:bg-gray-900 shadow rounded-xl p-6 flex flex-col justify-between 
                border border-gray-100 dark:border-gray-700">

                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4 flex items-center gap-2">
                    <i class="fas fa-cog text-indigo-600 dark:text-indigo-400"></i>
                    Gestionar suscripción
                </h2>

                @php
                    $fechaFin = $user->socio->fecha_fin
                        ? \Carbon\Carbon::parse($user->socio->fecha_fin)->startOfDay()
                        : \Carbon\Carbon::parse($user->socio->fecha_alta)->addYear();

                    
                    $diasRestantes = (int) now()->startOfDay()->diffInDays($fechaFin, false);
                @endphp

                @if(!$user->socio->cancelado)

                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">
                        Si cancelas la renovación automática, seguirás siendo socio durante
                        <span class="font-bold text-indigo-600 dark:text-indigo-400">
                            {{ $diasRestantes > 0 ? $diasRestantes . ' días' : 'el último día' }}
                        </span>.
                    </p>

                    <form method="POST" action="{{ route('socio.cancelar') }}">
                        @csrf

                        <button
                            type="button"
                            @click="$dispatch('open-confirm', {
                                title: 'Cancelar renovación',
                                message: '¿Seguro que quieres cancelar la renovación de tu suscripción? Si ',
                                action: '#form-cancelar-suscripcion'
                            })"
                            class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-500 transition hover:scale-105">
                            Cancelar renovación
                        </button>
                        
                    </form>

                    <form id="form-cancelar-suscripcion" method="POST" action="{{ route('socio.cancelar') }}">
                        @csrf
                    </form>

                @else

                    <div class="bg-yellow-100 dark:bg-yellow-900/30 
                            text-yellow-700 dark:text-yellow-300 p-3 rounded-lg mb-4 text-sm">

                        Has cancelado la renovación.
                        Seguirás siendo socio durante
                        <span class="font-bold">
                            {{ $diasRestantes > 0 ? $diasRestantes . ' días' : 'el último día' }}
                        </span>
                    </div>

                    <form method="POST" action="{{ route('socio.reactivar') }}">
                        @csrf

                        <button
                            class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition hover:scale-105">
                            Reactivar suscripción
                        </button>
                    </form>

                @endif

            </div>

        </div>

    </div>
</x-layout>