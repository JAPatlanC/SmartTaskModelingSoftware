@extends('layout')

@section('title', 'Configuración')


@section('content')

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Verifique los campos:</strong>.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <fieldset>


        <legend>Configuración</legend>
        <table id="myTable">
            <thead>
            <tr>
                <th>Configuración</th>
                <th>Valor</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->value }}</td>
                    <td>
                            <a href="{{ route('settings.edit', $project->id) }}">
                                Editar

                            </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


        @if($isUpdate)
            <legend>Actualizar</legend>
            <form action="{!! route('settings.update', $setting->id) !!}" method="POST">
                @method('PUT')

                    @csrf
                    <!-- Email -->
                    <div class="form-group">
                        {!! Form::label('name', 'Nombre:', ['class' => 'col-lg-2 control-label']) !!}
                        <div class="col-lg-10">
                            {!! Form::text('name', $setting->name, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('value', 'Valor:', ['class' => 'col-lg-2 control-label']) !!}
                        <div class="col-lg-10">
                            {!! Form::text('value', $setting->value, ['class' => 'form-control', 'placeholder' => 'Ingrese el valor...']) !!}
                        </div>
                    </div>


                        <!-- Submit Button -->
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2" align="center">
                                {!! Form::submit('Guardar', ['class' => 'btn btn-lg btn-primary pull-right'] ) !!}
                            </div>
                        </div>
                    </form>
        @endif

    </fieldset>


@stop