<x-action-section>
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="description">
        {{ __('Se encarga de ingresar un nuevo usuario.') }}
    </x-slot>

    <x-slot name="content">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form wire:submit.prevent="submit">
            {{-- Name --}}
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Nombre') }}" />
                <x-bladewind.input id="name" wire:model.lazy="name" required="true"
                    class="block w-full mt-1 text-gray-300 bg-gray-900 border-gray-700 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600" />
                <x-input-error for="name" class="mt-2" />
            </div>

            {{-- Email --}}
            <div class="col-span-6 sm:col-span-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-bladewind.input id="email" type="email" wire:model.lazy="email" required="true"
                    class="block w-full mt-1 text-gray-300 bg-gray-900 border-gray-700 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600" />
                <x-input-error for="email" class="mt-2" />
            </div>

            {{-- Password --}}
            <div class="col-span-6 sm:col-span-4">
                <x-label for="password" value="{{ __('Contraseña') }}" />
                <x-bladewind.input id="password" type="password" wire:model.lazy="password"
                    class="block w-full mt-1 text-gray-300 bg-gray-900 border-gray-700 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600" />
                <x-input-error for="password" class="mt-2" />
            </div>
            @if ($enableEdit)
                {{-- Roles --}}
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="roles" value="{{ __('Roles') }}" />
                    @foreach ($roles as $role)
                        <div class="flex justify-between">
                            <label for="role-{{ $role->name }}">{{ $role->name }}</label>
                            <input class="bg-gray-900 rounded form-checkbox" id="role-{{ $role->name }}"
                                type="checkbox" value="{{ $role->id }}" wire:model.lazy="userRoles" />
                        </div>
                    @endforeach
                </div>
            @endif

            <x-secondary-button class="mt-2 mr-2" type="submit">
                {{ __('Guardar') }}
            </x-secondary-button>

            <div wire:loading>
                Validando datos...
            </div>
        </form>
    </x-slot>

</x-action-section>
