<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceStatus extends Model
{
    // Table Name
    protected $table = "attendance_statuses";
    // Primary Key
    public $primarykey = "attendanceStatus_id";
    // Timestamps
    public $timestamps = true;

    public function myDailyAttendance(){
        return $this->hasMany('App\myDailyAttendance');
    }
}
