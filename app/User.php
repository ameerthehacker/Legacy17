<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['full_name', 'email', 'password', 'gender', 'college_name', 'mobile'];
}
