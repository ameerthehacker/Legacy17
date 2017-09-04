<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    protected $fillable = ['full_name', 'email', 'password', 'gender', 'college_id', 'mobile', 'activated', 'activation_code'];
    function events(){
        return $this->morphToMany('\App\Event', 'registration');
    }
    function confirmation(){
        return $this->hasOne('App\Confirmation');
    }
    function payment(){
        return $this->hasOne('App\Payment');
    }
    function roles(){
        return $this->belongsToMany('App\Role');
    }
    function rejections(){
        return $this->hasMany('App\Rejection');
    }
    function accomodation(){
        return $this->hasOne('App\Accomodation');
    }
    function organizings(){
        return $this->belongsToMany('App\Event', 'organizings');
    }
    // Get all the users to be paid by the user eliminating duplicates
    function getUsersToPay(){
        $userIds = [];
        $users = [];
        // Add the current user and his id
        array_push($userIds, $this->id);
        array_push($users, $this);
        // Get ids of all member users without duplication
        foreach($this->teams as $team){
            foreach($team->teamMembers as $teamMember){
                if(array_search($teamMember->user->id, $userIds) === false){
                    array_push($userIds, $teamMember->user->id);
                    // Push the user as he is not being duplicated
                    array_push($users, $teamMember->user);        
                }
            }
        }
        $usersToPay = [];
        // Get users to be paid
        foreach($users as $user){
            if(!$user->hasPaid()){
                array_push($usersToPay, $user);            
            }
        }
        
        return $usersToPay;
    }
    function hasRequestedAccomodation(){
        if($this->accomodation){
            return true;
        }
        else{
            return false;
        }
    }
    function hasAccomodationAcknowledged(){
        if($this->hasRequestedAccomodation() && $this->accomodation->status){
            return true;
        }
        else{
            return false;
        }
    }
    function hasPaid(){
        if($this->payment == null){
            return false;
        }
        else{
            return  true;
        }
    }
    function payments(){
        return $this->hasMany('App\Payment', 'paid_by');
    }
    // Check if the user is organizing an event
    function isOrganizing($event_id){
        if($this->organizings()->find($event_id)){
            return true;
        }
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
             if($this->events()->find($event_id)){
                 return true;
             }
             else{
                 return false;
             }
        }
        return false;
    }
    function college(){
        // Get the college of the student
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
            if(!empty($this->confirmation->file_name)){
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
    function isParticipating(){
        if($this->events()->count() == 0 && $this->teams()->count() == 0 && $this->teamMembers()->count() == 0){
            return false;
        }
        else{
            return true;
        }
    }
    function hasConfirmedTeams(){
        foreach($this->teams as $team){
            if(!$team->isConfirmed()){
                return false;
            }
        }
        return true;
    }
    function canConfirm(){
        if($this->isParticipating()){
            if($this->hasSureEvents()){
                return true;
            }
            else{
                return false;                
            }
        }
        else{
            return false;
        }
    }
    function hasTeams(){
        $teamCount = $this->teams->count();  
        return $teamCount; 
    }
    function isAcknowledged(){
        if($this->hasConfirmed()){
            if($this->confirmation->status){
                return true;
            }
        }
        return false;
    }
    function isConfirmed(){
        if($this->needApproval()){
            if($this->hasConfirmed() && $this->confirmation->status == 'ack'){
                return true;                
            }
        }
        else{
            foreach($this->teamMembers as $teamMember){
                if($teamMember->team->user->isConfirmed()){
                    return true;
                }
            }
        }
        return false;
    }
    function hasPaidForTeams(){
        foreach($this->teams as $team){
            if(!$team->isPaid()){
                return false;
            }
        }
        return true;
    }
    function getTotalAmount(){
        $transactionFee = Payment::getTransactionFee();
        $totalAmount = 0;
        $amount = Payment::getEventAmount();
        foreach($this->getUsersToPay() as $userToPay){
            $totalAmount += $amount;
        }
        // Very Very important Add the transaction fee
        $totalAmount += $totalAmount*$transactionFee;
        return $totalAmount;
    }
    function getTotalAmountPaid(){
        $transactionFee = Payment::getTransactionFee();
        $totalAmount = 0;
        $amount = Payment::getEventAmount();
        foreach($this->payments as $payment){
            $totalAmount += $amount;
        }
        // Very Very important Add the transaction fee
        $totalAmount += $totalAmount*$transactionFee;
        return $totalAmount;
    }
    function doPayment($txnid){
        foreach($this->getUsersToPay() as $user){
            $payment = new Payment();
            $payment->paid_by = $this->id;
            $payment->user_id = $user->id;
            $payment->transaction_id = $txnid;
            $user->payment()->save($payment);
        }
    }
    function getTransactionId(){
        $uid = "LG17_" . $this->id . '_' . strrev(time());
        $uid = substr($uid, 0,25);
        return $uid;
    }
    function getAccomodationAmount(){
        $amount = Payment::getAccomodationAmount() * $this->accomodation->days;
        $totalAmount = $amount + $amount * Payment::getTransactionFee();
        return $totalAmount;
    }
    function getHash($amount){
        $key = Payment::getPaymentKey();
        $salt = Payment::getPaymentSalt();
        $txnid = $this->getTransactionId();
        $productInfo = Payment::getProductInfo()        ;
        $firstname = $this->full_name;
        $email = $this->email;
        $hashFormat = "$key|$txnid|$amount|$productInfo|$firstname|$email|||||||||||$salt";
        $hash = strtolower(hash('sha512', $hashFormat));
        return $hash;
    }
    // Check if the user has the given role
    function hasRole($role_name){
        if($this->roles()->where('role_name', $role_name)->count()){
            return true;
        }
        return false;
    }
    function LGId(){
        return 'LG' . $this->id;
    }
    function hasActivated(){
        if($this->activated == true){
            return true;
        }
        else{
            return false;
        }
    }
    function isRejected(){
        if($this->confirmation && $this->confirmation->status == 'nack'){
            return true;
        }
        return false;
    }
    function hasOnlyTeamEvents(){
        if($this->events()->count() == 0 && $this->teams()->count() == 0 && $this->teamMembers()->count() != 0){
            return true;
        }
        else{
            return false;
        }
    }
    function hasSureEvents(){
        if($this->events()->count() == 0 && $this->teams()->count() == 0 && $this->teamMembers()->count() != 0){
            foreach($this->teamMembers as $teamMember){
                if($teamMember->team->user->hasConfirmed()){
                    return true;
                }
            }
            return false;
        }
        else{
            return true;
        }
    }
    static function search($term){
        $college_ids = College::where('name', 'LIKE', $term)->pluck('id')->toArray();        
        $users = self::where('id', 'LIKE', $term)->orWhere('full_name', 'LIKE', $term)->orWhere('email', 'LIKE', $term)->orWhere('gender', 'LIKE', $term)->orWhere('mobile', 'LIKE', $term)->orWhereIn('college_id', $college_ids);  

        return $users;
    }
}
