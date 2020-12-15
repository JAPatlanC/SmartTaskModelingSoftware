<?php

namespace App\Exports;

use App\Models\Survey;
use App\Models\Survey_Detail;
use App\Models\Theme;
use App\Models\Utilities;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class UsersExport implements FromArray,WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $arregloFinal=[];
        $topic= Theme::where('parent_id','=',null)->firstOrFail();
        //$arregloTitulos =[$topic->id=>$topic->name];
        $arregloTitulos =[];
        $arregloTitulos=$arregloTitulos+Utilities::addChildrenExcel(Theme::where('parent_id','=',$topic->id)->get());
        $arregloTitulos =$arregloTitulos +[$topic->id=>$topic->name];
        $surveys = Survey::where('finished','=',true)->get();
        array_push($arregloFinal,array_values($arregloTitulos));
        foreach ($surveys as $survey){
            //Inicializando arreglos
            $arregloSurvey=[];
            $totalQuestions=[];
            foreach($arregloTitulos as $key=>$value){
                $arregloSurvey[$key]=0;
                $totalQuestions[$key]=0;
            }
            //Calificando temas segun las respuestas
            $surveyDetails = Survey_Detail::where('survey_id','=',$survey->id)->get();
            foreach ($surveyDetails as $detail) {
                $arregloSurvey[$detail->theme_id]+=$detail->score;
                $totalQuestions[$detail->theme_id]+=1;
            }
            foreach ($arregloSurvey as $key=>$value){
                if($totalQuestions[$key]>0)
                    $arregloSurvey[$key]=ceil($arregloSurvey[$key]/$totalQuestions[$key]);
            }
            //Calificando niveles superiores
            foreach ($arregloSurvey as $key=>$value){
                if($arregloSurvey[$key]==0){
                    $nodosHijos = Theme::where('parent_id','=',$key)->get();
                    if(count($nodosHijos)==0)
                        continue;
                    $nodo = Theme::find($key);
                    foreach ($nodosHijos as $nodoHijo) {
                        $porcentaje = $nodoHijo->value;
                        $arregloSurvey[$key]+=ceil($porcentaje*$arregloSurvey[$nodoHijo->id]/100);
                    }
                    //dd($nodosHijos,$nodo);
                }
                if($arregloSurvey[$key]>100)
                    $arregloSurvey[$key]=100;
            }
            array_push($arregloFinal,array_values($arregloSurvey));
        }
        //dd($arregloFinal);
        //dd('test');
        return $arregloFinal;
    }
}
