{{-- Este componente utiliza el layout de invitado (x-guest-layout) --}}
<x-guest-layout>
    {{-- Mensaje informativo de seguridad --}}
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Esta es un área segura de la aplicación. Por favor, confirma tu contraseña antes de continuar.') }}
    </div>

    {{-- Formulario para re-confirmar la identidad del usuario --}}
    <form method="POST" action="{{ route('password.confirm') }}">
        {{-- Token de protección contra ataques CSRF --}}
        @csrf

        {{-- Campo único de Password --}}
        <div>
            {{-- Componente de etiqueta para el input --}}
            <x-input-label for="password" :value="__('Contraseña')" />

            {{-- Componente de input de texto configurado para passwords --}}
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            {{-- Componente para mostrar errores de validación --}}
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Contenedor alineado a la derecha para el botón de acción --}}
        <div class="flex justify-end mt-4">
            {{-- Botón principal de confirmación --}}
            <x-primary-button>
                {{ __('Confirmar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>