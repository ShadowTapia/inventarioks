@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')
    <x-fondo-card>
        <x-slot name="html">
            <table class="table-auto">
                <thead>
                    <tr>
                        <th class="p-3">Nombre</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $u)
                    <tr>
                        <td class="p-3 border">{{ $u->name }}</td>
                        <td class="p-3 border">{{ $u->email }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </x-slot>
    </x-fondo-card>
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.0/dist/cdn.min.js"></script>
    @livewireScripts
@stop
