<x-action-section>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="description">
        {{ __('Se encarga de ingresar una nueva Compañía.') }}
    </x-slot>
    <x-slot name="content">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form wire:submit.prevent="submit">
            {{-- Nombre --}}
            <div class="colspan-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Nombre Compañía *') }}" />
                <x-bladewind.input id="name" wire:model.lazy="name"
                    class="block w-full mt-1 text-gray-300 bg-gray-900 border-gray-700 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600" />
                <x-input-error for="name" class="mt-2" />
            </div>
            {{-- Descripción --}}
            <div class="colspan-6 sm:col-span-4">
                <x-label for="description" value="{{ __('Descripción') }}" />
                <x-bladewind.textarea id="description" wire:model.lazy="description"
                    class="block w-full mt-1 text-gray-300 bg-gray-900 border-gray-700 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600" />
                <x-input-error for="description" class="mt-2" />
            </div>
            {{-- URL --}}
            <div class="colspan-6 sm:col-span-4">
                <x-label for="url" value="{{ __('URL Compañía') }}" />
                <x-bladewind.input id="url" wire:model.lazy="url"
                    class="block w-full mt-1 text-gray-300 bg-gray-900 border-gray-700 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600" />
                <x-input-error for="url" class="mt-2" />
            </div>
            {{-- Teléfono --}}
            <div class="colspan-6 sm:col-span-4">
                <x-label for="phone" value="{{ __('Teléfono Compañía') }}" />
                <x-bladewind.input id="phone" wire:model.lazy="phone" numeric="true"
                    class="block w-full mt-1 text-gray-300 bg-gray-900 border-gray-700 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600" />
                <x-input-error for="phone" class="mt-2" />
            </div>
            {{-- Email --}}
            <div class="colspan-6 sm:col-span-4">
                <x-label for="email" value="{{ __('Email Compañía') }}" />
                <x-bladewind.input id="email" wire:model.lazy="email"
                    class="block w-full mt-1 text-gray-300 bg-gray-900 border-gray-700 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600" />
                <x-input-error for="email" class="mt-2" />
            </div>
            {{-- Contacto --}}
            <div class="colspan-6 sm:col-span-4">
                <x-label for="contact" value="{{ __('Contacto Compañía') }}" />
                <x-bladewind.input id="contact" wire:model.lazy="contact"
                    class="block w-full mt-1 text-gray-300 bg-gray-900 border-gray-700 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-600" />
                <x-input-error for="contact" class="mt-2" />
            </div>

            {{-- botón guardar --}}
            <x-bladewind.button color="purple" has_spinner="true" name="save-comp" can_submit="true"
                onclick="unhide('.save-comp .bw-spinner')"
                class="px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition ease-in-out border shadow-lg shadow-purple-500/50 focus:ring-offset-2">
                Guardar
            </x-bladewind.button>

            <div wire:loading>
                Validando datos...
            </div>
        </form>
    </x-slot>
</x-action-section>
