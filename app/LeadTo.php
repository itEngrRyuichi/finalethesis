<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadTo extends Model
{
    // Table Name
    protected $table = "lead_tos";
    // Primary Key
    public $primarykey = "leadTo_id";
    // Timestamps
    public $timestamps = true;

    public function userType(){
        return $this->belongsTo('App\UserType');
    }
    public function accesscode(){
        return $this->belongsTo('App\Accesscode');
    }
}
