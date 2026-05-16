@php
    // Definimos los estilos según el tipo
    switch ($type) {
        case 'success':
            $border = 'border-green-500 dark:border-green-400';
            $icon = 'fa-check-circle text-green-500 dark:text-green-400';
            break;
        case 'info':
            // Amarillo "apagado" (amber o yellow 500/400)
            $border = 'border-amber-500 dark:border-amber-400';
            $icon = 'fa-circle-info text-amber-500 dark:text-amber-400';
            break;
        case 'error':
        default:
            $border = 'border-red-500 dark:border-red-400';
            $icon = 'fa-circle-xmark text-red-500 dark:text-red-400';
            break;
    }
@endphp

<div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
    class="fixed top-5 right-5 bg-white dark:bg-gray-800 border-l-4 {{ $border }} text-gray-800 dark:text-gray-100 px-5 py-3 rounded-lg shadow-lg dark:shadow-black/40 flex items-center gap-3 z-50">

    <i class="fas {{ $icon }} text-xl"></i>

    <span>{{ $message }}</span>

    <button @click="show = false"
        class="ml-2 text-gray-500 dark:text-gray-300 hover:text-red-600 dark:hover:text-white transition">
        <i class="fas fa-times"></i>
    </button>
</div>