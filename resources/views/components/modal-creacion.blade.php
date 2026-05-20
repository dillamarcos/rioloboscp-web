<div
    x-data="{ open: false }"
    x-on:open-modal.window="open = true"
    x-on:close-modal.window="open = false"
    x-show="open"
    class="fixed inset-0 z-50 flex items-center justify-center"
    style="display: none;">

    <!-- OVERLAY -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"
        @click="open = false"></div>

    <!-- CONTENIDO -->
    <div x-transition class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg p-6">

        <!-- SLOT -->
        {{ $slot }}

    </div>

</div>