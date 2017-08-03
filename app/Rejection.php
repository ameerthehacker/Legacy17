<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rejection extends Model
{
    function user(){
        return $this->belongsTo('App\User');
    }
    function event(){
        return $this->belongsTo('App\Event');
    }
}
