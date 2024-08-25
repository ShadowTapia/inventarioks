<x-confirmation-modal maxWidth="md">
    <x-slot name="title">
        {{ __('Borrar Compañía') }}
    </x-slot>

    <x-slot name="content">
        {{ __('¿Desea eliminar esta Compañía del Sistema?') }}
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:loading.attr="disabled">
            {{ __('Cancelar') }}
        </x-secondary-button>

        <x-danger-button class="ml-3" wire:loading.attr="disabled">
            {{ __('Borrar Compañía') }}
        </x-danger-button>
    </x-slot>
</x-confirmation-modal>
