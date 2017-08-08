<?php

namespace App\Traits;

use App\User;
use App\Event;
use App\Team;
use App\Rejection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

trait Utilities{
    private function checkIsParallelEvent($registered_events, $event){
        foreach($registered_events as $registered_event){
            // Date of the event to be registered
            $event_date = date_create($event->event_date);
            // Date of the registered event
            $registered_event_date = date_create($registered_event->event_date);
            // Start and end time of event being registered
            $start_time = strtotime($event->start_time);
            $end_time = strtotime($event->end_time);       
            //  Start and end time of event already registered
            $registered_start_time = strtotime($registered_event->start_time);
            $registered_end_time = strtotime($registered_event->end_time);                
            // Check whether they occur in parallel
            if($event_date == $registered_event_date){
                if(($registered_start_time <= $start_time && $start_time < $registered_end_time) || ($end_time > $registered_start_time && $end_time <= $registered_end_time)){
                    return $registered_event;                 
                }                    
            }
        }
        return false;
    }
    private function rejectOtherUsers($user_id){
        $user = User::find($user_id);
        foreach($user->events as $event){
            if($user->college->noOfParticipantsForEvent($event->id) >= $event->max_limit){
                // Take all students from this college
                foreach($user->college->users as $user){
                    if($user->hasRegisteredEvent($event->id) && !$user->hasPaid()){
                        $user->events()->detach($event->id);
                        $rejection = new Rejection();
                        $rejection->event_id = $event->id;
                        $rejection->user_id = $user->id;
                        $user->rejections()->save($rejection);
                        // Remove the confirmation request if not participating
                        if($user->needApproval() && !$user->isParticipating() && $user->hasConfirmed()){
                            $user->confirmation->status = 'nack';
                            $user->confirmation->message = 'Your request was rejected as maximum registrations from your college is reached';                            
                            $user->confirmation->save();
                        }
                    }
                }
            }
        }
    }
    private function rejectOtherTeams($user_id){
        $user = User::find($user_id);        
        foreach($user->teamEvents() as $event){
            if($user->college->noOfParticipantsForEvent($event->id) >= $event->max_limit){
                // Take all students from this college
                foreach($user->college->users as $user){
                    if($user->hasRegisteredEvent($event->id) && $user->isTeamLeader($event->id) && !$user->hasPaidForTeams()){
                        // Remove the team
                        $team = $user->teamLeaderFor($event->id);
                        $event->teams()->detach($team->id);
                        foreach($team->teamMembers as $teamMember){
                            $rejection = new Rejection();
                            $rejection->event_id = $event->id;
                            $rejection->user_id = $teamMember->user->id;
                            $teamMember->user->rejections()->save($rejection);
                        }
                        $team->teamMembers()->delete();
                        Team::destroy($team->id);
                        $user->events()->detach($event->id);
                        $rejection = new Rejection();
                        $rejection->event_id = $event->id;
                        $rejection->user_id = $user->id;
                        $user->rejections()->save($rejection);
                        if(!$user->isParticipating() && $user->hasConfirmed()){
                            // Remove the confirmation request if not participating           
                            $user->confirmation->status = 'nack';
                            $user->confirmation->message = 'Your request was rejected as maximum registrations from your college is reached';                            
                            $user->confirmation->save();
                        }
                    }
                }
            }
        }
    }
    private function rejectOtherRegistrations($user_id){
        $user = User::find($user_id);        
        // Reject events for other users which are filled
        $this->rejectOtherUsers($user->id);
        // Reject team events for other users which are filled
        $this->rejectOtherTeams($user->id);
        // Reject the individual events that are confirmed for his teammembers
        foreach($user->teams as $team){
            foreach($team->teamMembers as $teamMember){
                $this->rejectOtherUsers($teamMember->user->id);
            }
        }
    }
    private function userHasParallelEvent($user_id, $event_id){
        $user = User::find($user_id);
        $event = Event::find($event_id);
        $registered_events = $user->events;
        // Check for single events
        if($parallel_event = $this->checkIsParallelEvent($registered_events, $event)){
            return $parallel_event;
        }
        $registered_events = $user->teamEvents();
        // Check for group events
        if($parallel_event = $this->checkIsParallelEvent($registered_events, $event)){
            return $parallel_event;
        }
        return false;
    }
    private function paginate($page, $perPage, $items)
    {
        $offSet = ($page * $perPage) - $perPage;
        $itemsForCurrentPage = $items->slice($offSet, $perPage);
        return new LengthAwarePaginator(
            $itemsForCurrentPage, $items->count(), $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );
    }
}