
            <table class="w-full mt-3 table-auto border-black" style="border:1px solid black">
                <caption class="caption-top">
                    <h1>Listado de Productos</h1>
                </caption>
                <thead class="border-black border-2" style="border:1px solid black">
                    <tr>
                        <td class="p-3"><strong>Nombre</strong></td>
                        <td class="p-3"><strong>Descripción</strong></td>
                        <td class="p-3"><strong>Modelo</strong></td>
                        <td class="p-3"><strong>Tipo Producto</strong></td>
                        <td class="p-3"><strong>Proveedor</strong></td>
                        <td class="p-3"><strong>Empresa</strong></td>
                    </tr>
                </thead>
                <tbody>
                    @if ($prtlist->count())
                        @foreach ($prtlist as $prt )
                            <tr class="border" style="border:1px solid black">
                                <td class="p-3" style="border-top: 1px solid black">{{ $prt->name }}</td>
                                <td class="p-3" style="border-top: 1px solid black">{{ $prt->description }}</td>
                                <td class="p-3" style="border-top: 1px solid black">{{ $prt->modelo }}</td>
                                <td class="p-3" style="border-top: 1px solid black">{{ $prt->productypes->name }}</td>
                                <td class="p-3" style="border-top: 1px solid black">{{ $prt->suppliers->name }}</td>
                                <td class="p-3" style="border-top: 1px solid black">{{ $prt->companies->name }}</td>
                            </tr>
                        @endforeach
                    @else
                        <div class="card-body">
                            <strong>No existen registros</strong>
                        </div>
                    @endif
                </tbody>
            </table>

