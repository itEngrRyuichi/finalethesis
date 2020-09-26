<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassResource extends Model
{
    // Table Name
    protected $table = "class_resources";
    // Primary Key
    public $primarykey = "classResource_id";
    // Timestamps
    public $timestamps = true;

    public function class(){
        return $this->belongsTo('App\Clas');
    }
}
