@extends('layout')

@section('title', 'Validacion Estructura')


@section('content')
    <h1>Validación de estructura</h1>
    La estructura actual pondera lo siguiente en cada tema/subtema:
    <ul>
    @foreach ($data as $key => $node)
            <li><span style="font-weight: bolder">{{ $key }}:</span> {{ $node }}</li>
    @endforeach
    </ul>

@stop


