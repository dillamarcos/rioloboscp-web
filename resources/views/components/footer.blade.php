<footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 mt-10 transition-colors duration-300">
    <div class="w-full px-2 md:px-6 lg:px-10 py-6 flex flex-col lg:flex-row items-center justify-between gap-4">

        <!-- IZQUIERDA -->
        <div class="flex items-center gap-4">

            <!-- REDES -->
            <div class="flex items-center gap-4 text-gray-700 dark:text-gray-300">

                <a href="https://www.instagram.com/c.p.riolobos/" target="_blank" class="hover:text-pink-500 hover:scale-110 transition text-2xl">
                    <i class="fa-brands fa-instagram"></i>
                </a>

                <a href="https://www.tiktok.com/@riolobosc.p" target="_blank" class="hover:text-black dark:hover:text-white hover:scale-110 transition text-2xl">
                    <i class="fa-brands fa-tiktok"></i>
                </a>

                <a href="https://www.youtube.com/@C.pRiolobos" target="_blank" class="hover:text-red-600 hover:scale-110 transition text-2xl">
                    <i class="fa-brands fa-youtube"></i>
                </a>

            </div>

            <span class="text-gray-400 dark:text-gray-500">•</span>

            <!-- CONTACTO -->
            <a href="{{ route('contacto') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition font-medium">
                Contáctenos
            </a>

            <span class="text-gray-400 dark:text-gray-500">•</span>

            <!-- MODO OSCURO -->
            <div class="flex items-center gap-3">

                <span class="text-sm text-gray-600 dark:text-gray-300 font-medium">
                    Modo oscuro
                </span>

                <button @click="darkMode = !darkMode; localStorage.setItem('dark', darkMode); document.documentElement.classList.toggle('dark', darkMode);"
                    class="relative mt-1 w-12 h-6 flex items-center bg-gray-300 dark:bg-gray-700 rounded-full transition shadow-inner">

                    <!-- CÍRCULO -->
                    <div class="w-6 h-6 bg-white dark:bg-gray-200 border border-gray-300 dark:border-gray-600 rounded-full shadow-lg flex items-center justify-center text-xs transform transition"
                        :class="darkMode ? 'translate-x-6' : 'translate-x-0'">

                        <i :class="darkMode 
                            ? 'fa-solid fa-moon text-gray-700' 
                            : 'fa-solid fa-sun text-yellow-500'">
                        </i>

                    </div>

                </button>

            </div>

        </div>

        <!-- CENTRO -->
        <div class="text-xs text-gray-500 dark:text-gray-400 flex flex-wrap justify-center gap-2 text-center">

            <a href="#" class="hover:text-gray-700 dark:hover:text-gray-200 transition">Aviso legal</a>
            <span>·</span>

            <a href="#" class="hover:text-gray-700 dark:hover:text-gray-200 transition">Política de privacidad</a>
            <span>·</span>

            <a href="#" class="hover:text-gray-700 dark:hover:text-gray-200 transition">Política de cookies</a>

        </div>

        <!-- DERECHA -->
        <div class="text-xs text-gray-500 dark:text-gray-400 text-center lg:text-right">

            <p class="font-medium text-gray-600 dark:text-gray-300">
                Riolobos CP © {{ date('Y') }} Todos los derechos reservados
            </p>

            <p class="mt-1 text-gray-400 dark:text-gray-500">
                Canal de información · riolobos.com
            </p>

        </div>

    </div>
</footer>