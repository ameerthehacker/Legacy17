<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name'];
    function teamMembers(){
        return $this->hasMany('App\TeamMember');
    }
    function events(){
        return $this->morphToMany('App\Event', 'registration');
    }
    function hasRegisteredEvent($id){
        return $this->events()->find($id); 
    }
    function user(){
        return $this->belongsTo('App\User');
    }
    function isConfirmed(){
        foreach($this->teamMembers as $teamMember){
            if(!$teamMember->user->hasConfirmed()){
                return false;
            }
        }
        return true;
    }
    function isPaid(){
        foreach($this->teamMembers as $teamMember){
            if(!$teamMember->user->hasPaid()){
                return false;
            }
        }
        return true;
    }
}
