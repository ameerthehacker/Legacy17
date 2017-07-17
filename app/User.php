<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['full_name', 'email', 'password', 'gender', 'college_name', 'mobile'];

    function events(){
        return $this->morphToMany('App\Event', 'registration');
    }
    function hasRegisteredEvent($event_id){
        return $this->events()->find($event_id);
    }
}
