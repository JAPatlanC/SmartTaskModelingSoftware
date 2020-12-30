<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\Content;
use App\Models\Setting;
use App\Models\Survey;
use App\Models\Survey_Detail;
use App\Models\TaskContent;
use App\Models\Task;
use App\Models\Theme;
use App\Models\TaskTheme;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class FlujoEncuestaController extends Controller
{
    public function begin()
    {
        $mensajeInicial = Setting::find(1);
        $survey = new Survey;
        $isBegin = true;
        return view('welcomeUser', compact(['mensajeInicial', 'survey', 'isBegin']));
    }

    public function process(Request $request, Survey $survey)
    {
        $startTime = microtime(true);
        $tiempoRestante = Setting::find(2);
        //Crea una nueva encuesta
        if ($request->survey == null) {
            if($request->folio==null){
                return Redirect::back()->withErrors(['Ingrese un folio de identificación'])->withInput($request->all());
            }
            $nodos = array_unique(Theme::pluck('parent_id')->toArray());
            $idsTemas=Theme::whereIn('id',$nodos)->pluck('id')->toArray();
            $temasNodos = Theme::whereNotIn('id',$idsTemas)->orderBy('order')->get();
            $siguienteTema = $temasNodos->shift();
            $idsTareas = TaskTheme::where('theme_id','=',$siguienteTema->id)->pluck('task_id')->toArray();
            $tasks = Task::whereIn('id',$idsTareas)->get();
            $archivos = Content::whereIn('id',array_unique(TaskContent::whereIn('task_id',$idsTareas)->pluck('content_id')->toArray()))->orderBy('filetype')->get();
            foreach ($archivos as $archivo){
                $base64 = $archivo->body;
                //heroku
                $my_bytea = stream_get_contents($base64);
                $my_string = pg_unescape_bytea($my_bytea);
                $archivo->body = htmlspecialchars($my_string);
            }
            $survey->folio = $request->folio;
            $survey->save();
        } else {
            //dd($request->all());
            //Tiempo transcurrido
            $startTime=$request->startTime;
            $endtime = microtime(true);
            $timediff = ceil($endtime - $startTime);
            $startTime=microtime(true);
            $survey = Survey::find($request->survey);
            $siguienteTema = new Theme(json_decode($request->siguienteTema, true));
            $answersCollection = [];
            //Guardar respuestas
            if($request->answer !=null)
            foreach($request->answer as $taskId=> $ans){
                $ansString='';
                $score=0;
                $taskAns = Task::find($taskId);
                //Calculando el score si es:
                //Numeric: Debe coincidir con lo que escriba
                if($taskAns->type=='Numerico' and $ans!=null){
                    $ansString=$ans;
                    if($ans==$taskAns->answer){
                        $score=100;
                    }
                }
                //Checkbox: Suma puntos por cada acierto
                if($taskAns->type=='Checkbox' and $ans!=null){
                    $answerValues=explode(',',$taskAns->answer);
                    $answerKeys=explode(',',$taskAns->options);
                    if(count($ans)>count($answerValues))
                        break;
                    foreach($ans as $ansInt){
                        $ansString=$ansString.', '.$ansInt;
                        foreach($answerValues as $key=>$value) {
                            if (trim($answerKeys[$key]) == trim($ansInt)) {
                                $score += $value;
                            }
                        }
                    }
                }

                //Radiobutton: Suma puntos si coincide con el correcto
                if($taskAns->type=='RadioButton' and $ans!=null){
                    $ansString=$ans;
                    $answerValues=explode(',',$taskAns->answer);
                    $answerKeys=explode(',',$taskAns->options);
                    foreach($answerValues as $key=>$value){
                        if($value==100 and trim($answerKeys[$key])==trim($ans)){
                            $score=100;
                        }
                    }


                }

                $answer = new Survey_Detail;
                $answer->task_id=$taskId;
                $answer->theme_id=$siguienteTema->id;
                $answer->survey_id=$survey->id;
                $answer->score=ceil($score);
                $answer->answer=$ansString;
                $answer->time=$timediff;
                array_push($answersCollection,$answer);
            }
            //Guardando todas las respuestas y sacando promedio del tema
            $answersCollection = collect($answersCollection);
            $totalScore=0;
            foreach($answersCollection  as $ans){
                $ans->save();
                $totalScore=$ans->score;
            }
            if($request->answer !=null)
                $totalScore=ceil($totalScore/count($answersCollection));
            else
                $totalScore=0;
            $answer = new Survey_Detail;
            $answer->theme_id=$siguienteTema->id;
            $answer->survey_id=$survey->id;
            $answer->score=$totalScore;
            $answer->answer='';
            $answer->save();

            //Continuar
            $temasNodos = new Collection(json_decode($request->temasNodos, true));
            if(count($temasNodos)==0){
                //Finalizando encuesta
                $survey->finished=true;
                $survey->update();
                return redirect()->route('terminaEncuesta');
            }
            $siguienteTema= new Theme($temasNodos->shift());
            $idsTareas = TaskTheme::where('theme_id','=',$siguienteTema->id)->pluck('task_id')->toArray();
            $tasks = Task::whereIn('id',$idsTareas)->orderBy('created_at')->get();
            $archivos = Content::whereIn('id',array_unique(TaskContent::whereIn('task_id',$idsTareas)->pluck('content_id')->toArray()))->orderBy('filetype')->get();
            foreach ($archivos as $archivo){
                $base64 = $archivo->body;
                //heroku
                $my_bytea = stream_get_contents($base64);
                $my_string = pg_unescape_bytea($my_bytea);
                $archivo->body = htmlspecialchars($my_string);
            }
            $survey->update();
        }

        return view('procesoEncuesta', compact(['tiempoRestante','siguienteTema','survey','archivos','tasks','temasNodos','siguienteTema','startTime']));
    }


    public function end()
    {
        $mensajeInicial = Setting::find(3);
        $encuesta = new Survey;
        $isBegin = false;
        return view('welcomeUser', compact(['mensajeInicial', 'encuesta', 'isBegin']));
    }


    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
