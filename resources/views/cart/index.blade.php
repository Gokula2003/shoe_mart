<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shopping Cart - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-3px); box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15); }
        .cart-item { transition: all 0.3s ease; }
        .cart-item:hover { transform: scale(1.01); }
        .remove-btn { transition: all 0.3s ease; }
        .remove-btn:hover { transform: scale(1.1); }
        .summary-card { background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%); }
        @keyframes cartBounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-5px); } }
        .cart-icon { animation: cartBounce 2s ease-in-out infinite; }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-purple-50 min-h-screen">
    <!-- Navigation -->
    <x-navigation />

    <!-- Hero Section -->
    <div class="hero-gradient py-16 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
            <span class="text-6xl cart-icon inline-block mb-4">🛒</span>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Shopping Cart</h1>
            <p class="text-xl text-white/90">Review your items before checkout</p>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 -mt-8">
        @if(session('success'))
            <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-xl shadow-lg flex items-center">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if($cartItems->isEmpty())
            <div class="bg-white rounded-3xl shadow-2xl p-12 text-center card-hover">
                <div class="text-8xl mb-6">🛒</div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Your cart is empty</h2>
                <p class="text-gray-600 text-lg mb-8">Looks like you haven't added any items to your cart yet.</p>
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold text-lg rounded-xl hover:from-purple-700 hover:to-blue-700 transition shadow-xl hover:shadow-2xl transform hover:scale-105">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Continue Shopping
                </a>
            </div>
        @else
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-5">
                    <div class="inline-block px-4 py-2 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold mb-2">
                        {{ $cartItems->count() }} {{ $cartItems->count() == 1 ? 'Item' : 'Items' }} in Cart
                    </div>
                    
                    @foreach($cartItems as $item)
                        <div class="bg-white rounded-2xl shadow-lg p-6 cart-item card-hover">
                            <div class="flex items-center space-x-6">
                                <div class="w-28 h-28 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center flex-shrink-0 overflow-hidden shadow-inner">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="text-gray-400 text-4xl">👟</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-xl text-gray-900 mb-2">{{ $item->product->name }}</h3>
                                    <div class="flex flex-wrap gap-3 mb-3">
                                        <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                            </svg>
                                            Size: {{ $item->size }}
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded-full">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                            </svg>
                                            Qty: {{ $item->quantity }}
                                        </span>
                                    </div>
                                    <p class="text-2xl font-bold text-purple-600">${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                                </div>
                                <div>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="remove-btn w-12 h-12 bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-600 rounded-xl flex items-center justify-center">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="summary-card rounded-3xl shadow-2xl p-8 sticky top-4 border border-gray-100">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-blue-500 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Order Summary</h2>
                        </div>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold text-gray-900">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-semibold text-green-600 flex items-center">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Free
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-4 bg-gradient-to-r from-purple-50 to-blue-50 rounded-xl px-4 -mx-4">
                                <span class="text-xl font-bold text-gray-900">Total</span>
                                <span class="text-2xl font-bold text-purple-600">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('cart.checkout') }}" 
                           class="block w-full bg-gradient-to-r from-green-500 to-emerald-500 text-white text-center py-4 px-6 rounded-xl hover:from-green-600 hover:to-emerald-600 transition font-bold text-lg shadow-xl hover:shadow-2xl transform hover:scale-[1.02] mb-4">
                            Proceed to Checkout →
                        </a>

                        <a href="{{ route('products.index') }}" 
                           class="flex items-center justify-center text-purple-600 hover:text-purple-800 font-semibold py-3">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Continue Shopping
                        </a>

                        <!-- Trust Badges -->
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <div class="grid grid-cols-2 gap-4 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mb-2">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs text-gray-600">Secure Checkout</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs text-gray-600">Easy Returns</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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
