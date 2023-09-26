<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <img src="{{ asset('images/sistema-inventario.png') }}" alt="" class="flex w-4/5">
            <div class="overflow-hidden shadow-xl dark:bg-gray-800 sm:rounded-lg">
                <p>Bienvenidos</p>
                <br>
                <p>Un Sistema de inventario es una herramienta utilizada para gestionar y hacer un seguimiento de los bienes, productos y materiales dentro de una organización.</p>
                <p>Con el software de gestión de inventario, las organizaciones pueden digitalizar, simplificar y agilizar diversas operaciones, además de reducir costes. Esto puede incluir la generación de SKU, la gestión de los niveles de existencias, el seguimiento de las unidades, la generación de informes de rendimiento y la previsión de la demanda.</p>
                <p>Esta aplicación esta llamada a optimizar los procesos logísticos y el estado del stock, manteniendo al día las existencias y sabiendo qué pedidos tienes que hacer en cada momento.</p>
            </div>
        </div>
    </div>
</x-app-layout>
