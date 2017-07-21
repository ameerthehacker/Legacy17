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
    function getTotalAmount(){
        $totalAmount = 0;
        $amount = 200;
        foreach($this->teamMembers as $teamMember){
            if(!$teamMember->user->hasPaid()){
                $totalAmount += $amount;
            }
        }
        return $totalAmount;
    }
    function doPayment($txnid){
        foreach($this->teamMembers as $teamMember){
            if(!$teamMember->user->hasPaid()){
                $payment = new Payment();
                // Paid by the team leader
                $payment->paid_by = $this->user->id;
                $payment->user_id = $teamMember->id;
                $payment->transaction_id = $txnid;
                $teamMember->user->payment()->save($payment);
            }
        }
    }
}
