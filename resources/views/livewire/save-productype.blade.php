<x-action-section>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="description">
        {{ __('Se encarga de ingresar un nuevo tipo de producto.') }}
    </x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="submit">
            {{-- nombre --}}
            <div class="colspan-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Nombre Tipo de Producto *') }}"></x-label>
                <x-bladewind.input id="name" wire:model.lazy="name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"/>
                <x-input-error for="name" class="mt-2" />
            </div>
            {{-- Descripción --}}
            <div class="colspan-6 sm:col-span-4">
                <x-label for="description" value="{{ __('Descripción') }}"></x-label>
                <x-bladewind.textarea id="description" wire:model.lazy="description" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"/>
                <x-input-error for="description" class="mt-2"/>
            </div>
            {{-- Botón guardar --}}
            <x-bladewind.button
                color="purple"
                name="save-prtype"
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

