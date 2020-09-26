<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz_mu_choice extends Model
{
    // Table Name
    protected $table = "quiz_mu_choices";
    // Primary Key
    public $primarykey = "quiz_mu_choice_id";
    // Timestamps
    public $timestamps = true;

    public function Quiz_mu(){
        return $this->belongsTo('App\Quiz_mu');
    }
}
