@extends('layout')

@section('title', 'Page Title')


@section('content')

    <img src="data:image/png;base64,{{ $base64 }}" alt="Red dot" />
    <video src="data:video/mp4;base64,{{ $base64 }}" alt="Red dot" />
    <iframe src="data:application/pdf;base64,{{ $base64 }}" height="100%" width="100%"></iframe>


@stop


