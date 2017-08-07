<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class CheckConfirmation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $confirmed)
    {
        // Check if user has confirmed his registrations
        $user = Auth::user();
        if($confirmed == 'no'){
            if(!$user->isParticipating()){
                Session::flash('success', 'You need to participate in atleast one single or team event to confirm the registration!');    
                return redirect()->route('pages.dashboard');                                    
            }
            if($user->hasConfirmed()){
                Session::flash('success', 'Sorry! you have already confirmed your events');
                return redirect()->route('pages.dashboard');                               
            }
            if(!$user->hasSureEvents()){
                Session::flash('success', 'Ask atleast one of your team leaders to confirm their registrations inorder to confirm your registration');
                return redirect()->route('pages.dashboard');                               
            }
        }
        else if($confirmed == 'yes'){
            if(!$user->hasConfirmed()){
                Session::flash('success', 'Sorry! you have not yet confirmed your events');         
                return redirect()->route('pages.dashboard');                                          
            }
        }
        return $next($request);
    }
}
