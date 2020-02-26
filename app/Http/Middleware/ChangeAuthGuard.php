<?php

namespace App\Http\Middleware;

use Closure;

class ChangeAuthGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next, $guard)
    {
        app()->singleton('auth.driver', function ($app) use($guard) {
            return $app['auth']->guard($guard);
        });

        return $next($request);
    }
}
