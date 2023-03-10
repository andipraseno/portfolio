<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authorizer
{
    public function handle($request, Closure $next)
    {
        if (!$request->session()->exists('user_id')) {
            return redirect('/');
        } else {
            if ($request->session()->get('lockscreen') == 2) {
                return redirect('/');
            }

            return $next($request);
        }
    }
}
