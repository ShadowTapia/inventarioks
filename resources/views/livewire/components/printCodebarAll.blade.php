<x-fondo-print>
    <x-slot name="content">

            <table>
                <caption class="caption-top">
                    <h1>Listado de Dispositivos</h1>
                </caption>

                <tbody>
                    @php
                        $conta=0;
                    @endphp
                    @if ($devices)
                        @foreach ($devices as $key=>$value)
                                @php
                                    $conta++;
                                @endphp
                                @php
                                    if (($conta % 3)==0) {
                                @endphp
                                <tr>
                                @php
                                    }
                                @endphp

                                    <td style="padding-right: 15px;padding-left: 15px;">
                                        <div class="grid grid-cols-1 gap-4 max-h-fit">
                                            <div class="left-8">
                                                <img id="logoks" src="{{ asset('images/kscodebar.png') }}" alt="">
                                            </div>
                                            <div>{{ $value[0] }}</div>
                                            <div>{{ $value[1] }}</div>
                                            <div><img src="data:image/png;base64, {{ $value[2] }}" alt="" class="w-3 py-0"></div>
                                        </div>

                                    </td>
                                @php
                                    if (($conta % 3)==0) {
                                @endphp
                                </tr>
                                @php
                                    }
                                @endphp

                        @endforeach
                    @else
                        <div class="card-body">
                            <strong>No existen registros</strong>
                        </div>
                    @endif
                </tbody>
            </table>

    </x-slot>
</x-fondo-print>
