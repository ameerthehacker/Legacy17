<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    function user(){
        return $this->hasOne('App\User');
    }
    function event(){
        return $this->hasOne('App\Event');
    }
}
