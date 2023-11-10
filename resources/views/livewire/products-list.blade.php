<x-fondo-card>
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="content">
        <x-notification/>
        <x-a-button id="creaProducts" title="Crear Producto" href="{{ route('pro.create') }}" class="p-1 bg-green-800 hover:bg-green-600 focus:ring-offset-2 focus:ring-2 focus:ring-green-600">
            Crear
        </x-a-button>
        @if ($prtlist->count())
            <table class="w-full mt-3 table-auto">
                <thead class="bg-sky-900">
                    <tr>
                        <td class="p-3 border">Nombre</td>
                        <td class="p-3 border">Descripción</td>
                        <td class="p-3 border">Modelo</td>
                        <td class="p-3 border">Tipo Producto</td>
                        <td class="p-3 border">Proveedor</td>
                        <td class="p-3 border">Empresa</td>
                        <td class="p-3 border">Acciones</td>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($prtlist as $prt )
                        <tr>
                            <td class="p-3 border">{{ $prt->name }}</td>
                            <td class="p-3 border">{{ $prt->description }}</td>
                            <td class="p-3 border">{{ $prt->modelo }}</td>
                            <td class="p-3 border">{{ $prt->productypes->name }}</td>
                            <td class="p-3 border">{{ $prt->suppliers->name }}</td>
                            <td class="p-3 border">{{ $prt->companies->name }}</td>
                            <td class="p-3 border">
                                <x-a-button id="addDevice" title="Agregar Dispositivo" class="mr-2 p-sm-button bg-violet-800 hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-violet-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    Dispositivo
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
            {{ $prtlist->links() }}
        </div>
    </x-slot>
</x-fondo-card>
