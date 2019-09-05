<?php

namespace App\Http\Middleware;

use Closure;

class CORS
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
        if($request->server('HTTP_ORIGIN')) {
            $origin = $request->server('HTTP_ORIGIN');
            // header('Access-Control-Allow-Origin: ' . $origin);
            header('Access-Control-Allow-Origin: *');
            // header('Access-Control-Allow-Origin','*');
            header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Accept, Authorization, X-Requested-With, Application');
            header('Access-Control-Expose-Headers: Content-Disposition');
        }
        // header('Access-Control-Allow-Origin: *');
        // header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        // header('Access-Control-Allow-Headers: Content-Type, Accept, Authorization, X-Requested-With, Application');
        return $next($request);
    }
}
