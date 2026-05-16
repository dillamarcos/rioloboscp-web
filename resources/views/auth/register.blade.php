<x-guest-layout>
    <div class="w-full max-w-md mx-auto bg-white p-3">

        <h1 class="text-2xl font-bold text-center text-indigo-600">
            Crear cuenta
        </h1>

        <form method="POST" action="{{ route('register') }}" class="space-y-3">
            @csrf

            <!-- NOMBRE -->
            <div>
                <label class="block text-md text-gray-700 mb-1">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Escriba su nombre..."
                    class="w-full border border-gray-400 rounded-lg p-2 
                    focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
                @error('nombre') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- APELLIDOS -->
            <div>
                <label class="block text-md text-gray-700 mb-1">Apellidos</label>
                <input type="text" name="apellidos" value="{{ old('apellidos') }}" placeholder="Escriba sus apellidos..."
                    class="w-full border border-gray-400 rounded-lg p-2 
                    focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
                @error('apellidos') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- EMAIL -->
            <div>
                <label class="block text-md text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Escriba su email..."
                    class="w-full border border-gray-400 rounded-lg p-2 
                    focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
                @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- TELÉFONO -->
            <div>
                <label class="block text-md text-gray-700 mb-1">Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono') }}" placeholder="Escriba su teléfono..."
                    class="w-full border border-gray-400 rounded-lg p-2 
                    focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
                @error('telefono') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block text-md text-gray-700 mb-1">Contraseña</label>
                <input type="password" name="password" placeholder="Escriba su contraseña..."
                    class="w-full border border-gray-400 rounded-lg p-2 
                    focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
                @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- CONFIRM PASSWORD -->
            <div>
                <label class="block text-md text-gray-700 mb-1">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" placeholder="Confirme su contraseña..."
                    class="w-full border border-gray-400 rounded-lg p-2 
                    focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition">
            </div>

            <!-- LINK LOGIN -->
            <div class="text-start text-gray-600 mt-2 text-sm">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="text-indigo-500 hover:underline">
                    Inicia sesión
                </a>
            </div>

            <!-- BOTONES -->
            <div class="flex gap-3 mt-2">
                <a href="{{ route('home') }}"
                    class="flex-1 text-center bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 hover:scale-105 transition">
                    Volver
                </a>

                <button type="submit"
                    class="flex-1 bg-indigo-500 text-white py-2 rounded-lg hover:bg-indigo-600 hover:scale-105 transition">
                    Registrarse
                </button>
            </div>

        </form>
    </div>
</x-guest-layout>