<x-fondo-card>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="content">
        <x-notification/>
        @if ($devices->count())
            <table class="w-full mt-3 table-auto">
                <thead class="bg-sky-900">
                    <tr>
                        <td class="p-3 border">Serie</td>
                        <td class="p-3 border">F. Compra</td>
                        <td class="p-3 border">Comentarios</td>
                        <td class="p-3 border">Estado</td>
                        <td class="p-3 border">Producto</td>
                        <td class="p-3 border">Departamento</td>
                        <td class="p-3 border">Acción</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $dvs)
                        <tr>
                            <td class="p-3 border">{{ $dvs->numserie }}</td>
                            <td class="p-3 border">{{ \Carbon\Carbon::parse($dvs->fechacompra)->format('d/m/Y') }}</td>
                            <td class="p-3 border">{{ $dvs->comentarios }}</td>
                            <td class="p-3 border">{{ $dvs->estado == '1' ? 'Activo':'inactivo' }}</td>
                            <td class="p-3 border">{{ $dvs->product->name }}</td>
                            <td class="p-3 border">{{ $dvs->department->name }}</td>
                            <td class="p-3 border">
                                <x-a-button id="editDevice" title="Editar Dispositivo" class="mr-2 p-sm-button bg-violet-800 hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-violet-600" href="{{ route('devi.edit',$dvs->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    Editar
                                </x-a-button>
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
            {{ $devices->links() }}
        </div>
    </x-slot>
</x-fondo-card>
