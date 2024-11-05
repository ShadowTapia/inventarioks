<div class="p-6">
    <div class="text-lg font-medium text-gray-100">
        {{ $title }}
    </div>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form id="AddUser" wire:submit.prevent="submit">
        <div>
            {{-- Name --}}
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Nombre') }}" />
                <x-bladewind.input id="name" wire:model.lazy="name" required="true" prefix="user"
                    prefix_is_icon="true"
                    class="block w-full mt-1 text-gray-300 bg-gray-900 border-gray-700 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600" />
                <x-input-error for="name" class="mt-2" />
            </div>
        </div>
        <div>
            {{-- Email --}}
            <div class="col-span-6 sm:col-span-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-bladewind.input id="email" type="email" wire:model.lazy="email" required="true"
                    prefix="envelope" prefix_is_icon="true"
                    class="block w-full mt-1 text-gray-300 bg-gray-900 border-gray-700 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600" />
                <x-input-error for="email" class="mt-2" />
            </div>
        </div>
        <div>
            {{-- Password --}}
            <div class="col-span-6 sm:col-span-4">
                <x-label for="password" value="{{ __('Contraseña') }}" />
                <x-bladewind.input id="password" type="password" wire:model.lazy="password" required="true"
                    prefix="key" prefix_is_icon="true"
                    class="block w-full mt-1 text-gray-300 bg-gray-900 border-gray-700 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600" />
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
                        <input class="bg-gray-900 rounded form-checkbox" id="role-{{ $role->name }}" type="checkbox"
                            value="{{ $role->id }}" wire:model.lazy="userRoles" />
                    </div>
                @endforeach
            </div>
        @endif


        <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-800 footer">
            {{-- Boton guardar --}}
            <x-bladewind.button color="purple" has_spinner="true" name="save-user" can_submit="true"
                class="px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition ease-in-out border shadow-lg shadow-purple-500/50 focus:ring-offset-2">
                Guardar
            </x-bladewind.button>

            <div wire:loading>
                Validando datos...
            </div>
        </div>
    </form>
</div>
