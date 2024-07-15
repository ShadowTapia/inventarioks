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
                <x-label for="name" value="{{ __('Nombre') }}"/>
                <x-input id="name" type="text" class="block w-full mt-1" wire:model.lazy="name" required />
                <x-input-error for="name" class="mt-2" />
            </div>
            <!--- Permisos -->
            <h2 class="h3">Lista de Permisos</h2>
            @foreach ($permissions as $permiso )
                <div class="flex justify-between">
                    <label for="permiso-{{$permiso->description}}">{{ $permiso->orden }}.-  {{$permiso->description}}</label>
                    <input class="rounded form-checkbox" id="permiso-{{$permiso->description}}" type="checkbox" value="{{$permiso->id}}" wire:model.lazy="userPermissions"/>
                </div>
            @endforeach
            <x-secondary-button class="mt-2 mr-2" type="submit">
                {{ __('Guardar') }}
            </x-secondary-button>

            <div wire:loading>
                  Validando datos...
            </div>
        </form>
    </x-slot>
</x-action-section>
