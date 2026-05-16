<x-layout>

    <div class="max-w-2xl mx-auto px-4 md:px-8 space-y-8">

        <!-- TÍTULO -->
        <div class="text-center md:text-left">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-gray-100">
                Hazte socio
            </h1>

            <hr class="mt-4 border-gray-300 dark:border-gray-600">
        </div>

        <!-- CARD -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">

            <p class="text-gray-500 dark:text-gray-400 text-sm">
                Rellena el formulario para enviar tu solicitud al club
            </p>

            <form method="POST" action="{{ route('socio.solicitud.store') }}" class="space-y-5">
                @csrf

                @auth
                <div class="bg-indigo-50 dark:bg-gray-700 p-3 rounded-lg text-sm text-gray-700 dark:text-gray-200">
                    Solicitud como:
                    <b>{{ auth()->user()->nombre }} {{ auth()->user()->apellidos }}</b>
                </div>
                @endauth

                @guest
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <input type="text" name="nombre" placeholder="Nombre"
                        class="input-modern" required>

                    <input type="text" name="apellidos" placeholder="Apellidos"
                        class="input-modern" required>

                </div>

                <input type="email" name="email" placeholder="Correo electrónico"
                    class="input-modern mt-4" required>

                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <input type="password" name="password" placeholder="Contraseña"
                    class="input-modern mt-4" required>

                @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                @endguest

                <input type="text"
                    name="telefono"
                    pattern="[0-9]{9}"
                    maxlength="9"
                    inputmode="numeric"
                    title="Debe tener 9 números" placeholder="Teléfono (9 dígitos)"
                    value="{{ auth()->user()->telefono ?? old('telefono') }}"
                    class="input-modern">

                @error('telefono')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <input type="text"
                    name="dni"
                    pattern="[0-9]{8}[A-Za-z]{1}"
                    maxlength="9"
                    title="Formato: 12345678A"
                    placeholder="DNI (12345678A)"
                    class="input-modern" required>

                @error('dni')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <button type="submit"
                    class="w-full bg-indigo-700 hover:bg-indigo-600 text-white font-semibold py-3 rounded-xl transition shadow-md hover:scale-[1.02]">
                    Enviar solicitud
                </button>

            </form>

        </div>
    </div>

</x-layout>