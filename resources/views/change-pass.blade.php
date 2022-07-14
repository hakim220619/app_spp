@extends('layouts.head')

@if(config('adminlte.livewire'))
    @if(app()->version() >= 7)
        @livewireStyles()
    @else
        <livewire:styles />
    @endif
@endif

@section('body')
    <livewire:change-password/>
@endsection

@if(config('adminlte.livewire'))
    @if(app()->version() >= 7)
        @livewireScripts()
    @else
        <livewire:scripts />
    @endif
@endif
