@extends('layout')

@section('title', 'Page Title')


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


        <legend>Catalogo de Archivos</legend>
        <table id="myTable">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Tamaño</th>
                <th>Vista Previa</th>
                <th>Fecha Creación</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->filename }}</td>
                    <td>{{ $project->filetype }}</td>
                    <td>{{ floor($project->size/1024) }} KB</td>
                    <td>
                        <a href="{{ route('contentsVer',$project->id) }}">
                            Ver
                        </a></td>
                    <td>{{ date_format($project->created_at, 'j M Y') }}</td>
                    <td>
                        <form action="{{ route('contents.destroy', $project->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit" title="delete" style="border: none; background-color:transparent;">
                                Eliminar

                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


        <legend>Nuevo Archivo</legend>
    {!! Form::open(['url' => route('contents.store'), 'class' => 'form-horizontal','method'=>'POST','files'=>true]) !!}

    @csrf
    <!-- Email -->
        <div class="form-group">
            {!! Form::label('pregunta', 'Cargar archivo:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::file('image'); !!}
            </div>
        </div>


        <!-- Submit Button -->
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2" align="center">
                {!! Form::submit('Guardar', ['class' => 'btn btn-lg btn-primary pull-right'] ) !!}
            </div>
        </div>
        {!! Form::close()  !!}


    </fieldset>



@stop


