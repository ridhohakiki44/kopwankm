<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (! $request->user() || !in_array($request->user()->role, $roles)) {
            return redirect('/dashboard-no-role');
        }

        return $next($request);
    }
}
