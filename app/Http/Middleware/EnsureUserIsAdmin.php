<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Kick out anyone who is not logged in or is not an Admin
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, 'Acesso negado. Esta área é restrita aos administradores do sistema.');
        }

        return $next($request);
    }
}
