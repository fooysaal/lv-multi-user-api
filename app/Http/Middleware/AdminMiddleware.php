<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is an admin or developer
        if (!auth()->user()->user_type_id == 1 && !auth()->user()->user_type_id == 2) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
