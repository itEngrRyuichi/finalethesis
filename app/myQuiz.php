<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class myQuiz extends Model
{
    // Table Name
    protected $table = "my_quizzes";
    // Primary Key
    public $primarykey = "myQuiz_id";
    // Timestamps
    public $timestamps = true;

    public function myTask(){
        return $this->hasMany('App\myTask');
    }
    public function myQuizItem(){
        return $this->hasMany('App\myQuizItem');
    }
}
