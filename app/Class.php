<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clas extends Model
{
    // Table Name
    protected $table = "classes";
    // Primary Key
    public $primarykey = "class_id";
    // Timestamps
    public $timestamps = true;

    public function grade(){
        return $this->hasMany('App\Grade');
    }
    public function enrollment(){
        return $this->hasMany('App\enrollment');
    }
    public function classResource(){
        return $this->hasMany('App\classResource');
    }
    public function lesson(){
        return $this->hasMany('App\Lesson');
    }
    public function leadToClass(){
        return $this->hasMany('App\leadToClass');
    }
    public function task(){
        return $this->hasMany('App\task');
    }
    public function schoolYear(){
        return $this->belongsTo('App\SchoolYear');
    }
    public function semester(){
        return $this->belongsTo('App\Semester');
    }
    public function subject(){
        return $this->belongsTo('App\Subject');
    }
}
