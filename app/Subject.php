<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    // Table Name
    protected $table = "subjects";
    // Primary Key
    public $primarykey = "subject_id";
    // Timestamps
    public $timestamps = true;

    public function SubjectType(){
        return $this->belongsTo('App\SubjectType');
    }
    public function Class(){
        return $this->hasMany('App\Clas');
    }
}
