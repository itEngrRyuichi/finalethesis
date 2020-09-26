<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    // Table Name
    protected $table = "components";
    // Primary Key
    public $primarykey = "component_id";
    // Timestamps
    public $timestamps = true;

    public function SubjectType(){
        return $this->belongsTo('App\SubjectType');
    }
    public function task(){
        return $this->hasMany('App\task');
    }
}
