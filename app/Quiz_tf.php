<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz_tf extends Model
{
    // Table Name
    protected $table = "quiz_tfs";
    // Primary Key
    public $primarykey = "quiz_tf_id";
    // Timestamps
    public $timestamps = true;

    public function QuizItem(){
        return $this->hasMany('App\QuizItem');
    }
}
