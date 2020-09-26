<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    // Table Name
    protected $table = "school_years";
    // Primary Key
    public $primarykey = "schoolYear_id";
    // Timestamps
    public $timestamps = true;

    public function classes(){
        return $this->hasMany('App\Clas');
    }
}
