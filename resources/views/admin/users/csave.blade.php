@extends('adminlte::page')

@section('title', 'Guardar Usuario')

@section('content_header')

@stop

@section('content')
        @livewire('user-save')
@stop

@section('css')
    @livewireStyles
    @vite(['resources/css/app.css'])
@stop

@section('js')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.0/dist/cdn.min.js"></script>
    @livewireScripts
    @vite(['resources/js/app.js'])
@stop
