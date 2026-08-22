<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        // Use the elegant isTenant() method you already built in the User model!
        if (auth()->check() && auth()->user()->isTenant()) {
            return $next($request);
        }

        abort(403, 'Acesso restrito: Apenas inquilinos podem acessar esta área.');
    }
}
