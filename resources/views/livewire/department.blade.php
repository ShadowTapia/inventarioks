<x-fondo-card>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="content">
        <x-notification/>
        <x-a-button id="createdepa" title="Crear Departamento" href="{{ route('depa.create') }}" class="p-1 bg-green-800 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-600">
            Crear
        </x-a-button>
        @if ($depas->count())
        <table class="w-full mt-3 table-auto">
            <thead class="bg-sky-900">
                <tr>
                    <th class="p-3 border">ID</th>
                    <th class="p-3 border">Nombre</th>
                    <th class="p-3 border">Responsable</th>
                    <th class="p-3 border">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($depas as $depa)
                    <tr>
                        <td class="p-3 border">{{ $depa->id }}</td>
                        <td class="p-3 border">{{ $depa->name }}</td>
                        <td class="p-3 border">{{ $depa->responsible }}</td>
                        <td class="flex justify-center p-3 border">
                            <x-a-button id="editdepa" title="Editar Departamento" class="mr-2 p-sm-button bg-violet-800 hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-violet-600" href="{{ route('depa.edit',$depa) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                                Editar
                            </x-a-button>
                            <x-danger-button id="deldepa" title="Eliminar Departamento" class="p-sm-button" wire:click="confirmDepaDeletion({{ $depa->id }})" wire:loading.attr="disabled">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                </svg>
                                Eliminar
                            </x-danger-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <div class="card-body">
                <strong>No existen registros</strong>
            </div>
        @endif
        <br>
        <div class="card-footer">
            {{ $depas->links() }}
        </div>
        <!-- Delete User Confirmation Modal -->
        <x-dialog-modal wire:model.live="confirmingDepaDeletion">
                <x-slot name="title">
                    {{ __('Borrar Departamento') }}
                </x-slot>

                <x-slot name="content">
                    {{ __('¿Desea eliminar este Departamento del Sistema?') }}
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button wire:click="$toggle('confirmingDepaDeletion',false)" wire:loading.attr="disabled">
                        {{ __('Cancelar') }}
                    </x-secondary-button>

                    <x-danger-button class="ml-3" wire:click="delDepa({{ $confirmingDepaDeletion }})" wire:loading.attr="disabled">
                        {{ __('Borrar Departamento') }}
                    </x-danger-button>
                </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-fondo-card>
