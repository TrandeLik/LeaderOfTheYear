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
        if (Auth::check()) {
            if (Auth::user()->role == 'student') {
                return redirect('user');
            }
            if (Auth::user()->role == 'banned') {
                return redirect('login');
            }
        } else {
            return redirect('login');
        }
        return $next($request);
    }
}
