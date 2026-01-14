<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <!-- Admin Navigation -->
    <nav class="bg-blue-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-white">ShoeMart Admin</a>
                    <div class="ml-10 flex items-center space-x-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-blue-200 px-3 py-2">Dashboard</a>
                        <a href="{{ route('admin.orders.index') }}" class="text-white hover:text-blue-200 px-3 py-2">Orders</a>
                        <a href="{{ route('admin.products.index') }}" class="text-white hover:text-blue-200 px-3 py-2">Products</a>
                        <a href="{{ route('admin.aftercare.index') }}" class="text-white hover:text-blue-200 px-3 py-2">After Care Reservations</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white">{{ Auth::guard('admin')->user()->name }}</span>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="text-white hover:text-blue-200 px-3 py-2">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
