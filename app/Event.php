<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable =  ['title', 'category_id', 'description', 'image_name', 'rules', 'event_date', 'start_time', 'end_time', 'min_members', 'max_members', 'max_limit', 'contact_email'];
    protected $image_path = '/images/events/';
    function category(){
        return $this->belongsTo('App\Category');
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
}
