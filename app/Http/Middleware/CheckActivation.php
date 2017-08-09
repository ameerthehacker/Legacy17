<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class CheckActivation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            if(Auth::user()->type == 'admin' || Auth::user()->activated){
                return $next($request);                            
            }
            else{
                Session::flash('info', 'You have not activated your account!');
                Auth::guard()->logout();                
                return redirect()->route('auth.login');
            }
        }
        else{
            return $next($request);            
        }
    }
}
