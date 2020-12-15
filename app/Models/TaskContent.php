<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskContent extends Model
{
    use HasFactory;

    protected $table = 'task_content';
    public $timestamps = true;


    protected $fillable = [
        'task_id',
        'content_id'
    ];
}
