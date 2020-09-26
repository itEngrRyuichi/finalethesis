<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz_or_column extends Model
{
    // Table Name
    protected $table = "quiz_or_columns";
    // Primary Key
    public $primarykey = "quiz_or_column_id";
    // Timestamps
    public $timestamps = true;

    public function Quiz_or(){
        return $this->belongsTo('App\Quiz_or');
    }
}
