
<div>


    <div class="mt-4">
        <x-label for="name" value="{{ __('Busqueda') }}" />
        <x-input id="name" type="text" name="name"  wire:model="name" wire:keydown.enter="$refresh" class="block w-full mt-1"/>
    </div>

    <table class="w-full table-auto">
        <thead>
            <tr>
                <th class="p-3">Nombre</th>
                <th class="p-3">Email</th>
                <th class="p-3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $u)
                <tr>
                    <td class="p-3 border">{{ $u->name }}</td>
                    <td class="p-3 border">{{ $u->email }}</td>
                    <td>
                        <x-a-button class="p-1 bg-violet-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            Editar
                        </x-a-button>
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
