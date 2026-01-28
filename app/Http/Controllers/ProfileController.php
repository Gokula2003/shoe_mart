<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function settings()
    {
        return view('profile.settings', [
            'user' => Auth::user()
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.settings')->with('success', 'Password updated successfully!');
    }

    public function updateAddress(Request $request)
    {
        $request->validate([
            'address' => ['required', 'string', 'max:500'],
        ]);

        $user = Auth::user();
        $user->address = $request->address;
        $user->save();

        return redirect()->route('profile.settings')->with('success', 'Address updated successfully!');
    }
}
