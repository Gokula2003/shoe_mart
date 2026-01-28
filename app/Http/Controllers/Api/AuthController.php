<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Admin login to get API token
     * POST /api/admin/login
     */
    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            \Log::channel('security')->warning('Failed admin API login attempt', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Create token with expiration (24 hours)
        $tokenName = 'admin-api-' . now()->timestamp . '-' . $request->ip();
        $token = $admin->createToken($tokenName, ['*'], now()->addHours(24))->plainTextToken;

        \Log::channel('security')->info('Admin API login successful', [
            'admin_id' => $admin->id,
            'email' => $admin->email,
            'ip' => $request->ip(),
            'timestamp' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'admin' => [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'email' => $admin->email,
                ],
                'token' => $token,
                'expires_at' => now()->addHours(24)->toIso8601String(),
            ]
        ], 200);
    }

    /**
     * Admin logout - revoke token
     * POST /api/admin/logout
     */
    public function adminLogout(Request $request)
    {
        $user = $request->user();
        
        \Log::channel('security')->info('Admin API logout', [
            'admin_id' => $user->id,
            'email' => $user->email,
            'ip' => $request->ip(),
            'timestamp' => now(),
        ]);
        
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ], 200);
    }
}
