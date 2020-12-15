<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey_Detail extends Model
{
    use HasFactory;
    protected $table = 'survey__details';
    public $timestamps = true;


    protected $fillable = [
        'answer',
        'score',
        'task_id',
        'theme_id',
        'survey_id'
    ];

}
