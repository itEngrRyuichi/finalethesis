<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class myQuiz_es extends Model
{
    // Table Name
    protected $table = "my_quiz_es";
    // Primary Key
    public $primarykey = "myQuiz_es_id";
    // Timestamps
    public $timestamps = true;

    public function myQuizItem(){
        return $this->hasMany('App\myQuizItem');
    }
}
