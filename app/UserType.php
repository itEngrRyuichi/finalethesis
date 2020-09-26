<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    // Table Name
    protected $table = "user_types";
    // Primary Key
    public $primarykey = "userType_id";
    // Timestamps
    public $timestamps = true;

    public function leadTo(){
        return $this->hasMany('App\LeadTo');
    }
}
