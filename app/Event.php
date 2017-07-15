<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    function category(){
        return $this->belongsTo('App\Category');
    }
}
