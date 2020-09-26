<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    // Table Name
    protected $table = "semesters";
    // Primary Key
    public $primarykey = "semester_id";
    // Timestamps
    public $timestamps = true;

    public function Clas(){
        return $this->hasMany('App\Clas');
    }
    public function Semester(){
        return $this->hasMany('App\Semester');
    }
}
