<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    // Table Name
    protected $table = "tasks";
    // Primary Key
    public $primarykey = "task_id";
    // Timestamps
    public $timestamps = true;

    public function Attendance(){
        return $this->belongsTo('App\Attendance');
    }
    public function Quiz(){
        return $this->belongsTo('App\Quiz');
    }
    public function Component(){
        return $this->belongsTo('App\Component');
    }
    public function Class(){
        return $this->belongsTo('App\Clas');
    }
    public function myTask(){
        return $this->hasMany('App\myTask');
    }
}
