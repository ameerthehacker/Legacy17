<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsOrganizing
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
        $event_id = $request->route('event_id');
        if(Auth::user()->organizings()->find($event_id) || Auth::user()->hasRole('root')){
            return $next($request);        
        }
        else{
            return redirect()->route('admin::root');
        }
    }
}
