<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectType extends Model
{
    // Table Name
    protected $table = "subject_types";
    // Primary Key
    public $primarykey = "subjectType_id";
    // Timestamps
    public $timestamps = true;

    public function Component(){
        return $this->hasMany('App\Component');
    }
    public function Subject(){
        return $this->hasMany('App\Subject');
    }
}
