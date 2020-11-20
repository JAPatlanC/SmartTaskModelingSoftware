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


                    <legend>Catalogo de Actividades</legend>
                    <table id="myTable">
                        <thead>
                        <tr>
                            <th>Descripcion</th>
                            <th>Tipo</th>
                            <th>Opciones</th>
                            <th>Respuesta</th>
                            <th>Temas Relacionados</th>
                            <th>Archivos Relacionados</th>
                            <th>Fecha Creación</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td>{{ $project->description }}</td>
                                <td>{{ $project->type }}</td>
                                <td>{{ $project->options }}</td>
                                <td>{{ $project->answer }}</td>
                                @if($project->themes!=null)
                                    <td>
                                        @foreach ($project->themes as $theme)
                                            {{ $theme->name }},
                                        @endforeach
                                    </td>
                                @else
                                    <td>-</td>

                                @endif
                                @if($project->contents!=null)
                                    <td>
                                        @foreach ($project->contents as $content)
                                            {{ $content->filename }},
                                        @endforeach
                                    </td>
                                @else
                                    <td>-</td>

                                @endif
                                <td>{{ date_format($project->created_at, 'j M Y') }}</td>
                                <td>
                                    <form action="{{ route('tasks.destroy', $project->id) }}" method="POST">


                                        <a href="{{ route('tasks.edit', $project->id) }}">
                                            Editar

                                        </a>

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


                    @if($isUpdate)
                        <legend>Actualizar Actividad</legend>
                        <form action="{!! route('tasks.update', $task->id) !!}" method="POST" >
                            @method('PUT')
                            @else
                                <legend>Nueva Actividad</legend>
                                <form action="{!! route('tasks.store') !!}" method="POST" >

                                @endif

                                @csrf
                                <!-- Email -->
                                    <div class="form-group">
                                        {!! Form::label('description', 'Descripción:', ['class' => 'col-lg-2 control-label']) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('description', $task->description, ['class' => 'form-control', 'placeholder' => 'Ingrese la descripcion...']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('type', 'Tipo:', ['class' => 'col-lg-2 control-label'] )  !!}
                                        <div class="col-lg-10">
                                            {!!  Form::select('type',['Numerico'=>'Numerico','Checkbox'=>'Checkbox','RadioButton'=>'RadioButton'],  $task->type, ['class' => 'form-control' ]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('temas', 'Tema relacionados:', ['class' => 'col-lg-2 control-label'] )  !!}
                                        <div class="col-lg-10">
                                            {!!  Form::select('temas', $themesList,  $task->themes->pluck('id'), ['class' => 'form-control' ,'multiple' => 'multiple' ,'name'=>'temas[]']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('archivos', 'Archivos relacionados:', ['class' => 'col-lg-2 control-label'] )  !!}
                                        <div class="col-lg-10">
                                            {!!  Form::select('archivos', $contentList,  $task->contents->pluck('id'), ['class' => 'form-control' ,'multiple' => 'multiple' ,'name'=>'archivos[]']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('options', 'Opciones:', ['class' => 'col-lg-2 control-label']) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('options', $task->options, ['class' => 'form-control', 'placeholder' => 'Ingrese las opciones...']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('answer', 'Respuesta:', ['class' => 'col-lg-2 control-label']) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('answer', $task->answer, ['class' => 'form-control', 'placeholder' => 'Ingrese la respuesta...']) !!}
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-group">
                                        <div class="col-lg-10 col-lg-offset-2" align="center">
                                            {!! Form::submit('Guardar', ['class' => 'btn btn-lg btn-primary pull-right'] ) !!}
                                        </div>
                                    </div>
                                </form>

                </fieldset>


@stop
