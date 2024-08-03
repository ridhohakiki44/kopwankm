<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = $request->user();

        // Jika pengguna baru atau tanpa role, arahkan ke laman welcome (pendaftaran anggota)
        if (empty($user->role)) {
            return redirect('/welcome');
        }

        // Jika pengguna memiliki salah satu role yang diperbolehkan, lanjutkan request
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika role tidak sesuai, arahkan ke dashboard atau halaman yang sesuai
        return redirect('/unauthorized');
    }
}
