<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests\EventRequest;
use App\User;
use App\Event;
use App\Category;
use Session;

class EventsController extends Controller
{
    function index(){
        $events = Event::paginate(10);
        return view('events.index')->with('events', $events);
    }
    function create(){
        $event = new Event();
        $event->max_members = 1;
        $event->min_members = 1;
        $event->allow_gender_mixing = 1;
        $categories = Category::pluck('name', 'id');
        $organizers = "";
        return view('events.create')->with('event', $event)->with('categories', $categories)->with('organizers', $organizers);
    }
    function store(EventRequest $request){
        $input = Request::all();
        // Upload file
        if(!empty($request->file('event_image'))){
            $filename = $request->file('event_image')->getClientOriginalName();
            $request->file('event_image')->move('images/events',  $filename);
            // Set image name
            $input['image_name'] = $filename;    
        }
        // Create event record    
        $event = Event::create($input);
        // Add organizers
        $organizerEmails = explode(",", $input['organizers']);
        foreach($organizerEmails as $organizerEmail){
            $organizer = User::where('email', $organizerEmail)->first();
            $event->organizers()->save($organizer);
        }
        // Set flash message
        Session::flash('success', 'The event was created successfully!');
        return redirect()->route('admin::events.create');
    }
    function edit($id){
        $event = Event::findOrFail($id);
        $categories = Category::pluck('name', 'id');
        $organizers = $event->getOrganizersList();        
        return view('events.edit')->with('event', $event)->with('categories', $categories)->with('organizers', $organizers);
    }
    function update(EventRequest $request, $id){
        $input = Request::all();
        // Get the event
        $event = Event::findOrFail($id);
        // Upload file
        if($request->file('event_image')){
            $filename = $request->file('event_image')->getClientOriginalName();
            $request->file('event_image')->move('images/events',  $filename);
            // Set image name
            $input['image_name'] = $filename;    
        }
        // Update event record    
        $event->update($input);
        // Update organizers
        $event->organizers()->detach();
        $organizerEmails = explode(",", $input['organizers']);
        foreach($organizerEmails as $organizerEmail){
            $organizer = User::where('email', $organizerEmail)->first();
            $event->organizers()->save($organizer);
        }
        // $event->organizers()->save();
        // Set flash message
        Session::flash('success', 'The event was edited successfully!');
        return redirect()->route('admin::events.index');
    }
    function destroy($id){
        // Delete the event record
        Event::destroy($id);
        \Session::flash('success', 'The event was deleted successfully!');
        return redirect()->route('admin::events.index');
    }
}
