@extends('layout')

@section('title', 'Page Title')


@section('content')

    @if($type=='pdf' || $type=='PDF')
        <iframe src="data:application/pdf;base64,{{ $baseData }}" height="100%" width="100%"></iframe>

    @endif
    @if($type=='PNG' || $type=='png')
        <img src="data:image/png;base64,{{ $baseData }}" alt="Red dot" />

    @endif
    @if($type=='mp4' || $type=='MP4')
        <video src="data:video/mp4;base64,{{ $baseData }}" alt="Red dot" />

    @endif


@stop


