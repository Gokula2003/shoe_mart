<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Services\TwoFactorEmailService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;

class AuthenticateUser
{
    protected TwoFactorEmailService $twoFactorService;

    public function __construct(TwoFactorEmailService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }

    /**
     * Authenticate the user and send 2FA code if enabled
     */
    public function __invoke($request)
    {
        $request->validate([
            Fortify::username() => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where(Fortify::username(), $request->{Fortify::username()})->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                Fortify::username() => [trans('auth.failed')],
            ]);
        }

        // Email-based 2FA disabled - Using Google Authenticator only
        // $this->twoFactorService->generateAndSendCode($user);

        return $user;
    }
}
