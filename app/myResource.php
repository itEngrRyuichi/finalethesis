<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class myResource extends Model
{
    // Table Name
    protected $table = "my_resources";
    // Primary Key
    public $primarykey = "myResource_id";
    // Timestamps
    public $timestamps = true;

    public function myTask(){
        return $this->hasMany('App\myTask');
    }
}
