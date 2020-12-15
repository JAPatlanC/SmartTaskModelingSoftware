@extends('layout')

@section('title', 'Ver Archivo')


@section('content')

    @if($type=='pdf' || $type=='PDF')
        <iframe src="data:application/pdf;base64,{{ $baseData }}" height="100%" width="100%"></iframe>

    @endif
    @if($type=='PNG' || $type=='png'|| $type=='jpg'|| $type=='JPG')
        <img src="data:image/png;base64,{{ $baseData }}" alt="Red dot" />

    @endif
    @if($type=='mp4' || $type=='MP4'|| $type=='webm'|| $type=='WEBM')
        <video src="data:video/mp4;base64,{{ $baseData }}" alt="Red dot" controls/>
    @endif


@stop


