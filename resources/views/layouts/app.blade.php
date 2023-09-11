@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Sistema Inventario KS</h1>
@stop

@section('content')
    <div class="card">
        <div class="card header">
            <h1 class="card-title">Bienvenido a Nuestro Sistema</h1>
        </div>
        <div class="card-body">
            <p>Sistema creado para inventariar todos los dispositivos, materiales y maquinarias que sean necearias registrar.</p>
        </div>
    </div>
@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Styles -->
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop
