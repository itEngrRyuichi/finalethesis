<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class resource extends Model
{
    // Table Name
    protected $table = "resources";
    // Primary Key
    public $primarykey = "resource_id";
    // Timestamps
    public $timestamps = true;

    public function User(){
        return $this->belongsTo('App\User');
    }
}
