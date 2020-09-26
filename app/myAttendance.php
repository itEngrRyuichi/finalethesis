<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class myAttendance extends Model
{
    // Table Name
    protected $table = "my_attendances";
    // Primary Key
    public $primarykey = "myAttendance_id";
    // Timestamps
    public $timestamps = true;

    public function myDailyAttendance(){
        return $this->hasMany('App\myDailyAttendance');
    }
    public function myTask(){
        return $this->hasMany('App\myTask');
    }
}
