<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestOrPasien
{
    //yg bisa akses antara ga logged in, atau kalo logged in, wajib pasien
    public function handle($request, Closure $next)
    {
        // Guest boleh
        if (!auth()->check()) {
            return $next($request);
        }

        // Login + role pasien boleh
        if (
            auth()->check() &&
            auth()->user()->role === 'pasien' &&
            auth()->user()->hasVerifiedEmail()
        ) {
            return $next($request);
        }

        // Role lain → tolak
        abort(403);
    }

}