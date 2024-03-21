<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role1, $role2)
    {
        if (Auth::check() && (Auth::user()->hasRole($role1) || Auth::user()->hasRole($role2))) {
            return $next($request);
        }

        /* return abort(403, 'Unauthorized action.');
        if (! $request->user()->hasRole($role)) { */
            return response()->json([
                'message' => $request->user()->hasRole($role)
            ],401);
        /* }
        return $next($request); */
    }
}
