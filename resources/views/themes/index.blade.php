@extends('layout')

@section('title', 'Temas/Subtemas')


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


        <legend>Catalogo de Temas/Subtemas</legend>
        <table id="myTable">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Ponderación</th>
                <th>Tema padre</th>
                <th>Orden</th>
                <th>Fecha Creación</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->value }}</td>
                    @if($project->parent!=null)
                        <td>{{ $project->parent->name }}</td>
                    @else
                        <td>-</td>

                    @endif
                    <td>{{ $project->order }}</td>
                    <td>{{ date_format($project->created_at, 'j M Y') }}</td>
                    <td>
                        <form action="{{ route('themes.destroy', $project->id) }}" method="POST">


                            <a href="{{ route('themes.edit', $project->id) }}"  class="btn btn-dark">
                                Editar

                            </a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" title="delete" class="btn btn-danger">
                                Eliminar

                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


        @if($isUpdate)
            <legend>Actualizar</legend>
            <form action="{!! route('themes.update', $theme->id) !!}" method="POST">
                @method('PUT')
                @else
                    <legend>Nuevo</legend>
                    <form action="{!! route('themes.store') !!}" method="POST">

                    @endif

                    @csrf
                    <!-- Email -->
                        <div class="form-group">
                            {!! Form::label('name', 'Nombre:', ['class' => 'col-lg-2 control-label']) !!}
                            <div class="col-lg-10">
                                {!! Form::text('name', $theme->name, ['class' => 'form-control', 'placeholder' => 'Ingrese la descripcion...']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('value', 'Ponderación:', ['class' => 'col-lg-2 control-label']) !!}
                            <div class="col-lg-10">
                                {!! Form::text('value', $theme->value, ['class' => 'form-control', 'placeholder' => 'Ingrese la ponderación...']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('parent_id', 'Tema padre:', ['class' => 'col-lg-2 control-label'] )  !!}
                            <div class="col-lg-10">
                                {!!  Form::select('parent_id', $themesList,  $theme->parent_id, ['placeholder' => 'Vacio','class' => 'form-control' ]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('order', 'Orden:', ['class' => 'col-lg-2 control-label'] )  !!}
                            <div class="col-lg-10">
                                {!! Form::text('order', $theme->order, ['class' => 'form-control', 'placeholder' => 'Ingrese la orden...']) !!}
                            </div>
                        </div>


                        <!-- Submit Button -->
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2" align="center">
                                {!! Form::submit('Guardar', ['class' => 'btn btn-lg btn-dark pull-right'] ) !!}
                            </div>
                        </div>
                    </form>

    </fieldset>


@stop