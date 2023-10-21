@extends('adminlte::page')

@section('title', 'Dashboard')
    <title>{{ $title ?? 'Sistema Inventario' }}</title>
@section('content_header')

@stop

@section('content')
    {{ $slot }}
@stop

@section('css')
    @livewireStyles
    @vite(['resources/css/app.css'])
@stop

@section('js')
    @vite(['resources/js/app.js'])
    @livewireScriptConfig
@stop
