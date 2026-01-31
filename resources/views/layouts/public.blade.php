<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ShoeMart') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased">
    <!-- Customer Loading Screen -->
    <x-loading title="ShoeMart" message="Loading your shopping experience..." />
    
    <!-- Navigation -->
    <header class="fixed top-0 left-0 right-0 z-50 glass backdrop-blur-md bg-white/80 shadow-sm">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-8">
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="ShoeMart Logo" class="h-12 w-auto">
                    </a>
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="/shop" class="text-gray-700 hover:text-purple-600 transition font-medium">Shop</a>
                        <a href="/about" class="text-gray-700 hover:text-purple-600 transition font-medium">About</a>
                        <a href="/contact" class="text-gray-700 hover:text-purple-600 transition font-medium">Contact</a>
                        <a href="/aftercare" class="text-gray-700 hover:text-purple-600 transition font-medium">After Care</a>
                        <a href="{{ route('vouchers.shop') }}" class="text-gray-700 hover:text-purple-600 transition font-medium">Vouchers</a>
                        <a href="{{ route('gift.send') }}" class="text-gray-700 hover:text-purple-600 transition font-medium">Send Gift</a>
                    </div>
                </div>
                @if (Route::has('login'))
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-purple-600 font-medium transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-purple-600 font-medium transition">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition shadow-lg">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </nav>
    </header>

    <!-- Page Content -->
    <main class="pt-20">
        {{ $slot }}
    </main>

    @livewireScripts
    
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
