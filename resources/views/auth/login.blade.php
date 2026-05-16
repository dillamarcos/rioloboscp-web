<x-guest-layout>
    <div class="w-full max-w-md mx-auto">
        <h1 class="text-2xl font-bold text-center text-indigo-600 dark:text-indigo-400 mb-6">
            Iniciar sesión
        </h1>

        @if ($errors->has('login'))
            <div class="mb-4 text-red-500 text-sm font-medium">
                {{ $errors->first('login') }}
            </div>
        @endif

        <!-- FORMULARIO -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- EMAIL -->
            <div>
                <label class="block text-md text-gray-700 dark:text-gray-200 mb-1">
                    Email
                </label>

                <input type="email" name="email" placeholder="Introduzca su email..."
                    class="w-full border border-gray-400 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg p-2 
                    focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition"
                    value="{{ old('email') }}">

                @error('email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label class="block text-md text-gray-700 dark:text-gray-200">
                        Contraseña
                    </label>

                    @if ($errors->any())
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-500 hover:underline">
                            ¿Olvidó su contraseña?
                        </a>
                    @endif
                </div>

                <input type="password" name="password" placeholder="Introduzca su contraseña..."
                    class="w-full border border-gray-400 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg p-2 
                    focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">

                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- REMEMBER -->
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember"
                        class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 accent-indigo-600 focus:ring-indigo-500 dark:bg-gray-700 cursor-pointer"
                        {{ old('remember') ? 'checked' : '' }}>

                <label for="remember" class="ml-2 text-md text-gray-700 dark:text-gray-200">
                    Mantener sesión activa
                </label>
            </div>

            <!-- REGISTER -->
            <div class="text-start text-gray-600 dark:text-gray-300 mt-2 text-sm">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}" class="text-indigo-500 hover:underline">
                    Regístrate aquí
                </a>
            </div>

            <div class="flex gap-4">
                <!-- BOTÓN VOLVER -->
                <a href="{{ url()->previous() }}"
                    class="w-full text-center bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 hover:scale-105 transition">
                    Volver
                </a>

                <!-- BOTÓN ENTRAR -->
                <button type="submit"
                    class="w-full bg-indigo-500 text-white py-2 rounded-lg hover:bg-indigo-600 hover:scale-105 transition">
                    Entrar
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>