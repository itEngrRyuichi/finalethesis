<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    // Table Name
    protected $table = "attendances";
    // Primary Key
    public $primarykey = "attendance_id";
    // Timestamps
    public $timestamps = true;

    public function task(){
        return $this->hasMany('App\task');
    }
}
