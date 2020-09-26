<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    // Table Name
    protected $table = "grades";
    // Primary Key
    public $primarykey = "grade_id";
    // Timestamps
    public $timestamps = true;

    public function enrollment(){
        return $this->belongsTo('App\enrollment');
    }
    public function quarter(){
        return $this->belongsTo('App\Quarter');
    }
}
