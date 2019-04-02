<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class LocaleMiddleWare
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
        app()->setLocale(Auth::user()->language);
        return $next($request);
    }
}
