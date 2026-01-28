<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiToken
{
    /**
     * Handle an incoming request.
     * Additional validation for API tokens
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() && $request->is('api/*')) {
            // Check if the route requires authentication
            $publicRoutes = [
                'api/products',
                'api/products/*',
            ];

            foreach ($publicRoutes as $route) {
                if ($request->is($route)) {
                    return $next($request);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Please provide a valid API token.'
            ], 401);
        }

        return $next($request);
    }
}
