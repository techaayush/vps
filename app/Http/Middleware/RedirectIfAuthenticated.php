<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect('/dashboard');
        }


        /*if(session('user_role')=="admin")
        {
            info("User already logged in");
            return Redirect::route('admin.dashboard');
        }
        elseif(session('user_role')=="vendor" && session('vendor_type')=="paid")
        {
            info("User already logged in");
            return Redirect::route('vendor.dashboard');
        }
        */
        return $next($request);
    }
}
