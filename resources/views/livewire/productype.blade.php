<x-fondo-card>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name='content'>
        <x-notification/>
        @can('protype.create')
            <x-a-button id="createProductype" title="Crear Tipo de Producto" wire:click="confirmProtypeaddItem" class="p-1 bg-green-800 hover:bg-green-600 focus:ring-offset-2 focus:ring-2 focus:ring-green-600">
                Crear
            </x-a-button>
        @endcan

        @if ($productypes->count()) {{-- Si el arreglo trae registros --}}
            <table class="w-full mt-3 table-auto">
                <thead class="bg-sky-900">
                    <tr>
                        <th class="p-3 border">NOMBRE</th>
                        <th class="p-3 border">DESCRIPCIÓN</th>
                        <th class="p-3 border">CREADO EN</th>
                        <th class="p-3 border">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productypes as $types )
                        <tr>
                            <td class="p-3 border">{{ $types->name }}</td>
                            <td class="p-3 border">{{ $types->description }}</td>
                            <td class="p-3 border">{{ \Carbon\Carbon::parse($types->created_at)->format('d/m/Y') }}</td>
                            <td class="justify-center p-3 border w-60">
                                @can('protype.edit')
                                    <x-a-button id="editsupp" title="Editar tipo Producto" wire:click="confirmProtypeEditItem({{ $types->id }})" class="mr-2 p-sm-button bg-violet-800 hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-violet-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                        Editar
                                    </x-a-button>
                                @endcan
                                @can('protype.destroy')
                                    <x-danger-button id="delsupp" title="Eliminar tipo Producto" wire:click="confirmProtypeDeletion({{ $types->id }})" wire:loading.attr="disabled" class="p-sm-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                        </svg>
                                        Eliminar
                                    </x-danger-button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else {{-- No existen registros para mostrar --}}
            <div class="card-body">
                <strong>No existen registros</strong>
            </div>
        @endif
        <br>
        <div class="card-footer">
            {{ $productypes->links() }}
        </div>
        {{-- Agregar un nuevo tipo de producto --}}
        <x-dialog-modal wire:model.live="confirmingProtypeItemAdd">
            <x-slot name="title">
                {{ isset($this->productype->id) ? 'Actualizar Tipo Producto' : 'Crear Tipo Producto' }}
            </x-slot>

            <x-slot name="content">
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
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button  wire:click="savePrtype()" wire:loading.attr="disabled">
                    {{ __('Guardar') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="$toggle('confirmingProtypeItemAdd',false)" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
        {{-- Delete Tipo de productos Confirmation Modal --}}
        <x-confirmation-modal maxWidth="md" wire:model.live="confirmingProtypeDeletion">
            <x-slot name="title">
                {{ __('Borrar Tipo de Producto') }}
            </x-slot>

            <x-slot name="content">
                {{ __('¿Desea eliminar este tipo de producto?') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingProtypeDeletion',false)" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="delProtype({{ $confirmingProtypeDeletion }})" wire:loading.attr="disabled">
                    {{ __('Borrar Tipo de Producto') }}
                </x-danger-button>
            </x-slot>
        </x-confirmation-modal>
    </x-slot>
</x-fondo-card>
