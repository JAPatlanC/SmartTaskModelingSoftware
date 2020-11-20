@extends('layout')

@section('title', 'Page Title')


@section('content')

    <img src="data:image/png;base64,{{ $baseData }}" alt="Red dot" />
    <video src="data:video/mp4;base64,{{ $baseData }}" alt="Red dot" />
    <iframe src="data:application/pdf;base64,{{ $baseData }}" height="100%" width="100%"></iframe>


@stop


