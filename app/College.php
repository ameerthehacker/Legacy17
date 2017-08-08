<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    protected $fillable = ['name', 'location'];
    function users(){
        return $this->hasMany('App\User');
    }
    function getQualifiedName(){
        return $this->name. ", " .$this->location;
    }
    function noOfParticipantsForEvent($event_id){
        $count = 0;
        $event = Event::find($event_id);
        if($event->isGroupEvent()){
            foreach($this->users as $user){
                if($user->hasRegisteredEvent($event_id)){
                    if($user->isTeamLeader($event_id) && $user->hasPaidForTeams()){
                        $count++;
                    }
                }
            }
        }
        else{
            foreach($this->users as $user){
                if($user->hasRegisteredEvent($event_id)){
                    if($user->hasPaid()){
                        $count++;
                    }
                }
            }
        }
        return $count;
    }
}
