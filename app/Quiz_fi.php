<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz_fi extends Model
{
    // Table Name
    protected $table = "quiz_fis";
    // Primary Key
    public $primarykey = "quiz_fi_id";
    // Timestamps
    public $timestamps = true;

    public function QuizItem(){
        return $this->hasMany('App\QuizItem');
    }
    public function Quiz_fi_blank_answer(){
        return $this->hasMany('App\Quiz_fi_blank_answer');
    }
}
