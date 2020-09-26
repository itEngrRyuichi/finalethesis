<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz_ma extends Model
{
    // Table Name
    protected $table = "quiz_mas";
    // Primary Key
    public $primarykey = "quiz_ma_id";
    // Timestamps
    public $timestamps = true;

    public function QuizItem(){
        return $this->hasMany('App\QuizItem');
    }
    public function Quiz_ma_column(){
        return $this->hasMany('App\Quiz_ma_column');
    }
}
