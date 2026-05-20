<x-layout>
    <div class="max-w-3xl mx-auto py-6 px-4 -mt-6 mb-0 lg:mb-12" x-data="{ tab: 'whatsapp' }">

        <!-- TÍTULO -->
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6">
            Contáctenos
        </h1>

        <!-- SELECTOR -->
        <div class="flex gap-4 mb-6">

            <button @click="tab = 'whatsapp'" class="px-4 py-2 rounded-lg border transition"
                :class="tab === 'whatsapp' ? 'bg-green-500 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-gray-300 dark:border-gray-600'">
                <i class="fa-brands fa-whatsapp"></i> WhatsApp
            </button>

            <button @click="tab = 'email'" class="px-4 py-2 rounded-lg border transition"
                :class="tab === 'email' ? 'bg-indigo-500 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-gray-300 dark:border-gray-600'">
                <i class="fa-solid fa-envelope"></i> Email
            </button>

        </div>

        <!-- WHATSAPP -->
        <form x-show="tab === 'whatsapp'" method="POST" action="{{ route('contacto.whatsapp') }}" target="_blank">

            @csrf

            <div class="bg-white dark:bg-gray-800 shadow dark:shadow-black/30 rounded-xl p-6 space-y-4 mb-[88px]">

                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-100">
                    Contacto por WhatsApp
                </h2>

                <!-- TELÉFONO -->
                <div>
                    <label class="text-base text-gray-600 dark:text-gray-300">Teléfono</label>
                    <input type="text" name="telefono" value="{{ auth()->user()->telefono ?? '' }}"
                        placeholder="Introduce tu número..."
                        class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-lg p-2 mt-1">
                </div>

                <!-- MENSAJE -->
                <div>
                    <label class="text-base text-gray-600 dark:text-gray-300">Mensaje</label>
                    <textarea name="mensaje" required rows="4" placeholder="Escribe tu mensaje..."
                        class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-lg p-2 mt-1"></textarea>

                    @error('mensaje')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg transition">
                    Enviar WhatsApp
                </button>

            </div>
        </form>

        <!-- EMAIL -->
        <form x-show="tab === 'email'" method="POST" action="{{ route('contacto.email') }}" class="mt-4">

            @csrf

            <div class="bg-white dark:bg-gray-800 shadow dark:shadow-black/30 rounded-xl p-6 space-y-4">

                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-100">
                    Contacto por Email
                </h2>

                <!-- EMAIL -->
                <div>
                    <label class="text-base text-gray-600 dark:text-gray-300">Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email ?? '' }}"
                        placeholder="Introduce tu email..."
                        class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-lg p-2 mt-1">
                </div>

                <!-- ASUNTO -->
                <div>
                    <label class="text-base text-gray-600 dark:text-gray-300">Asunto</label>
                    <input type="text" name="asunto" placeholder="Motivo del mensaje..."
                        class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-lg p-2 mt-1">
                </div>

                <!-- MENSAJE -->
                <div>
                    <label class="text-base text-gray-600 dark:text-gray-300">Mensaje</label>
                    <textarea name="mensaje" rows="4" placeholder="Escribe tu mensaje..."
                        class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-lg p-2 mt-1"></textarea>
                </div>

                <button class="w-full bg-indigo-500 hover:bg-indigo-600 text-white py-2 rounded-lg transition">
                    Enviar Email
                </button>

            </div>
        </form>

    </div>
</x-layout>