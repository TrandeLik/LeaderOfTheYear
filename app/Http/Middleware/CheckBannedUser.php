<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckBannedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'banned') {
                return $next($request);
            } else {
                if ((Auth::user()->role == 'admin') || (Auth::user()->role == 'superadmin')) {
                    return redirect('/');
                } else {
                    return redirect('/user');
                }
            }
        } else {
            return redirect('login');
        }
    }

}

