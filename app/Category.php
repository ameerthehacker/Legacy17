<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    function events(){
        return $this->hasMany('App\Event');
    }
}
