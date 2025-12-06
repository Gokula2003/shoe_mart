<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-blue-600">ShoeMart</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/" class="text-gray-700 hover:text-blue-600 px-3 py-2">Home</a>
                    <a href="/about" class="text-gray-700 hover:text-blue-600 px-3 py-2">About</a>
                    <a href="/order" class="text-gray-700 hover:text-blue-600 px-3 py-2">Order</a>
                    <a href="/contact" class="text-gray-700 hover:text-blue-600 px-3 py-2">Contact</a>
                    <a href="/aftercare" class="text-gray-700 hover:text-blue-600 px-3 py-2">After Care</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-md mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">Login to ShoeMart</h2>
            
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @session('status')
                <div class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded text-sm">
                    {{ $value }}
                </div>
            @endsession

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <div class="mb-6">
                    <button type="submit" class="btn-primary">
                        Confirm & Login
                    </button>
                </div>

                <div class="flex flex-col space-y-2 text-center">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800">
                            Forgot your password?
                        </a>
                    @endif
                    
                    @if (Route::has('register'))
                        <div class="text-sm text-gray-600">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Create Account</a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </main>
</body>
</html>
