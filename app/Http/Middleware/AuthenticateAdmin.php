<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role_names)
    {
        if(Auth::user()->type == 'admin'){
            // Check if any role is needed for a route
            if(!empty($role_names)){
                $roles = explode('.', $role_names);
                foreach($roles as $role){
                    if(Auth::user()->hasRole($role)){
                        return $next($request); 
                    }
                }
                return redirect()->route('auth.login');                                
            }
            else{
                return $next($request);                 
            }
        }
        else{
            return redirect()->route('auth.login');
        }
    }
}
