<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    // Table Name
    protected $table = "quizzes";
    // Primary Key
    public $primarykey = "quiz_id";
    // Timestamps
    public $timestamps = true;

    public function task(){
        return $this->hasMany('App\task');
    }
    public function QuizItem(){
        return $this->hasMany('App\QuizItem');
    }
    public function User(){
        return $this->belongsTo('App\User');
    }
}
