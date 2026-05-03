<x-guest-layout>
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
        .custom-glass select {
    background: rgba(255, 255, 255, 0.1) !important;
    color: white !important;
    border: 1px solid rgba(255, 255, 255, 0.3) !important;
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

    @if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="cedula_persona" :value="__('Número de Identificación')" />
            <x-text-input id="cedula_persona" class="block mt-1 w-full" type="text" name="cedula_persona" :value="old('cedula_persona')" required autofocus />
            <x-input-error :messages="$errors->get('cedula_persona')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="name" :value="__('Nombre Completo')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="direccion" :value="__('Dirección')" />
            <x-text-input id="direccion" class="block mt-1 w-full" type="text" name="direccion" :value="old('direccion')" required />
            <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="telefono" :value="__('Teléfono')" />
            <x-text-input id="telefono" class="block mt-1 w-full" type="tel" name="telefono" :value="old('telefono')" required />
            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>


        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
         <div class="mt-4">
    <x-input-label for="tipo_cuenta" :value="__('Tipo de cuenta')" />

    <select id="tipo_cuenta" name="tipo_cuenta"
        class="block mt-1 w-full rounded-md shadow-sm custom-glass focus:border-indigo-500 focus:ring-indigo-500">
        
        <option value="" disabled selected>Seleccione...</option>
        <option value="usuario" {{ old('tipo_cuenta') == 'usuario' ? 'selected' : '' }}>Usuario</option>
        <option value="proveedor" {{ old('tipo_cuenta') == 'proveedor' ? 'selected' : '' }}>Proveedor</option>
    </select>

    <x-input-error :messages="$errors->get('tipo_cuenta')" class="mt-2" />
</div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('¿Ya estás registrado?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>