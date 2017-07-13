<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['full_name', 'email', 'password', 'gender', 'college_name', 'mobile'];
}
