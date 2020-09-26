<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz_fi_blank_answer extends Model
{
    // Table Name
    protected $table = "quiz_fi_blank_answers";
    // Primary Key
    public $primarykey = "quiz_fi_blank_answer_id";
    // Timestamps
    public $timestamps = true;

    public function Quiz_fi(){
        return $this->belongsTo('App\Quiz_fi');
    }
}
