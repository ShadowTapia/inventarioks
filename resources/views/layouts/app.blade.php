@extends('adminlte::page')

@section('title', 'Dashboard')
    <title>{{ $title ?? 'Sistema Inventario' }}</title>
@section('content_header')

@stop

@section('content')
    {{ $slot }}
@stop

@section('css')
    {{-- @livewireStyles --}}
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/pikaday/pikaday.css') }}">

@stop

@section('js')
    {{-- @livewireScriptConfig --}}
    @vite(['resources/js/app.js'])
    <script src="{{ asset('vendor/pikaday/pikaday.js') }}"></script>
@stop
