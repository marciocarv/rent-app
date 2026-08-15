<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsLandlord
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is logged in AND is a landlord
        if ($request->user() && $request->user()->isLandlord()) {
            return $next($request); // Let them pass
        }

        // If they are a tenant (or anything else), throw a 403 Forbidden error
        abort(403, 'Unauthorized action. Only landlords can access this area.');
    }
}
