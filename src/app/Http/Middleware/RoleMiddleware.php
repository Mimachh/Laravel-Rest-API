<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        foreach ($roles as $role) {
            if ($user->roles->contains('id', $role)) {
                return $next($request);
                // return response()->json(['message' => 'Vous avez accès en tant que ' . $role], 200);
            }
        }

        // abort(403, 'Unauthorized');
        return response()->json(['error' => '[ROLE_ERROR]Unauthorized'], 403);
    }
}
