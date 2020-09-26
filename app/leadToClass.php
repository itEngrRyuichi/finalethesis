<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class leadToClass extends Model
{
    // Table Name
    protected $table = "lead_to_classes";
    // Primary Key
    public $primarykey = "leadToClass_id";
    // Timestamps
    public $timestamps = true;

    
    public function class(){
        return $this->belongsTo('App\Clas');
    }
    public function accesscode(){
        return $this->belongsTo('App\Accesscode');
    }
}
