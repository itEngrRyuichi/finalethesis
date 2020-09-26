<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class enrollment extends Model
{
    // Table Name
    protected $table = "enrollments";
    // Primary Key
    public $primarykey = "enrollment_id";
    // Timestamps
    public $timestamps = true;

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function class(){
        return $this->belongsTo('App\Clas');
    }
}
