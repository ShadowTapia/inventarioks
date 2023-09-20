@extends('adminlte::page')

@section('title', 'Dashboard')
    <title>{{ $title ?? 'Page Title' }}</title>
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.0/dist/cdn.min.js"></script>
    @livewireScripts
    @vite(['resources/js/app.js'])
@stop
