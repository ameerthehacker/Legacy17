<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    function registration(){
        return $this->morphTo();
    }
    function users(){
        return morphedByMany('App\User', 'registration');
    }
    function teams(){
        return morphedByMany('App\Team', 'registration');
    }
}
