<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    public $timestamps = true;


    protected $fillable = [
        'id',
        'description',
        'type',
        'options',
        'answer',
        'created_at',
        'answer_value'
    ];
    /**
     * The roles that belong to the user.
     */
    public function contents()
    {
        return $this->belongsToMany('App\Models\Content','task_content');
    }
    /**
     * The roles that belong to the user.
     */
    public function themes()
    {
        return $this->belongsToMany('App\Models\Theme');
    }
}
