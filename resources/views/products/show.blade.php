<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .product-image-container { transition: all 0.5s ease; }
        .product-image-container:hover { transform: scale(1.02); }
        .size-option { transition: all 0.3s ease; cursor: pointer; }
        .size-option:hover { transform: scale(1.1); border-color: #667eea; }
        .size-option.selected { background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-color: transparent; }
        .quantity-btn { transition: all 0.2s ease; }
        .quantity-btn:hover { background: #667eea; color: white; }
        .add-to-cart-btn { 
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); 
            transition: all 0.3s ease;
        }
        .add-to-cart-btn:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 15px 30px -5px rgba(34, 197, 94, 0.4);
        }
        .feature-badge { transition: all 0.3s ease; }
        .feature-badge:hover { transform: translateY(-2px); }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-purple-50 min-h-screen pt-20">
    <!-- Navigation -->
    <x-navigation />

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('products.index') }}" class="text-purple-600 hover:text-purple-800 font-medium">Shop</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li class="text-gray-600">{{ $product->name }}</li>
            </ol>
        </nav>

        <!-- Notifications -->
        @if(session('success'))
            <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-6 rounded-2xl shadow-lg flex items-center">
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-green-800 font-bold">Success!</p>
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 p-6 rounded-2xl shadow-lg flex items-center">
                <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-red-800 font-bold">Error</p>
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Product Section -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="grid md:grid-cols-2">
                <!-- Product Image -->
                <div class="relative bg-gradient-to-br from-gray-100 to-gray-200 p-8 flex items-center justify-center min-h-[500px]">
                    <div class="product-image-container w-full h-full flex items-center justify-center">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="max-h-[450px] w-auto object-contain rounded-2xl shadow-xl">
                        @else
                            <div class="text-center">
                                <span class="text-[180px] opacity-50">👟</span>
                                <p class="text-gray-500 mt-4">Product Image</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Badges -->
                    @if($product->stock < 10 && $product->stock > 0)
                        <div class="absolute top-6 left-6 bg-gradient-to-r from-orange-500 to-red-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Low Stock
                        </div>
                    @elseif($product->created_at && $product->created_at->diffInDays(now()) < 7)
                        <div class="absolute top-6 left-6 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                            New Arrival
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="p-8 lg:p-12">
                    <!-- Title & Price -->
                    <div class="mb-8">
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                        <div class="flex items-center gap-4">
                            <span class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 text-transparent bg-clip-text">${{ number_format($product->price, 2) }}</span>
                            @if($product->stock > 0)
                                <span class="px-4 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                    In Stock
                                </span>
                            @else
                                <span class="px-4 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold flex items-center">
                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                    Out of Stock
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Description
                        </h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <!-- Stock Info -->
                    <div class="mb-8 p-4 bg-gradient-to-r from-purple-50 to-blue-50 rounded-2xl">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700 font-medium">Availability</span>
                            <span class="{{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }} font-bold">
                                {{ $product->stock }} items available
                            </span>
                        </div>
                    </div>

                    @if($product->stock > 0)
                        @auth
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" x-data="{ selectedSize: '', quantity: 1 }">
                                @csrf
                                
                                <!-- Size Selection -->
                                <div class="mb-8">
                                    <label class="block text-lg font-bold text-gray-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                        </svg>
                                        Select Size
                                    </label>
                                    <div class="flex flex-wrap gap-3">
                                        @foreach([6, 7, 8, 9, 10, 11, 12] as $size)
                                            <label class="size-option w-14 h-14 flex items-center justify-center border-2 border-gray-300 rounded-xl font-bold text-gray-700 cursor-pointer"
                                                   :class="{ 'selected': selectedSize === '{{ $size }}' }">
                                                <input type="radio" name="size" value="{{ $size }}" class="hidden" x-model="selectedSize" required>
                                                {{ $size }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Quantity -->
                                <div class="mb-8">
                                    <label class="block text-lg font-bold text-gray-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                        </svg>
                                        Quantity
                                    </label>
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center bg-gray-100 rounded-xl overflow-hidden">
                                            <button type="button" @click="quantity = Math.max(1, quantity - 1)" class="quantity-btn w-12 h-12 flex items-center justify-center text-gray-700 hover:bg-purple-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            <input type="number" name="quantity" x-model="quantity" min="1" max="{{ $product->stock }}" 
                                                   class="w-16 h-12 text-center border-0 bg-transparent font-bold text-lg focus:ring-0">
                                            <button type="button" @click="quantity = Math.min({{ $product->stock }}, quantity + 1)" class="quantity-btn w-12 h-12 flex items-center justify-center text-gray-700 hover:bg-purple-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <span class="text-gray-500 text-sm">Max: {{ $product->stock }}</span>
                                    </div>
                                </div>

                                <button type="submit" class="add-to-cart-btn w-full text-white py-5 px-6 rounded-2xl font-bold text-xl flex items-center justify-center shadow-xl">
                                    <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <div class="mb-6 p-6 bg-gradient-to-r from-amber-50 to-yellow-50 border-l-4 border-amber-400 rounded-2xl">
                                <div class="flex items-start">
                                    <div class="w-12 h-12 bg-amber-400 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-amber-800 font-bold text-lg">Login Required</p>
                                        <p class="text-amber-700">Please login to purchase this product and add items to your cart.</p>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('login') }}" class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-5 px-6 rounded-2xl font-bold text-xl flex items-center justify-center shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Login to Add to Cart
                            </a>
                        @endauth
                    @else
                        <button disabled class="w-full bg-gray-400 text-white py-5 px-6 rounded-2xl font-bold text-xl flex items-center justify-center cursor-not-allowed">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                            </svg>
                            Out of Stock
                        </button>
                    @endif

                    <!-- Features -->
                    <div class="mt-10 pt-8 border-t border-gray-200">
                        <div class="grid grid-cols-3 gap-4">
                            <div class="feature-badge text-center p-4 bg-gray-50 rounded-xl">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <span class="text-xs text-gray-600 font-medium">Free Shipping</span>
                            </div>
                            <div class="feature-badge text-center p-4 bg-gray-50 rounded-xl">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs text-gray-600 font-medium">Authentic</span>
                            </div>
                            <div class="feature-badge text-center p-4 bg-gray-50 rounded-xl">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </div>
                                <span class="text-xs text-gray-600 font-medium">Easy Returns</span>
                            </div>
                        </div>
                    </div>

                    <!-- Back Link -->
                    <div class="mt-8">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center text-purple-600 hover:text-purple-800 font-semibold transition group">
                            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Shop
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-20">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-400">&copy; {{ date('Y') }} ShoeMart. All rights reserved.</p>
        </div>
    </footer>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
