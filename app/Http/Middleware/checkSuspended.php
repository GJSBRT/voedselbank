<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkSuspended
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check() && (auth()->user()->suspended_at)){
            auth()->guard('web')->logout();

            return redirect()->route('login')->dangerBanner('Jouw account is geblokkeerd, neem contact op met de directie.');
        }

        return $next($request);
    }
}
