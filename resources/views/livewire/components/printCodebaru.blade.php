<x-fondo-print>
    <x-slot name="content">
        <div class="max-h-fit grid grid-cols-1 gap-4">
            <div class="left-8">
                <img id="logoks" src="{{ asset('images/kscodebar.png') }}" alt="">
            </div>
            <div class="text-sm font-semibold py-0 items-center">{{ $producto }}</div>
            <div class="py-0 text-sm font-semibold self-auto">{{ $modelo }}</div>
            <img src="data:image/png;base64, {{ $barcode }}" alt="" class="py-0">
        </div>
    </x-slot>
</x-fondo-print>




