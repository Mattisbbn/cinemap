<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminOrOwnerLocation
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->is_admin) {
            return $next($request);
        }

        $location = $request->route('location');

        if ($location && $user && $user->id === $location->user_id) {
            return $next($request);
        }

        abort(403, "Accès réservé au propriétaire ou à l'administrateur.");
    }
}
