<x-action-section>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="description">
        {{ __('Se encarga de ingresar un nuevo Departamento.') }}
    </x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="submit">
            <!-- Nombre -->
            <div class="colspan-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Nombre Departamento *') }}"></x-label>
                <x-bladewind.input id="name" wire:model.lazy="name" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full mt-1"/>
                <x-input-error for="name" class="mt-2" />
            </div>
            <!-- Descripción -->
            <div class="colspan-6 sm:col-span-4">
                <x-label for="description" value="{{ __('Descripción') }}"/>
                <x-bladewind.textarea id="description" wire:model.lazy="description" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full mt-1" />
                <x-input-error for="description" class="mt-2" />
            </div>
            <!-- Responsable -->
            <div class="colspan-6 sm:col-span-4">
                <x-label for="responsible" value="{{ __('Responsable') }}"/>
                <x-bladewind.input id="responsible" wire:model.lazy="responsible" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full mt-1"/>
                <x-input-error for="responsible" class="mt-2" />
            </div>
            <x-bladewind.button color="purple" has_spinner="true" name="save-depa" can_submit="true" onclick="unhide('.save-depa .bw-spinner')" class="inline-flex items-center px-4 py-2 bg-lime-700 dark:bg-lime-700 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-lime-500 focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Guardar
            </x-bladewind.button>

            <div wire:loading>
                Validando datos...
            </div>
        </form>
    </x-slot>
</x-action-section>
