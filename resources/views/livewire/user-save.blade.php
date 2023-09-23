<x-action-section>
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="description">
        {{ __('Se encarga de ingresar un nuevo usuario.') }}
    </x-slot>

    <x-slot name="content">
        <form wire:submit.prevent="submit">
            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Nombre') }}" />
                <x-input id="name" type="text" class="block w-full mt-1" wire:model="name" required />
                <x-input-error for="name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" type="email" class="block w-full mt-1" wire:model="email" required/>
                <x-input-error for="email" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="password" value="{{ __('Contraseña') }}" />
                <x-input id="password" type="password" class="block w-full mt-1" wire:model="password" required/>
                <x-input-error for="password" class="mt-2" />
            </div>

            <x-secondary-button class="mt-2 mr-2" type="submit">
                {{ __('Guardar') }}
            </x-secondary-button>

            <div wire:loading>
                  Registrando datos...
            </div>
        </form>
    </x-slot>

</x-action-section>
