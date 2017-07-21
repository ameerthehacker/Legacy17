<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    function user(){
        return $this->belonsTo('App\User');
    }
    function paidBy(){
        return $this->belongsTo('App\User', 'paid_by');
    }
}
