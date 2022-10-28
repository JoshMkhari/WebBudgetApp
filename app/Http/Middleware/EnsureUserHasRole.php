<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasRole
{
    /**
     * Handle the incoming request.
     *
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role):mixed
    {
        if (! Auth::user()->role == $role) {
            // Redirect...
            return view('home');
        }

        return $next($request);
    }

}
