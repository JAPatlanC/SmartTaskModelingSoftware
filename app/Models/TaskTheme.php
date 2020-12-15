<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTheme extends Model
{
    use HasFactory;

    protected $table = 'task_theme';
    public $timestamps = true;


    protected $fillable = [
        'task_id',
        'theme_id'
    ];
}
