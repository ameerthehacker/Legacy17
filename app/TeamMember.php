<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    function team(){
        return belongsTo('App\Team');
    }
    function user(){
        return $this->belongsTo('App\User');
    }
}
