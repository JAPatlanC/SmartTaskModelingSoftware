<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $table = 'contents';
    public $timestamps = true;


    protected $fillable = [
        'filetype',
        'body',
        'filename',
        'size'
    ];
    /**
     * The roles that belong to the user.
     */
    public function tasks()
    {
        return $this->belongsToMany('App\Models\Task');
    }
}
