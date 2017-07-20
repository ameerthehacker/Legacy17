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
        if($confirmed == 'no'){
            if(Auth::user()->hasConfirmed()){
                Session::flash('success', 'Sorry! you have already confirmed your events');         
                return redirect()->route('pages.dashboard');                                          
            }
        }
        else if($confirmed == 'yes'){
            if(!Auth::user()->hasConfirmed()){
                Session::flash('success', 'Sorry! you have not yet confirmed your events');         
                return redirect()->route('pages.dashboard');                                          
            }
        }
        return $next($request);
    }
}
