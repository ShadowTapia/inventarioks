<x-fondo-print>
    <x-slot name="content">
        <div class="grid grid-cols-1 gap-4 max-h-fit">
            <div class="left-8">
                <img id="logoks" src="{{ asset('images/kscodebar.png') }}" alt="">
            </div>
            <div class="items-center py-0 text-sm font-semibold">{{ $producto }} {{ $modelo }}</div>
            <div class="self-auto py-0 text-sm font-semibold">{{ $comentarios}} {{ $departamento }}</div>
            <img src="data:image/png;base64, {{ $barcode }}" alt="" class="py-0">
        </div>
    </x-slot>
</x-fondo-print>




