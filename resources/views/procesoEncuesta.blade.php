@extends('layoutUser')

@section('title', 'Encuesta')


@section('content')
    <style>

        label {
            font-size: 20px;
        }

        #demo {
            font-size: 20px;
        }

    </style>
    <script>
        $(document).ready(function () {

                var tiempoRestante = {!! $tiempoRestante->value !!}+2;
                $("#preguntas").toggle();
                $("#multimedia").toggle();
                var dt = new Date();
                dt.setSeconds(dt.getSeconds() + tiempoRestante);
                var countDownDate = dt.getTime();

                // Update the count down every 1 second
                var x = setInterval(function () {

                    // Get today's date and time
                    var now = new Date().getTime();

                    // Find the distance between now and the count down date
                    var distance = countDownDate - now;

                    // Time calculations for days, hours, minutes and seconds
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Display the result in the element with id="demo"
                    document.getElementById("demo").innerHTML = "Tiempo restante: " + minutes + "min. " + seconds + "seg. ";

                    // If the count down is finished, write some text
                    if (distance < 0) {
                        $("#zonaPreguntas").toggle();
                        clearInterval(x);
                        document.getElementById("demo").innerHTML = "Continue dando click en siguiente.";
                    }
                }, 1000);

        });
        // Set the date we're counting down to
    </script>
    <!--<legend>{{$siguienteTema->name}}</legend>-->
    <!-- Zona multimedia -->
    <div id="multimedia">
        <!--<legend>Multimedia</legend>-->

        <div align="center">
            <p id="demo"></p>
        </div>

        <div align="center">
            @forelse  ($archivos as  $archivo)
                @if($archivo->filetype=='pdf' || $archivo->filetype=='PDF')
                    <iframe src="data:application/pdf;base64,{{ $archivo->body }}" height="100%" width="100%"></iframe>
                    <br/><br/><br/>

                @endif
            @empty

                <br/>

            @endforelse
            @forelse  ($archivos as  $indexKey =>$archivo)
                @if($archivo->filetype=='PNG' || $archivo->filetype=='png' || $archivo->filetype=='jpg'||$archivo->filetype=='JPG')
                        @if($indexKey ==0)
                            <h4>Observa la imagen y posteriormente contesta las preguntas</h4>
                        @endif
                    <img src="data:image/png;base64,{{ $archivo->body }}" alt="Red dot"
                         style="width: 400px;height: 400px;"/>
                            <br/><br/><br/>

                @endif
                @empty

                    <br/>
            @endforelse
            @forelse  ($archivos as  $indexKey =>$archivo)
                @if($archivo->filetype=='mp4' || $archivo->filetype=='MP4'||$archivo->filetype=='webm'||$archivo->filetype=='WEBM')
                        @if($indexKey ==0)
                            <h4>Observa el video y posteriormente contesta las preguntas</h4>
                        @endif
                    <video src="data:video/mp4;base64,{{ $archivo->body }}" alt="Red dot" controls autoplay>
                    </video>
                            <br/><br/><br/>
                @endif
                @empty
                    <h4>Contesta las siguientes preguntas</h4>
                    <br/><br/><br/>

            @endforelse
        </div>

        <legend>Cuestionario</legend>
        <form action="{{ route('procesoEncuesta', $survey->id) }}" id="formulario" method="POST">
            <div id="zonaPreguntas">
                @csrf
                {{ Form::hidden('survey', $survey->id) }}
                {{ Form::hidden('temasNodos', $temasNodos) }}
                {{ Form::hidden('siguienteTema', $siguienteTema) }}
                {{ Form::hidden('startTime', $startTime) }}
                @foreach ($tasks as $indexKey =>$task)
                    <br/>
                    @if($task->type=='RadioButton')
                        <div class="form-group">
                            {!! Form::label($task->description, $task->description, ['class' => 'control-label']) !!}
                            <br/>
                            @foreach (explode(',',$task->options) as $opt)
                                <label>
                                    {{ Form::radio('answer['.$task->id.']', $opt, false,['class'=>'with-gap']) }}
                                    <span>{{$opt}}</span>
                                </label>
                                <br/>
                            @endforeach
                        </div>
                    @endif
                    @if($task->type=='Checkbox')
                        <div class="form-group">
                            {!! Form::label($task->description, $task->description, ['class' => 'control-label']) !!}
                            <br/>
                            @foreach (explode(',',$task->options) as $opt)
                                <label>
                                    {{ Form::checkbox('answer['.$task->id.'][]', $opt, false,['class'=>'with-gap']) }}
                                    <span>{{$opt}}</span>
                                </label>
                                <br/>
                            @endforeach
                        </div>
                    @endif
                    @if($task->type=='Numerico')
                        <div class="form-group">
                            {!! Form::label($task->description, $task->description, ['class' => 'control-label']) !!}
                            <br/>
                            <div class="col-lg-10">
                                {!! Form::text('answer['.$task->id.']', null, ['class' => 'form-control', 'placeholder' => 'Ingrese un valor númerico...']) !!}
                            </div>
                            <br/>
                        </div>
                    @endif


                @endforeach
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2" align="center">
                    {!! Form::submit('Siguiente', ['id'=>'siguiente','class' => 'btn btn-lg btn-dark pull-right'] ) !!}
                </div>
            </div>
        </form>
    </div>


@stop