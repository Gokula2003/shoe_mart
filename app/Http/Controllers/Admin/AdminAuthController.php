<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminAuthController extends Controller
{
    const MAX_LOGIN_ATTEMPTS = 5;
    const LOCKOUT_DURATION = 30; // minutes

    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if account is locked
        $admin = Admin::where('email', $request->email)->first();
        
        if ($admin && $admin->locked_until && now()->lessThan($admin->locked_until)) {
            $minutesLeft = now()->diffInMinutes($admin->locked_until);
            \Log::channel('security')->warning('Login attempt on locked account', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'locked_until' => $admin->locked_until,
            ]);
            
            return back()->withErrors([
                'email' => "Account is locked due to too many failed attempts. Please try again in {$minutesLeft} minutes."
            ])->withInput();
        }

        // Attempt login
        if (Auth::guard('admin')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Reset failed attempts on successful login
            if ($admin) {
                $admin->update([
                    'failed_attempts' => 0,
                    'locked_until' => null,
                    'last_login_at' => now(),
                    'last_login_ip' => $request->ip(),
                ]);
            }
            
            \Log::channel('security')->info('Admin login successful', [
                'admin_id' => Auth::guard('admin')->id(),
                'email' => $request->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now(),
            ]);
            
            return redirect()->route('admin.dashboard');
        }

        // Handle failed login attempt
        if ($admin) {
            $admin->increment('failed_attempts');
            
            if ($admin->failed_attempts >= self::MAX_LOGIN_ATTEMPTS) {
                $admin->update([
                    'locked_until' => now()->addMinutes(self::LOCKOUT_DURATION)
                ]);
                
                \Log::channel('security')->alert('Admin account locked due to failed attempts', [
                    'email' => $request->email,
                    'ip' => $request->ip(),
                    'failed_attempts' => $admin->failed_attempts,
                ]);
                
                return back()->withErrors([
                    'email' => 'Account locked due to too many failed login attempts. Please try again in ' . self::LOCKOUT_DURATION . ' minutes.'
                ])->withInput();
            }
            
            $attemptsLeft = self::MAX_LOGIN_ATTEMPTS - $admin->failed_attempts;
            
            \Log::channel('security')->warning('Failed admin login attempt', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'failed_attempts' => $admin->failed_attempts,
                'attempts_left' => $attemptsLeft,
            ]);
            
            return back()->withErrors([
                'email' => "Invalid credentials. {$attemptsLeft} attempts remaining before account lockout."
            ])->withInput();
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function logout()
    {
        \Log::channel('security')->info('Admin logout', [
            'admin_id' => Auth::guard('admin')->id(),
            'ip' => request()->ip(),
            'timestamp' => now(),
        ]);
        
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    /**
     * Show the form for creating a new admin.
     */
    public function showCreateForm()
    {
        return view('admin.create-admin');
    }

    /**
     * Store a newly created admin.
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(12)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ], [
            'password.min' => 'Password must be at least 12 characters long.',
            'password.mixed_case' => 'Password must contain both uppercase and lowercase letters.',
            'password.numbers' => 'Password must contain at least one number.',
            'password.symbols' => 'Password must contain at least one special character.',
            'password.uncompromised' => 'This password has been found in data breaches. Please choose a different password.',
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'failed_attempts' => 0,
            'locked_until' => null,
        ]);

        \Log::channel('security')->info('New admin created', [
            'admin_id' => $admin->id,
            'email' => $admin->email,
            'created_by' => Auth::guard('admin')->id(),
            'created_by_ip' => $request->ip(),
            'timestamp' => now(),
        ]);

        return back()->with('success', 'Admin account created successfully with strong password protection!');
    }
}
