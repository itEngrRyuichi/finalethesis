<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class myTask extends Model
{
    // Table Name
    protected $table = "my_tasks";
    // Primary Key
    public $primarykey = "myTask_id";
    // Timestamps
    public $timestamps = true;

    public function myResource(){
        return $this->belongsTo('App\myResource');
    }
    public function myQuiz(){
        return $this->belongsTo('App\myQuiz');
    }
    public function myAttendance(){
        return $this->belongsTo('App\myAttendance');
    }
    public function task(){
        return $this->belongsTo('App\task');
    }
    public function User(){
        return $this->belongsTo('App\User');
    }
}
