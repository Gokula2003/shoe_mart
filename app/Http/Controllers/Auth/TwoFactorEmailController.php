<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\TwoFactorEmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorEmailController extends Controller
{
    protected TwoFactorEmailService $twoFactorService;

    public function __construct(TwoFactorEmailService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }

    /**
     * Show 2FA verification form
     */
    public function show()
    {
        return view('auth.two-factor-email');
    }

    /**
     * Verify 2FA code
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = Auth::user();

        if ($this->twoFactorService->isBlocked($user)) {
            return back()->withErrors([
                'code' => 'Too many failed attempts. Please try again in 1 hour.',
            ]);
        }

        if ($this->twoFactorService->verifyCode($user, $request->code)) {
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Two-factor authentication successful!');
        }

        return back()->withErrors([
            'code' => 'Invalid or expired verification code.',
        ]);
    }

    /**
     * Resend 2FA code
     */
    public function resend()
    {
        $user = Auth::user();

        if ($this->twoFactorService->resendCode($user)) {
            return back()->with('success', 'A new verification code has been sent to your email.');
        }

        return back()->withErrors([
            'code' => 'Please wait at least 1 minute before requesting a new code.',
        ]);
    }
}
