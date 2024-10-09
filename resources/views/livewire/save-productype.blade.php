<div class="p-6">
    <div class="text-lg font-medium text-gray-100 dark:text-gray-100">
        {{ $title }}
    </div>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form wire:submit.prevent="submit">
        {{-- nombre --}}
        <div class="colspan-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Nombre Tipo de Producto *') }}"></x-label>
            <x-bladewind.input id="name" wire:model.lazy="name"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" />
            <x-input-error for="name" class="mt-2" />
        </div>
        {{-- Descripción --}}
        <div class="colspan-6 sm:col-span-4">
            <x-label for="description" value="{{ __('Descripción') }}"></x-label>
            <x-bladewind.textarea id="description" wire:model.lazy="description"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" />
            <x-input-error for="description" class="mt-2" />
        </div>
        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100 footer dark:bg-gray-800">
            {{-- Botón guardar --}}
            <x-bladewind.button color="purple" name="save-prtype" can_submit="true"
                class="px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition ease-in-out border shadow-lg shadow-purple-500/50 focus:ring-offset-2">
                Guardar
            </x-bladewind.button>
        </div>
        <div wire:loading>
            Guardando...
        </div>
    </form>
</div>
