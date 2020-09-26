<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz_mu extends Model
{
    // Table Name
    protected $table = "quiz_mus";
    // Primary Key
    public $primarykey = "quiz_mu_id";
    // Timestamps
    public $timestamps = true;

    public function QuizItem(){
        return $this->hasMany('App\QuizItem');
    }
    public function Quiz_mu_choice(){
        return $this->hasMany('App\Quiz_mu_choice');
    }
}
