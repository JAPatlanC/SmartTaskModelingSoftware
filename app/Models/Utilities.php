<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilities extends Model
{

    //added new user
    public static function addChildren($children) {
        $nodes = [];
        foreach($children as $child){
            $node = new Node;
            $node->text= new \App\Models\Node();
            $node->text->name=$child->name.' / '.$child->value;
            $node->children=Utilities::addChildren(Theme::where('parent_id','=',$child->id)->get());
            array_push($nodes,$node);
        }
        return $nodes;
    }
    //added
    public static function addChildrenExcel($children) {
        $arregloTitulos = [];
        foreach($children as $child){
            $arregloTitulos=$arregloTitulos+Utilities::addChildrenExcel(Theme::where('parent_id','=',$child->id)->get());
            $arregloTitulos[$child->id]=$child->name;

        }
        return $arregloTitulos ;
    }
}
