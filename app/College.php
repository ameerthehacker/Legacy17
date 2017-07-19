<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    function users(){
        return $this->hasMany('App\User');
    }
}
