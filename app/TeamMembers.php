<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamMembers extends Model
{
    function team(){
        return belongsTo('App\Team');
    }
}
