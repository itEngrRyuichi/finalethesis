<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz_or extends Model
{
    // Table Name
    protected $table = "quiz_ors";
    // Primary Key
    public $primarykey = "quiz_or_id";
    // Timestamps
    public $timestamps = true;

    public function QuizItem(){
        return $this->hasMany('App\QuizItem');
    }
    public function Quiz_or_column(){
        return $this->hasMany('App\Quiz_or_column');
    }
}
