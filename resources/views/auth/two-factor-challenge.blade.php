<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Two-Factor Authentication - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(135deg, #0f766e 0%, #14b8a6 25%, #2dd4bf 50%, #5eead4 75%, #99f6e4 100%);">
    <div class="w-full max-w-lg">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden" x-data="{ recovery: false }">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-8 py-10 text-center">
                <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Authenticator Verification</h1>
                <p class="text-emerald-100" x-show="! recovery">Enter your authenticator code</p>
                <p class="text-emerald-100" x-cloak x-show="recovery">Enter your recovery code</p>
            </div>

            <!-- Content Section -->
            <div class="p-8">
                <x-validation-errors class="mb-6" />

                <div class="mb-6 text-center">
                    <p class="text-gray-600 leading-relaxed" x-show="! recovery">
                        {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                    </p>
                    <p class="text-gray-600 leading-relaxed" x-cloak x-show="recovery">
                        {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                    </p>
                </div>

                <form method="POST" action="{{ route('two-factor.login') }}">
                    @csrf

                    <!-- Authenticator Code Input -->
                    <div class="mb-6" x-show="! recovery">
                        <label for="code" class="block text-sm font-semibold text-gray-700 mb-3">Authentication Code</label>
                        <input id="code" type="text" name="code" inputmode="numeric" autocomplete="one-time-code" autofocus x-ref="code" 
                            class="w-full px-4 py-4 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:border-emerald-600 focus:ring-4 focus:ring-emerald-600/20 transition-all duration-200 bg-gray-50 focus:bg-white">
                    </div>

                    <!-- Recovery Code Input -->
                    <div class="mb-6" x-cloak x-show="recovery">
                        <label for="recovery_code" class="block text-sm font-semibold text-gray-700 mb-3">Recovery Code</label>
                        <input id="recovery_code" type="text" name="recovery_code" autocomplete="one-time-code" x-ref="recovery_code"
                            class="w-full px-4 py-4 text-center text-lg font-mono border-2 border-gray-300 rounded-xl focus:border-emerald-600 focus:ring-4 focus:ring-emerald-600/20 transition-all duration-200 bg-gray-50 focus:bg-white">
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col gap-3">
                        <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white py-4 px-6 rounded-xl font-bold text-lg hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            {{ __('Log in') }}
                        </button>

                        <!-- Toggle Recovery/Code -->
                        <button type="button" 
                            x-show="! recovery"
                            x-on:click="recovery = true; $nextTick(() => { $refs.recovery_code.focus() })"
                            class="w-full bg-gray-100 hover:bg-gray-200 text-emerald-600 py-3 px-4 rounded-xl font-semibold transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            {{ __('Use a recovery code') }}
                        </button>

                        <button type="button"
                            x-cloak
                            x-show="recovery"
                            x-on:click="recovery = false; $nextTick(() => { $refs.code.focus() })"
                            class="w-full bg-gray-100 hover:bg-gray-200 text-emerald-600 py-3 px-4 rounded-xl font-semibold transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
                            </svg>
                            {{ __('Use an authentication code') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-white/80 backdrop-blur-sm border border-emerald-200 rounded-2xl p-5 text-sm text-emerald-800 shadow-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 mt-0.5 mr-3 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <div>
                    <p class="font-semibold mb-1 text-emerald-900">Secure Authentication</p>
                    <p class="text-emerald-700">Your account is protected with two-factor authentication. Open your authenticator app to get your code.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
