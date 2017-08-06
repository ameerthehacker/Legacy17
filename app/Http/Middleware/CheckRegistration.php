<?php

namespace App\Http\Middleware;

use Closure;
use App\Event;
use App\Team;
use Session;
use Auth;
use App\Traits\Utilities;

class CheckRegistration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    use Utilities;

    public function handle($request, Closure $next, $type, $registered)
    {
        // Check if user has confirmed his registrations
        if(Auth::user()->hasConfirmed()){
            Session::flash('success', 'Sorry! you have already confirmed your events');         
            return redirect()->route('pages.dashboard');                                            
        }
        $event_id = $request->route('event_id');
        $event = Event::find($event_id);
        // Check if team exists
        if($type == 'team' && $registered == 'yes'){
            $team_id = $request->route('id');
            $team = Team::find($team_id);
            if(!$team){
                return redirect()->route('pages.events');                                                       
            }
        }
        // Check if event exists        
        if($event){
            $user = Auth::user();                    
            // Check if the event being registered is single and the actual event type is single
            if($type == 'single' && $event->isGroupEvent()){
                Session::flash('success', 'Sorry! its not a single participating event');
                return redirect()->route('pages.events');                
            }
            else if($type == 'team' && !$event->isGroupEvent()){
                Session::flash('success', 'Sorry! its not a team participating event');     
                return redirect()->route('pages.events');                                                           
            }
            if($registered == 'no'){
                if(!$user->hasRegisteredEvent($event->id)){
                    if($registered_event = $this->userHasParallelEvent(Auth::user()->id, $event->id)){
                        if($request->ajax()){
                            $response['error'] = true;
                            $response['message'] = "Sorry! you have registered a parallel event $registered_event->title";
                            return response()->json($response); 
                        }
                        else{
                             Session::flash('success', "Sorry! you have registered a parallel event $registered_event->title");
                             return redirect()->route('pages.events');  
                        }
                    }
                    else{
                        if($user->college->noOfParticipantsForEvent($event->id) >= $event->max_limit){
                            if($request->ajax()){
                                $response['error'] = true;
                                $response['message'] = "Sorry! the maximum registration limit for this event from your college is reached";
                                return response()->json($response); 
                            }
                            else{
                                Session::flash('success', "Sorry! the maximum registration limit for this event from your college is reached");
                                return redirect()->route('pages.events');  
                            }
                        }
                        else{
                            return $next($request);                                                    
                        }
                    }
                }
                else{
                    Session::flash('success', 'Sorry! you have already registered for this event');                
                }
            }
            else if($registered == 'yes'){
                if($user->hasRegisteredEvent($event->id)){
                    if($event->isGroupEvent()){
                        if($user->isTeamLeader($event->id)){
                            return $next($request);
                        }
                        else{
                            Session::flash('success', 'Sorry! only team leaders can unregister teams');
                            return redirect()->route('pages.dashboard');   
                        }                   
                    }
                    else{
                        return $next($request);                                           
                    }
                }
                else{
                    Session::flash('success', 'Sorry! you have not registered for this event');                
                    return redirect()->route('pages.dashboard'); 
                }
            }
            return redirect()->route('pages.events');                                            
        }
        else{
            return redirect()->route('pages.events');                                
        }
    }
    
    
}
