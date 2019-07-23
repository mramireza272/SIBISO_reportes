<?php

namespace App\Http\Middleware;

use Closure;

class Version
{

    const VERSION = '1.1.1';


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        \Session::put('Current.version',SELF::VERSION);
        return $next($request);
    }
}
