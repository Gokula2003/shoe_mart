<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;

class AllowAdminCreationIfNone
{
    /**
     * Handle an incoming request.
     * Only allow admin creation if no admins exist OR if in local environment.
     */
    public function handle(Request $request, Closure $next)
    {
        // Allow in local/development environment
        if (app()->environment('local', 'development')) {
            return $next($request);
        }

        // In production, only allow if no admin users exist yet
        if (Admin::count() === 0) {
            return $next($request);
        }

        // Otherwise, redirect with error
        return redirect()->route('admin.login')
            ->with('error', 'Admin creation is disabled. Contact system administrator.');
    }
}
