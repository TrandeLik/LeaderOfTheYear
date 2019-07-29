<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
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
        if (Auth::user()->role == 'student') {
            return redirect('/error');
        }
        if (Auth::user()->role == 'banned') {
            return redirect('/alert_for_banned_users');
        }

        return $next($request);
    }
}
