<?php

namespace App;

use App\Registration;
use App\Team;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable =  ['title', 'category_id', 'description', 'image_name', 'rules', 'event_date', 'start_time', 'end_time', 'min_members', 'max_members', 'max_limit', 'contact_email', 'allow_gender_mixing'];
    protected $image_path = '/images/events/';
    function category(){
        return $this->belongsTo('App\Category');
    }
    function users(){
        return $this->morphedByMany('App\User', 'registration');
    }
    function teams(){
        return $this->morphedByMany('App\Team', 'registration');
    }
    function rejections(){
        return $this->hasMany('App\Rejection');
    }
    function organizers(){
        return $this->belongsToMany('App\User', 'organizings');        
    }
    function prizes(){
        return $this->hasMany('App\Prize');
    }
    function hasPrizes(){
        if($this->prizes->count() == 0){
            return false;
        }
        else{
            return true;
        }
    }
    function getOrganizersList(){
        $organizerEmails = [];
        foreach($this->organizers as $organizer){
            array_push($organizerEmails, $organizer->email);
        }
        return implode(",", $organizerEmails);
    }
    function getRulesList(){
        $rules = explode(',', $this->rules);
        $rules_list = [];
        foreach($rules as $rule){
            array_push($rules_list, trim($rule));
        }
        return $rules_list;
    }
    function getDate(){
        $date = date_create($this->event_date);
        return date_format($date, 'j M Y');
    }
    function getStartTime(){
        $time = date_create($this->start_time); 
        return date_format($time, 'h:i A');               
    }
    function getEndTime(){
        $time = date_create($this->end_time); 
        return date_format($time, 'h:i A');               
    }
    function getImageUrl(){
        if(empty($this->image_name)){
            return $this->image_path . 'default.png';            
        }
        else{
            return $this->image_path . $this->image_name;            
        }
    }
    function isGroupEvent(){
        return $this->max_members>1;
    }
    function noOfConfirmedRegistration(){
        $count = 0;
        if($this->isGroupEvent()){
            foreach($this->teams as $team){
                if($team->user->isConfirmed()){
                    $count++;
                }
            }
        }
        else{
            foreach($this->users as $user){
                if($user->isConfirmed()){
                    $count++;
                }
            }
        }
        return $count;
    }
}
