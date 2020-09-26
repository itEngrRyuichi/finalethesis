<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    // Table Name
    protected $table = "lessons";
    // Primary Key
    public $primarykey = "lesson_id";
    // Timestamps
    public $timestamps = true;

    public function class(){
        return $this->belongsTo('App\Clas');
    }
}
