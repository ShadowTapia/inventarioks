@extends('adminlte::page')

@section('title', 'Dashboard')
<title>{{ $title ?? 'Sistema Inventario' }}</title>
@section('content_header')

@stop

@section('css')
    {{-- @livewireStyles --}}
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/pikaday/pikaday.css') }}">
@stop
<x-toaster-hub />
@livewire('wire-elements-modal')
@section('content')
    {{ $slot }}
@stop

@section('js')
    {{-- @livewireScripts --}}
    @vite(['resources/js/app.js'])
    <script src="{{ asset('vendor/pikaday/pikaday.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stop
