<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .product-card { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .product-card:hover { transform: translateY(-8px) scale(1.02); }
        .product-image { transition: all 0.3s ease; }
        .product-card:hover .product-image { transform: scale(1.05); }
        .price-tag { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .view-btn { transition: all 0.3s ease; }
        .view-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 30px -5px rgba(102, 126, 234, 0.4); }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease forwards; }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-purple-50 min-h-screen">
    <!-- Navigation -->
    <x-navigation />

    <!-- Hero Section -->
    <div class="hero-gradient py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;"></div>
        </div>
        <!-- Floating Shoe Icons -->
        <div class="absolute top-10 left-10 text-4xl opacity-20 animate-bounce">👟</div>
        <div class="absolute top-20 right-20 text-5xl opacity-20 animate-bounce" style="animation-delay: 0.5s;">👠</div>
        <div class="absolute bottom-10 left-1/4 text-3xl opacity-20 animate-bounce" style="animation-delay: 1s;">🥾</div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
            <span class="inline-block px-4 py-2 bg-white/20 text-white rounded-full text-sm font-semibold mb-4 backdrop-blur-sm">
                ✨ Premium Collection
            </span>
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">Our Products</h1>
            <p class="text-xl text-white/90 max-w-2xl mx-auto">
                Discover the perfect pair that matches your style and comfort needs
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 -mt-12">
        @if($products->isEmpty())
            <div class="bg-white rounded-3xl shadow-2xl p-12 text-center">
                <div class="text-8xl mb-6">📦</div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">No Products Available</h2>
                <p class="text-gray-600 text-lg">Check back soon for new arrivals!</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($products as $index => $product)
                    <div class="product-card bg-white rounded-3xl shadow-xl overflow-hidden animate-fadeInUp" style="animation-delay: {{ $index * 0.1 }}s;">
                        <!-- Product Image -->
                        <div class="relative h-56 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image h-full w-full object-cover">
                            @else
                                <div class="h-full w-full flex items-center justify-center">
                                    <span class="text-gray-400 text-7xl">👟</span>
                                </div>
                            @endif
                            <!-- Stock Badge -->
                            @if($product->stock < 10)
                                <div class="absolute top-4 left-4 px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full">
                                    Only {{ $product->stock }} left!
                                </div>
                            @endif
                            <!-- Price Tag -->
                            <div class="absolute top-4 right-4 price-tag text-white font-bold px-4 py-2 rounded-full shadow-lg">
                                ${{ number_format($product->price, 2) }}
                            </div>
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-6">
                            <h3 class="font-bold text-xl text-gray-900 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>
                            
                            <!-- Stock Info -->
                            <div class="flex items-center justify-between mb-5">
                                <div class="flex items-center text-sm">
                                    <span class="w-2 h-2 {{ $product->stock > 10 ? 'bg-green-500' : ($product->stock > 0 ? 'bg-yellow-500' : 'bg-red-500') }} rounded-full mr-2"></span>
                                    <span class="text-gray-500">{{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</span>
                                </div>
                                <div class="flex items-center text-gray-400 text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    {{ $product->stock }}
                                </div>
                            </div>
                            
                            <a href="{{ route('products.show', $product->id) }}" 
                               class="view-btn block w-full text-center bg-gradient-to-r from-purple-600 to-blue-600 text-white py-3 px-6 rounded-xl font-bold hover:from-purple-700 hover:to-blue-700 shadow-lg">
                                View Details →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-20">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} ShoeMart. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
