<div
    x-data="{ open: false }"
    x-on:{{ $trigger }}.window="open = true"
    x-show="open"
    class="fixed inset-0 z-50 flex items-center justify-center"
    style="display:none;">

    <!-- OVERLAY -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"
        @click="open = false"></div>

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
        p-4 sm:p-6 border border-gray-200 dark:border-gray-700">

        <!-- HEADER -->
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base sm:text-lg font-bold text-gray-800 dark:text-white">
                {{ $title }}
            </h2>

            <button @click="open = false"
                class="w-8 h-8 flex items-center justify-center rounded-full hover:scale-110 transition">
                <i class="fa-solid fa-xmark text-gray-600 dark:text-gray-300"></i>
            </button>
        </div>

        <!-- CONTENIDO -->
        <div class="text-sm sm:text-base">
            {{ $slot }}
        </div>

    </div>
</div>