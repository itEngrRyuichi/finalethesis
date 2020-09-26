<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz_es extends Model
{
    // Table Name
    protected $table = "quiz_es";
    // Primary Key
    public $primarykey = "quiz_es_id";
    // Timestamps
    public $timestamps = true;

    public function QuizItem(){
        return $this->hasMany('App\QuizItem');
    }
}
