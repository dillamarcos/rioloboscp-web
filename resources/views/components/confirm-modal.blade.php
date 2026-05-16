<div
    x-data="{ open: false, action: null, message: '', title: '' }"
    x-on:open-confirm.window="
        open = true;
        title = $event.detail.title;
        message = $event.detail.message;
        action = $event.detail.action;
    "
    x-show="open"
    class="fixed inset-0 z-50 flex items-center justify-center"
    style="display: none;">

    <!-- FONDO -->
    <div class="absolute inset-0 bg-black/50" @click="open = false"></div>

    <!-- MODAL -->
    <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md p-6">

        <h2 class="flex justify-center text-lg font-bold text-gray-800 dark:text-gray-100 mb-2" x-text="title"></h2>

        <p class="flex justify-center text-center text-gray-600 dark:text-gray-300 text-sm mb-6" x-text="message"></p>

        <div class="flex justify-center gap-3">

            <button
                @click="open = false"
                class="px-4 py-2 rounded-lg bg-red-700 dark:bg-gray-700 text-white dark:text-gray-200 hover:opacity-80 hover:scale-105 transition">
                Cancelar
            </button>

            <button
                @click="
                    open = false;
                    if (action) document.querySelector(action).submit();
                "
                class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white hover:scale-105 transition">
                Continuar
            </button>

        </div>

    </div>
</div>