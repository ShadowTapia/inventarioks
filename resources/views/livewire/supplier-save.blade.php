<x-action-section>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="description">
        {{ __('Se encarga de ingresar un nuevo Proveedor.') }}
    </x-slot>
    <x-slot name="content">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form wire:submit.prevent="submit">
            {{-- nombre --}}
            <div class="colspan-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Nombre Proveedor *') }}"></x-label>
                <x-bladewind.input id="name" wire:model.lazy="name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"/>
                <x-input-error for="name" class="mt-2" />
            </div>
            {{-- Dirección --}}
            <div class="colspan-6 sm:col-span-4">
                <x-label for="address" value="{{ __('Dirección Proveedor') }}"></x-label>
                <x-bladewind.input id="address" wire:model.lazy="address" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-black focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"/>
                <x-input-error for="address" class="mt-2" />
            </div>
            {{-- Contacto --}}
            <div class="colspan-6 sm:col-span-4">
                <x-label for="contact" value="{{ __('Contacto Proveedor') }}"></x-label>
                <x-bladewind.input id="contact" wire:model.lazy="contact" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"/>
                <x-input-error for="contact" class="mt-2" />
            </div>
            {{-- Email --}}
            <div class="colspan-6 sm:col-span-4">
                <x-label for="email" value="{{ __('E-mail Proveedor') }}"></x-label>
                <x-bladewind.input id="email" wire:model.lazy="email" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"/>
                <x-input-error for="email" class="mt-2" />
            </div>
            {{-- Fono --}}
            <div class="colspan-6 sm:col-span-4">
                <x-label for="phone" value="{{ __('Teléfono Proveedor') }}"></x-label>
                <x-bladewind.input id="phone" name="phone" numeric="true" wire:model.lazy="phone"  class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"/>
                <x-input-error for="phone" class="mt-2" />
            </div>
            {{-- Boton Guardar --}}
            <x-bladewind.button
                color="purple"
                name="save-supplier"
                can_submit="true"
                class="px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition ease-in-out border shadow-lg shadow-purple-500/50 focus:ring-offset-2">
                Guardar
            </x-bladewind.button>

            <div wire:loading>
                Validando datos...
            </div>
        </form>
    </x-slot>
</x-action-section>
