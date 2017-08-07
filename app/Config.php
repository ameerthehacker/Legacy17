<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    public static function getConfig($config){
        return Config::all()->where('config', $config)->first()->value;
    }
    public static function setConfig($config, $value){
        $configuration =  Config::all()->where('config', $config)->first();
        $configuration->value = $value;
        $configuration->save();
    }
}
