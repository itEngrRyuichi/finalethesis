<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accesscode extends Model
{
    // Table Name
    protected $table = "accesscodes";
    // Primary Key
    public $primarykey = "accesscode_id";
    // Timestamps
    public $timestamps = true;

    public function leadTo(){
        return $this->hasMany('App\LeadTo');
    }
    public function leadToClass(){
        return $this->hasMany('App\leadToClass');
    }
}
