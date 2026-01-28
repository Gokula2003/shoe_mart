<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
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

        if (Auth::guard('admin')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            \Log::channel('security')->info('Admin login successful', [
                'admin_id' => Auth::guard('admin')->id(),
                'email' => $request->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now(),
            ]);
            
            return redirect()->route('admin.dashboard');
        }

        \Log::channel('security')->warning('Failed admin login attempt', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now(),
        ]);

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
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        \Log::channel('security')->info('New admin created', [
            'admin_id' => $admin->id,
            'email' => $admin->email,
            'created_by_ip' => $request->ip(),
            'timestamp' => now(),
        ]);

        return back()->with('success', 'Admin account created successfully! You can now login.');
    }
}
