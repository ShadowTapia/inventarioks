<div class="p-6">
    <form id="AddUser" wire:submit="save">
        <div>
            {{-- Name --}}
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Nombre') }}" />
                <x-input id="name" type="text" class="block w-full mt-1" wire:model.lazy="name" required />
                <x-input-error for="name" class="mt-2" />
            </div>
        </div>
        <div>
            {{-- Email --}}
            <div class="col-span-6 sm:col-span-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" type="email" class="block w-full mt-1" wire:model.lazy="email" required />
                <x-input-error for="email" class="mt-2" />
            </div>
        </div>
        <div>
            {{-- Password --}}
            <div class="col-span-6 sm:col-span-4">
                <x-label for="password" value="{{ __('Contraseña') }}" />
                <x-input id="password" type="password" class="block w-full mt-1" wire:model.lazy="password" required />
                <x-input-error for="password" class="mt-2" />
            </div>
        </div>
        @if ($enableEdit)
            <!-- Roles -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="roles" value="{{ __('Roles') }}" />
                @foreach ($roles as $role)
                    <div class="flex justify-between">
                        <label for="role-{{ $role->name }}">{{ $role->name }}</label>
                        <input class="rounded form-checkbox" id="role-{{ $role->name }}" type="checkbox"
                            value="{{ $role->id }}" wire:model.lazy="userRoles" />
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100 dark:bg-gray-800">
            <x-secondary-button wire:click="saveUser()" wire:loading.attr="disabled">
                {{ __('Guardar') }}
            </x-secondary-button>
        </div>


    </form>
</div>
