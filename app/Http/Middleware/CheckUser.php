<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(Auth::check() && Auth::user()->role_id == 2)
        {   
            if(Auth::user()->status == 'inactive'){
                Auth::logout();
                return redirect()->back()->with('msg', 'Your account is pending for approval. We will let you know once it is approved.');
            }
            else{
                 Auth::logout();
                // return redirect()->route('admin.dash');
                 return redirect()->back()->with('msg', 'You cannot login');
            }
           
        }


        if(Auth::check() && Auth::user()->role_id == 1)
        {
            return redirect()->route('admin.dash');
        }


        return $next($request);
    }
}
