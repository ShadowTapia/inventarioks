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
    @livewireScriptConfig
    @vite(['resources/js/app.js'])
@stop
