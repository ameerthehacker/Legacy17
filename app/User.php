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
    function confirmation(){
        return $this->hasOne('App\Confirmation');
    }
    // Find the team a user has registered for an event
    function teamLeaderFor($event_id){
        $event = Event::find($event_id);
        return $event->teams->where('user_id', $this->id)->first();
    }
    // find the team for which the user has been selected as team member
    function teamMemberFor($event_id){
        $event = Event::find($event_id);
        foreach($event->teams as $team){
            if($team->teamMembers->where('user_id', $this->id)->count()){
                return $team;
            }
        }
    }
    function teamEvents(){
        $events = [];
        //  Add events in which the user is team leader
        foreach($this->teams as $team){
            array_push($events, $team->events()->first());
        }
        //  Add events in which the user is a team member        
        foreach($this->teamMembers as $teamMember){
            array_push($events, $teamMember->team->events()->first());
        }
        // Return as collections
        return collect($events);
    }
    function hasRegisteredEvent($event_id){
        $event = Event::find($event_id);
        if($event->isGroupEvent()){
            foreach($this->teams as $team){
                if($team->hasRegisteredEvent($event_id)){
                    return true;
                }
            }  
            if($this->isTeamMember($event_id)){
                return true;
            }
        }
        else{
             return $this->events()->find($event_id);      
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
    function hasConfirmed(){
        if($this->confirmation == null){
            return false;
        }
        else{
            return true;
        }
    }
    function hasUploadedTicket(){
        if($this->hasConfirmed()){
            if($this->confirmation->file_name != ""){
                return true;
            }
        }
        return false;
    }
    function needApproval(){
        $teamCount = $this->teams->count();
        $teamMembersCount = $this->teamMembers->count();
        // Need approval if the user is not a team leader and does not belong to any team
        if($teamCount || !$teamMembersCount){
            return true;
        }
        else{
            return false;
        }
    }
    function isTeamMember($event_id){
        return $this->teamEvents()->where('id', $event_id)->count();
    }
    function isTeamLeader($event_id){
        $event = Event::find($event_id);
        if($event->teams()->where('user_id', $this->id)->count()){
            return true;
        }
        else{
            return false;
        }
    }
}
