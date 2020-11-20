<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;
    protected $table = 'themes';
    public $timestamps = true;


    protected $fillable = [
        'name',
        'value',
        'parent_id',
        'created_at'
    ];

    public function parent()
    {
        return $this->hasOne('App\Models\Theme','id','parent_id');
    }

}
