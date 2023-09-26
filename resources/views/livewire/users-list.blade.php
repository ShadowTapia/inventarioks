<x-fondo-card>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="content">
        <x-notification />
        <x-a-button href="{{ route('user.create') }}" class="p-1 bg-green-800 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-600">Crear</x-a-button>
        <div>
            <div class="flex mt-1">
                <div>
                    <x-input id="name" type="text" placeholder="Ingrese nombre o email" name="name" wire:model.live="name" wire:keydown.enter="$refresh" class="w-full mt-1"/>
                </div>

                <x-secondary-button wire:click="cleanFilter" class="ml-2 p-filter-button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                      </svg>
                </x-secondary-button>
            </div>

            <table class="w-full mt-3 table-auto">
                <thead class="bg-sky-900">
                    <tr>
                        @foreach ($columns as $c)
                            <th class="p-3 border" wire:click="sort('{{ $c }}')">
                                <button>
                                    {{ $c }}
                                    @if ($sortColumn == $c)
                                        @if ($sortDirection == 'asc'):
                                            &uarr;
                                        @else
                                            &darr;
                                        @endif
                                    @endif
                                </button>
                            </th>
                        @endforeach
                        <th class="p-3 border">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $u)
                        <tr>
                            <td class="p-3 border">{{ $u->id }}</td>
                            <td class="p-3 border">{{ $u->name }}</td>
                            <td class="p-3 border">{{ $u->email }}</td>
                            <td class="flex justify-center p-3 border">
                                <x-a-button class="mr-2 p-sm-button bg-violet-800 hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-violet-600" href="{{ route('user.edit',$u) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    Editar
                                </x-a-button>
                                <x-danger-button id="delButton" title="Eliminar Usuario" class="p-sm-button" wire:click="confirmUserDeletion({{ $u->id }})" wire:loading.attr="disabled">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                    </svg>
                                    Eliminar
                                </x-danger-button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <p>No existen registros</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <br>
            {{ $users->links() }}
        </div>
        <!-- Delete User Confirmation Modal -->
    <x-dialog-modal wire:model.live="confirmingUserDeletion">
        <x-slot name="title">
            {{ __('Borrar Usuario') }}
        </x-slot>

        <x-slot name="content">
            {{ __('¿Desea eliminar este Usuario del Sistema?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingUserDeletion',false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="delUser({{ $confirmingUserDeletion }})" wire:loading.attr="disabled">
                {{ __('Borrar Usuario') }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>

    </x-slot>
</x-fondo-card>
