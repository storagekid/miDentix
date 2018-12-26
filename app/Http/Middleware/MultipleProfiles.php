<?php

namespace App\Http\Middleware;

use Closure;

class MultipleProfiles
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
        // dd(auth()->user()->selectedProfile);
        if (count (auth()->user()->profiles) > 1 && !$request->session()->has('selectedProfile')) {
            return redirect()->route('profile-selector');
        } elseif (count (auth()->user()->profiles) == 1) {
            session([
                'selectedProfile' => auth()->user()->profiles[0]->id,
                'user_profile' => $user->profile->toArray(),
                'clinicsScope' => $user->profile->clinicIdsScope->toArray()
            ]);
        }
        return $next($request);
    }
}
