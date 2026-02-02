<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\TwoFactorEmailCode;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class TwoFactorEmailService
{
    /**
     * Generate and send a 2FA code via email
     */
    public function generateAndSendCode(User $user): void
    {
        // Generate 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store code with 10 minute expiration
        $expiresAt = now()->addMinutes(10);
        
        $user->update([
            'two_factor_email_code' => bcrypt($code),
            'two_factor_email_code_expires_at' => $expiresAt,
        ]);
        
        // Send email notification
        $user->notify(new TwoFactorEmailCode($code));
        
        // Also cache for rate limiting (max 3 attempts per hour)
        Cache::remember(
            "2fa_attempts_{$user->id}",
            3600,
            fn() => 0
        );
    }

    /**
     * Verify the provided 2FA code
     */
    public function verifyCode(User $user, string $code): bool
    {
        // Check if code has expired
        if (!$user->two_factor_email_code_expires_at || 
            now()->greaterThan($user->two_factor_email_code_expires_at)) {
            return false;
        }

        // Increment attempt counter
        $attempts = Cache::increment("2fa_attempts_{$user->id}");
        
        // Block if too many attempts
        if ($attempts > 5) {
            Cache::put("2fa_blocked_{$user->id}", true, 3600);
            return false;
        }

        // Verify code
        $isValid = password_verify($code, $user->two_factor_email_code);

        if ($isValid) {
            // Clear code after successful verification
            $user->update([
                'two_factor_email_code' => null,
                'two_factor_email_code_expires_at' => null,
            ]);
            
            Cache::forget("2fa_attempts_{$user->id}");
            Cache::forget("2fa_blocked_{$user->id}");
        }

        return $isValid;
    }

    /**
     * Check if user is blocked from 2FA attempts
     */
    public function isBlocked(User $user): bool
    {
        return Cache::has("2fa_blocked_{$user->id}");
    }

    /**
     * Resend 2FA code (with rate limiting)
     */
    public function resendCode(User $user): bool
    {
        $lastSent = Cache::get("2fa_last_sent_{$user->id}");
        
        // Prevent resending within 1 minute
        if ($lastSent && now()->diffInSeconds($lastSent) < 60) {
            return false;
        }

        $this->generateAndSendCode($user);
        Cache::put("2fa_last_sent_{$user->id}", now(), 3600);
        
        return true;
    }
}
