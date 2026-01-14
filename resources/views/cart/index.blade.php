<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shopping Cart - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-navigation />

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($cartItems->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-gray-600 text-lg mb-4">Your cart is empty</p>
                <a href="{{ route('products.index') }}" 
                   style="background-color: #2563eb !important; color: white !important; padding: 12px 24px; font-size: 16px; font-weight: 600; border: none; border-radius: 6px; cursor: pointer; display: inline-block; text-decoration: none;">
                    Continue Shopping
                </a>
            </div>
        @else
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-24 h-24 bg-gray-200 rounded-md flex items-center justify-center flex-shrink-0">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover rounded-md">
                                    @else
                                        <span class="text-gray-400 text-3xl">👟</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-lg text-gray-900">{{ $item->product->name }}</h3>
                                    <p class="text-gray-600 text-sm">Size: {{ $item->size }}</p>
                                    <p class="text-gray-600 text-sm">Quantity: {{ $item->quantity }}</p>
                                    <p class="text-blue-600 font-bold mt-2">${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                                </div>
                                <div>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Order Summary</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-semibold">Free</span>
                            </div>
                            <div class="border-t pt-3 flex justify-between">
                                <span class="text-lg font-bold">Total</span>
                                <span class="text-lg font-bold text-blue-600">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('cart.checkout') }}" 
                           style="background-color: #16a34a !important; color: white !important; width: 100%; padding: 14px; font-size: 18px; font-weight: 600; border: none; border-radius: 6px; cursor: pointer; display: block; text-align: center; text-decoration: none; margin-bottom: 12px;">
                            Proceed to Checkout
                        </a>

                        <a href="{{ route('products.index') }}" 
                           class="text-blue-600 hover:text-blue-800 font-semibold block text-center">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </main>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
