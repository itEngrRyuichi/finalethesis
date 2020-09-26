<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    // Table Name
    protected $table = "sections";
    // Primary Key
    public $primarykey = "section_id";
    // Timestamps
    public $timestamps = true;

    public function user(){
        return $this->hasMany('App\User');
    }
}
