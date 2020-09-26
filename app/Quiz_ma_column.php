<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz_ma_column extends Model
{
    // Table Name
    protected $table = "quiz_ma_columns";
    // Primary Key
    public $primarykey = "quiz_ma_column_id";
    // Timestamps
    public $timestamps = true;

    public function Quiz_ma(){
        return $this->belongsTo('App\Quiz_ma');
    }
}
