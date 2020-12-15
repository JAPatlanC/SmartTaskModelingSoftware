@extends('layoutUser')

@section('title', 'Encuesta FAEN')


@section('content')


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <fieldset>


        <legend>{{$mensajeInicial->value}}</legend>
        @if($isBegin)
            <form action="{{ route('procesoEncuesta', $survey->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    {!! Form::label('folio', 'Folio:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::text('folio', $survey->folio, ['class' => 'form-control', 'placeholder' => 'Ingrese un folio de identificación...']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2" align="center">
                        {!! Form::submit('Comenzar', ['class' => 'btn btn-lg btn-dark pull-right'] ) !!}
                    </div>
                </div>
            </form>
        @endif

    </fieldset>


@stop