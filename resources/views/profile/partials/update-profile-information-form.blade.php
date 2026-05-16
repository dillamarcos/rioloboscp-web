<section x-data="imageProfile()">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- NOMBRE -->
        <div>
            <x-input-label for="nombre" value="Nombre" />
            <x-text-input id="nombre" name="nombre" type="text"
                class="mt-1 block w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600"
                :value="old('nombre', $user->nombre)" required />
        </div>

        <!-- APELLIDOS -->
        <div>
            <x-input-label for="apellidos" value="Apellidos" />
            <x-text-input id="apellidos" name="apellidos" type="text"
                class="mt-1 block w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600"
                :value="old('apellidos', $user->apellidos)" required />
        </div>

        <!-- EMAIL -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600"
                :value="old('email', $user->email)" required />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-300">
                    {{ __('Tu dirección de correo electrónico no está verificada.') }}
                </p>

                <button form="send-verification"
                    class="underline text-sm text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                    {{ __('Reenviar el correo de verificación.') }}
                </button>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600">
                    {{ __('Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <!-- FOTO PERFIL -->
        <div>
            <x-input-label for="foto_perfil" value="Foto de perfil" />
            <div class="mt-2 flex items-center gap-6">
                <div class="shrink-0">
                    <template x-if="preview || currentImage">
                        <img :src="preview ? preview : currentImage" @click="open = true" 
                            class="w-16 h-16 cursor-pointer rounded-full object-cover hover:scale-110 transition border border-gray-300 dark:border-gray-600 shadow-sm">
                    </template>
                </div>

                <div class="flex-1">
                    <input id="foto_perfil" name="foto_perfil" type="file" @change="setPreview">

                    <template x-if="currentImage && !preview">
                        <button type="button"
                            @click="$refs.deletePhotoForm.submit()"
                            class="mt-2 text-xs text-white bg-red-700 p-2 rounded-lg">
                            Eliminar imagen actual
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- TELEFONO -->
        <div class="mt-2">
            <x-input-label for="telefono" value="Teléfono" />
            <x-text-input id="telefono" name="telefono" type="text"
                class="mt-1 block w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600"
                :value="old('telefono', $user->telefono)" />
        </div>

        <div class="flex items-center mt-4 gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <form x-ref="deletePhotoForm" action="{{ route('profile.deletePhoto') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <!-- MODAL FOTO -->
    <div x-show="open" x-cloak
        class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4 sm:p-6 md:p-10" @click="open = false"
        x-transition.opacity>

        <div class="relative w-fit max-w-full flex justify-center">

            <img :src="preview ? preview : currentImage"
                class="max-w-xs sm:max-w-sm md:max-w-lg lg:max-w-2xl xl:max-w-4xl max-h-[70vh] object-contain rounded-lg shadow-xl"
                @click.stop>

            <button
                class="absolute -top-3 -right-3 bg-black/80 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-black transition shadow-md"
                @click="open = false">
                <i class="fas fa-xmark"></i>
            </button>

        </div>
    </div>
</section>

<script>
    function imageProfile() {
        return {
            preview: null,
            open: false,
            currentImage: "{{ $user->foto_perfil ? asset('storage/' . $user->foto_perfil) : '' }}",

            setPreview(event) {
                const file = event.target.files[0];
                if (file) {
                    this.preview = URL.createObjectURL(file);
                }
            }
        }
    }
</script>