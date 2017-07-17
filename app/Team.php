<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    function teamMembers(){
        return hasMany('App\TeamMember');
    }
    function events(){
        return $this->morphToMany('App\Event', 'registration');
    }
}
