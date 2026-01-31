<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Admin Theme Styles */
        .admin-gradient {
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 50%, #1e3a5f 100%);
        }
        
        .admin-sidebar-gradient {
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
        }
        
        .admin-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }
        
        .admin-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transform: translateY(-2px);
        }
        
        .nav-link-admin {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link-admin::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #60a5fa, #a78bfa);
            transition: width 0.3s ease;
        }
        
        .nav-link-admin:hover::after {
            width: 100%;
        }
        
        .glow-effect {
            box-shadow: 0 0 20px rgba(96, 165, 250, 0.3);
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-slide-in {
            animation: slideIn 0.3s ease-out forwards;
        }
        
        .stat-card-gradient-purple { background: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%); }
        .stat-card-gradient-yellow { background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); }
        .stat-card-gradient-blue { background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%); }
        .stat-card-gradient-red { background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); }
        .stat-card-gradient-green { background: linear-gradient(135deg, #10b981 0%, #34d399 100%); }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-100 via-blue-50 to-slate-100 min-h-screen">
    <!-- Admin Loading Screen -->
    <x-admin-loading title="Admin Panel" message="Loading secure dashboard..." />
    
    <!-- Admin Navigation -->
    <nav class="admin-gradient shadow-2xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-white flex items-center space-x-2">
                        <span class="bg-white/20 p-2 rounded-lg">👑</span>
                        <span>ShoeMart Admin</span>
                    </a>
                    <div class="ml-10 flex items-center space-x-2">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link-admin text-white/90 hover:text-white px-4 py-2 rounded-lg hover:bg-white/10 transition-all font-medium flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.add-product') }}" class="nav-link-admin text-white/90 hover:text-white px-4 py-2 rounded-lg hover:bg-white/10 transition-all font-medium flex items-center space-x-2 bg-green-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span>Add Product</span>
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="nav-link-admin text-white/90 hover:text-white px-4 py-2 rounded-lg hover:bg-white/10 transition-all font-medium flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            <span>Orders</span>
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="nav-link-admin text-white/90 hover:text-white px-4 py-2 rounded-lg hover:bg-white/10 transition-all font-medium flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            <span>Products</span>
                        </a>
                        <a href="{{ route('admin.vouchers.index') }}" class="nav-link-admin text-white/90 hover:text-white px-4 py-2 rounded-lg hover:bg-white/10 transition-all font-medium flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path></svg>
                            <span>Vouchers</span>
                        </a>
                        <a href="{{ route('admin.gifts.index') }}" class="nav-link-admin text-white/90 hover:text-white px-4 py-2 rounded-lg hover:bg-white/10 transition-all font-medium flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                            <span>Gifts</span>
                        </a>
                        <a href="{{ route('admin.aftercare.index') }}" class="nav-link-admin text-white/90 hover:text-white px-4 py-2 rounded-lg hover:bg-white/10 transition-all font-medium flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Reservations</span>
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-3 bg-white/10 rounded-full px-4 py-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}
                        </div>
                        <span class="text-white font-medium">{{ Auth::guard('admin')->user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500/80 hover:bg-red-500 text-white px-4 py-2 rounded-lg transition-all flex items-center space-x-2 font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-r-xl shadow-lg animate-slide-in flex items-center space-x-3">
                <div class="flex-shrink-0 w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-r-xl shadow-lg animate-slide-in flex items-center space-x-3">
                <div class="flex-shrink-0 w-10 h-10 bg-red-500 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Admin Footer -->
    <footer class="mt-12 py-6 text-center text-gray-500 text-sm">
        <p>&copy; {{ date('Y') }} ShoeMart Admin Panel. All rights reserved.</p>
    </footer>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
