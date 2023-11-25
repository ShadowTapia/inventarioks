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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $dvs)
                        <tr>
                            <td class="p-3 border">{{ $dvs->numserie }}</td>
                            <td class="p-3 border">{{ $dvs->fechacompra }}</td>
                            <td class="p-3 border">{{ $dvs->comentarios }}</td>
                            <td class="p-3 border">{{ $dvs->estado == '1' ? 'Activo':'inactivo' }}</td>
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
