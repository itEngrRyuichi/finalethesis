<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'section_id', 'child_id', 'userType_id', 'school_id', 'usable', 'name', 'email', 'password', 'profilePic_location',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Table Name
    protected $table = "users";
    // Primary Key
    public $primarykey = "user_id";
    // Timestamps
    public $timestamps = true;


    public function parent(){
        return $this->belongsTo('App\User');
    }
    public function child(){
        return $this->hasMany('App\User');
    }
    public function section(){
        return $this->belongsTo('App\Section');
    }
    public function userType(){
        return $this->belongsTo('App\UserType');
    }

}
