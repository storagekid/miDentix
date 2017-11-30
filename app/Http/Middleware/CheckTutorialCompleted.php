<?php

namespace App\Http\Middleware;

use Closure;

class CheckTutorialCompleted
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
        if (auth()->user()->profile->tutorial_completed) {
            return redirect()->route('tutorial');
        }
        return $next($request);
    }
}
