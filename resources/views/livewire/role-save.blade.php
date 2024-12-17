<x-action-section>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="description">
        {{ __('Se encarga de ingresar un nuevo Rol de Usuario.') }}
    </x-slot>
    <x-slot name="content">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form wire:submit.prevent="submit">
            <div class="colspan-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Nombre') }}" />
                <x-bladewind.input id="name" wire:model.lazy="name" required="true" prefix="user"
                    prefix_is_icon="true"
                    class="block w-full mt-1 text-gray-700 bg-white border-gray-300 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-500" />
                <x-input-error for="name" class="mt-2" />
            </div>
            <!--- Permisos -->
            <h2 class="h3">Lista de Permisos</h2>
            @foreach ($permissions as $permiso)
                <div class="flex justify-between">
                    <label for="permiso-{{ $permiso->description }}">{{ $permiso->orden }}.-
                        {{ $permiso->description }}</label>
                    <input class="rounded form-checkbox" id="permiso-{{ $permiso->description }}" type="checkbox"
                        value="{{ $permiso->id }}" wire:model.lazy="userPermissions" />
                </div>
            @endforeach

            <div wire:loading>
                Validando datos...
            </div>

            <x-bladewind.button color="purple" has_spinner="true" name="save-rol" can_submit="true"
                class="px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition ease-in-out border shadow-lg shadow-purple-500/50 focus:ring-offset-2">
                {{ __('Guardar') }}
            </x-bladewind.button>
        </form>
    </x-slot>
</x-action-section>
