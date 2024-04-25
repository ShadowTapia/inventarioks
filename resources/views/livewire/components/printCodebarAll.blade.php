<x-fondo-print>
    <x-slot name="content">
        @if ($devices->count())
            <table>
                <tbody>
                    <table>
                        $conta=0;
                        @foreach ($devices as $devi)
                            $conta++;
                            @if (($conta % 5)==0)
                                <tr>
                            @endif
                            <td class="pl-3 pr-3">
                                <div>$conta</div>
                                <div>{{ $devi->producto }}</div>
                                <div>{{ $devi->modelo }}</div>
                            </td>
                        @endforeach
                    </table>
                </tbody>
            </table>
        @else
            <div class="card-body">
                <strong>No existen registros</strong>
            </div>
        @endif
    </x-slot>
</x-fondo-print>
