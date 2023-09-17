@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')
    <x-fondo-card>
        <x-slot name="html">
            <livewire:users-list></livewire:users-list>
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
