<x-guest-layout>




  
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

  @push('styles')
    <style>
        /* Aplicamos el fondo solo al contenedor de esta página */
        #guest-container {
            background-image: url('{{ asset('img/imagen3.jpg') }}') !important;
            background-size: cover;
            background-position: center;
        }

        /* Estilo de cristal solo para el formulario de login */
        .custom-glass {
            background: rgba(255, 255, 255, 0.15) !important; 
            backdrop-filter: blur(12px) !important;
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
            color: white !important;
        }

        /* Estilos para inputs específicos de esta página */
        .custom-glass input {
            background: rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
        }
        .custom-glass label {
    color: #ffffff !important; /* Blanco puro */
    /* O puedes usar #e0f2fe si prefieres un azul muy clarito */
    font-weight: 600;
}

/* Color para el texto de "Olvidaste tu contraseña" o "Recuérdame" */
.custom-glass a, .custom-glass span {
    color: #f3f4f6 !important;
}
    </style>
    @endpush

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
    <x-input-label for="usuario_login" :value="__('Usuario')" />
    <x-text-input 
        id="usuario_login" 
        class="block mt-1 w-full" 
        type="text" 
        name="usuario_login" 
        :value="old('usuario_login')" 
        required 
        autofocus 
        autocomplete="username" 
    />
    <x-input-error :messages="$errors->get('usuario_login')" class="mt-2" />
</div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
