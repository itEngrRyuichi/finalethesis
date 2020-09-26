<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizItem extends Model
{
    // Table Name
    protected $table = "quiz_items";
    // Primary Key
    public $primarykey = "quizItem_id";
    // Timestamps
    public $timestamps = true;

    public function Quiz(){
        return $this->belongsTo('App\Quiz');
    }
    public function Quiz_tf(){
        return $this->belongsTo('App\Quiz_tf');
    }
    public function Quiz_mu(){
        return $this->belongsTo('App\Quiz_mu');
    }
    public function Quiz_or(){
        return $this->belongsTo('App\Quiz_or');
    }
    public function Quiz_fi(){
        return $this->belongsTo('App\Quiz_fi');
    }
    public function Quiz_es(){
        return $this->belongsTo('App\Quiz_es');
    }
    public function Quiz_ma(){
        return $this->belongsTo('App\Quiz_ma');
    }
}
