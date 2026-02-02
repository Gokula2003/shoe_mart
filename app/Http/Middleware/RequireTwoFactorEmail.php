<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireTwoFactorEmail
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // If user has 2FA email pending verification
        if ($user && 
            $user->two_factor_email_code && 
            $user->two_factor_email_code_expires_at &&
            now()->lessThan($user->two_factor_email_code_expires_at)) {
            
            // Allow access to 2FA verification routes
            if ($request->routeIs('two-factor.login', 'two-factor.resend')) {
                return $next($request);
            }

            return redirect()->route('two-factor.login')
                ->with('message', 'Please verify your two-factor authentication code.');
        }

        return $next($request);
    }
}
