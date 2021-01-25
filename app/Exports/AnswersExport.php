<?php

namespace App\Exports;

use App\Models\Survey;
use App\Models\Task;
use App\Models\Survey_Detail;
use App\Models\Theme;
use App\Models\Utilities;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class AnswersExport implements FromArray,WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $arregloFinal=[];
        $tasks= Task::orderBy('id')->get();
        //dd($tasks);
        //$arregloTitulos =[$topic->id=>$topic->name];
        $surveys = Survey::where('finished','=',true)->get();
        //array_push($arregloFinal,array_values($arregloTitulos));
        $arregloTasks = [];
        //array_push($arregloFinal,array_values($arregloTitulos));
        foreach($tasks as $task) {
            $arregloTasks[$task->id]= $task->description;
        }
        $lastIndex = 0;
        foreach ($arregloTasks as $test=>$key) {
            $lastIndex=$test;
        }
        for ($i = 1; $i <= $lastIndex; $i++) {
            if(empty($arregloTasks[$i]))
                $arregloTasks[$i]='';
        }
        array_push($arregloFinal, ['Folio']+$arregloTasks);
        //dd($arregloFinal);
        foreach ($surveys as $survey){
            //Inicializando arreglos
            $arregloSurvey=[];
            $totalQuestions=[];
            $surveyDetails = Survey_Detail::where('survey_id','=',$survey->id)->whereNotNull('time')->get();
            foreach ($surveyDetails as $detail) {
                $arregloSurvey[$detail->task_id]=$detail->answer;
            }
            $lastIndex = 0;
            foreach ($arregloSurvey as $test=>$key) {
                $lastIndex=$test;
            }
            for ($i = 1; $i <= $lastIndex; $i++) {
                if(empty($arregloSurvey[$i]))
                    $arregloSurvey[$i]='';
            }


            $arregloSurvey=[$survey->folio]+$arregloSurvey;
            array_push($arregloFinal,array_values($arregloSurvey));
        }
        //dd($arregloFinal);
        //dd('test');

        return $arregloFinal;
    }
}
