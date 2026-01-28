<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .value-card { position: relative; overflow: hidden; }
        .value-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #667eea, #764ba2); }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-purple-50 min-h-screen pt-20">
    <!-- Navigation -->
    <x-navigation />

    <!-- Hero Section -->
    <div class="hero-gradient py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 animate-fade-in">About ShoeMart</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto animate-fade-in" style="animation-delay: 0.2s;">
                Your premier destination for quality footwear since day one
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <!-- Story Section -->
        <div class="grid md:grid-cols-2 gap-12 items-center mb-20">
            <div class="animate-fade-in">
                <span class="text-purple-600 font-semibold text-sm uppercase tracking-wider">Our Journey</span>
                <h2 class="text-4xl font-bold text-gray-900 mt-2 mb-6">Our Story</h2>
                <p class="text-lg text-gray-700 leading-relaxed mb-4">
                    Welcome to ShoeMart, your premier destination for quality footwear. We've been serving customers 
                    with the finest selection of shoes since our founding, and we're committed to providing exceptional 
                    products and customer service.
                </p>
                <p class="text-lg text-gray-700 leading-relaxed">
                    ShoeMart was founded with a simple mission: to provide high-quality, comfortable, and stylish 
                    footwear for everyone. What started as a small family business has grown into a trusted name 
                    in the footwear industry.
                </p>
            </div>
            <div class="relative animate-fade-in" style="animation-delay: 0.3s;">
                <div class="absolute -top-6 -right-6 w-72 h-72 bg-purple-200 rounded-full opacity-50 blur-3xl"></div>
                <div class="relative bg-gradient-to-br from-purple-100 to-blue-100 rounded-3xl p-12 text-center">
                    <div class="text-8xl mb-4">👟</div>
                    <p class="text-gray-600 font-medium">Quality Footwear Since Day One</p>
                </div>
            </div>
        </div>

        <!-- Values Section -->
        <div class="mb-20">
            <div class="text-center mb-12">
                <span class="text-purple-600 font-semibold text-sm uppercase tracking-wider">What We Believe</span>
                <h2 class="text-4xl font-bold text-gray-900 mt-2">Our Values</h2>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="value-card bg-white rounded-2xl p-6 shadow-lg card-hover">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-900 mb-2">Quality First</h3>
                    <p class="text-gray-600">We source only the best materials and partner with reputable manufacturers.</p>
                </div>
                <div class="value-card bg-white rounded-2xl p-6 shadow-lg card-hover" style="animation-delay: 0.1s;">
                    <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-900 mb-2">Customer Satisfaction</h3>
                    <p class="text-gray-600">Your happiness is our top priority in everything we do.</p>
                </div>
                <div class="value-card bg-white rounded-2xl p-6 shadow-lg card-hover" style="animation-delay: 0.2s;">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-900 mb-2">Sustainability</h3>
                    <p class="text-gray-600">We're committed to environmentally responsible practices.</p>
                </div>
                <div class="value-card bg-white rounded-2xl p-6 shadow-lg card-hover" style="animation-delay: 0.3s;">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-900 mb-2">Innovation</h3>
                    <p class="text-gray-600">We stay ahead of trends while respecting timeless styles.</p>
                </div>
            </div>
        </div>

        <!-- Why Choose Us Section -->
        <div class="mb-20">
            <div class="text-center mb-12">
                <span class="text-purple-600 font-semibold text-sm uppercase tracking-wider">Benefits</span>
                <h2 class="text-4xl font-bold text-gray-900 mt-2">Why Choose Us?</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-8 rounded-3xl border border-purple-200 card-hover">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-lg flex items-center justify-center mb-6 text-3xl">
                        👠
                    </div>
                    <h3 class="font-bold text-xl text-gray-900 mb-3">Wide Selection</h3>
                    <p class="text-gray-700">From casual to formal, athletic to fashion-forward, we have shoes for every occasion.</p>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-3xl border border-blue-200 card-hover">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-lg flex items-center justify-center mb-6 text-3xl">
                        🎯
                    </div>
                    <h3 class="font-bold text-xl text-gray-900 mb-3">Expert Service</h3>
                    <p class="text-gray-700">Our knowledgeable team is here to help you find the perfect fit.</p>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-8 rounded-3xl border border-green-200 card-hover">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-lg flex items-center justify-center mb-6 text-3xl">
                        💰
                    </div>
                    <h3 class="font-bold text-xl text-gray-900 mb-3">Competitive Prices</h3>
                    <p class="text-gray-700">Quality footwear at prices that won't break the bank.</p>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="hero-gradient rounded-3xl p-12 text-center relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
            </div>
            <div class="relative">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Ready to Find Your Perfect Pair?</h2>
                <p class="text-white/90 text-lg mb-8 max-w-2xl mx-auto">Browse our collection and step into style today!</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-white text-purple-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all shadow-xl hover:shadow-2xl transform hover:scale-105">
                    Shop Now →
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-20">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-400">&copy; {{ date('Y') }} ShoeMart. All rights reserved.</p>
        </div>
    </footer>
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
