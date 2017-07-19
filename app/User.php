<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    protected $fillable = ['full_name', 'email', 'password', 'gender', 'college_id', 'mobile'];

    function events(){
        return $this->morphToMany('App\Event', 'registration');
    }
    function teamForEvent($event_id){
        $event = Event::find($event_id);
        return $event->teams->where('user_id', $this->id)->first();
    }
    function teamEvents(){
        $events = [];
        foreach($this->teams as $team){
            array_push($events, $team->events()->first());
        }
        return $events;
    }
    function hasRegisteredEvent($event_id){
        $event = Event::find($event_id);
        if($event->max_members == 1){
            return $this->events()->find($event_id);            
        }
        else{
            foreach($this->teams as $team){
                if($team->hasRegisteredEvent($event_id)){
                    return true;
                }
            }
        }
        return false;
    }
    function college(){
        return $this->belongsTo('App\College');
    }
    function teams(){
        return $this->hasMany('App\Team');
    }
    function teamMembers(){
        return $this->hasMany('App\TeamMember');
    }
}
