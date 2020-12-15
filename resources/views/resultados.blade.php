@extends('layout')

@section('title', 'Resultados')


@section('content')
    <h1>Resultados</h1>
    <table id="myTable">
    <thead>
    <tr>
        <th>Numero de encuesta</th>
        <th>Folio</th>
        <th>Fecha de Inicio</th>
        <th>Estatus</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($projects as $project)
        <tr>
            <td>{{ $project->id }}</td>
            <td>{{ $project->folio }}</td>
            <td>{{ date_format($project->created_at, 'd-m-Y h:i:s') }}</td>
            <td>{{ $project->finished==1?'Terminada':'En proceso' }}</td>
        </tr>
    @endforeach

    </tbody>
</table>

    <a  class="btn btn-primary" href="{{ route('export') }}">Descargar CSV Resultados</a>

@stop


