<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoRoleMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!empty($request->user()->role)) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
