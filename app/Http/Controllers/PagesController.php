<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Registration;
use Auth;


class PagesController extends Controller
{
    function dashboard(){
        $events = Auth::user()->events;
        return view('pages.dashboard')->with('events', $events);
    }
    function about(){
        return view('pages.about');
    }
    function events(){
        if(Auth::check()){
            $user  = Auth::user();
            // Get ids of registered events
            $registeredEventIds = Registration::all()->where('registration_id', $user->id)->pluck('event_id');
            // Get only events that are not registered
            $events = Event::all()->whereNotIn('id', $registeredEventIds);
        }
        else{
            $events = Event::all();                 
        }
        return view('pages.events')->with('events', $events);
    }
    function register($id){
        $event = Event::findOrFail($id);
        $user = Auth::user();
        $response = [];
        if($user->events->find($id)){
            $response['error'] = true;
            $response['message'] = 'You have already registered for this event';
        }
        else{
            $registered_events = $user->events;
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
                        $response['error'] = true;
                        $response['message'] = "Sorry! you have a registered a parallel event $registered_event->title";
                        return response()->json($response);                    
                    }                    
                }
            }
            $user->events()->save($event);
            $response['error'] = false;
        }
        return response()->json($response);
    }
    function unregister($id){
        $event = Event::findOrFail($id);
        $user = Auth::user();
        $response = [];
        if($user->events->find($id)){   
            $registration = Registration::all()->where('registration_id', $user->id)->where('event_id', $event->id)->first();
            $registration->delete();
        }
        return  redirect()->route('pages.dashboard');
    }
}
