<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quarter extends Model
{
    // Table Name
    protected $table = "quarters";
    // Primary Key
    public $primarykey = "quarter_id";
    // Timestamps
    public $timestamps = true;

    public function Grade(){
        return $this->belongsTo('App\Grade');
    }
    public function Semester(){
        return $this->hasMany('App\Semester');
    }
}
