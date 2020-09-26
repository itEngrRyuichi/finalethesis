<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class myQuizItem extends Model
{
    // Table Name
    protected $table = "my_quiz_items";
    // Primary Key
    public $primarykey = "myQuiz_item_id";
    // Timestamps
    public $timestamps = true;


    public function myQuiz(){
        return $this->belongsTo('App\myQuiz');
    }
    public function myQuiz_tf(){
        return $this->belongsTo('App\myQuiz_tf');
    }
    public function myQuiz_mu(){
        return $this->belongsTo('App\myQuiz_mu');
    }
    public function myQuiz_or(){
        return $this->belongsTo('App\myQuiz_or');
    }
    public function myQUiz_fi(){
        return $this->belongsTo('App\myQUiz_fi');
    }
    public function myQuiz_es(){
        return $this->belongsTo('App\UsmyQuiz_eser');
    }
    public function myQuiz_ma(){
        return $this->belongsTo('App\myQuiz_ma');
    }
}
