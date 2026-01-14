<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-navigation />

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="grid md:grid-cols-2 gap-8 p-8">
                <!-- Product Image -->
                <div>
                    <div class="bg-gray-200 rounded-lg h-96 flex items-center justify-center">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover rounded-lg">
                        @else
                            <span class="text-gray-400 text-9xl">👟</span>
                        @endif
                    </div>
                </div>

                <!-- Product Details -->
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-blue-600">${{ number_format($product->price, 2) }}</span>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>

                    <div class="mb-6">
                        <p class="text-sm text-gray-600">
                            <span class="font-semibold">Availability:</span> 
                            @if($product->stock > 0)
                                <span class="text-green-600">In Stock ({{ $product->stock }} available)</span>
                            @else
                                <span class="text-red-600">Out of Stock</span>
                            @endif
                        </p>
                    </div>

                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="size" class="block text-sm font-medium text-gray-700 mb-2">Select Size</label>
                                <select id="size" name="size" required 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Choose size...</option>
                                    <option value="6">Size 6</option>
                                    <option value="7">Size 7</option>
                                    <option value="8">Size 8</option>
                                    <option value="9">Size 9</option>
                                    <option value="10">Size 10</option>
                                    <option value="11">Size 11</option>
                                    <option value="12">Size 12</option>
                                </select>
                            </div>

                            <div class="mb-6">
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <button type="submit" 
                                    style="background-color: #16a34a !important; color: white !important; width: 100%; padding: 14px; font-size: 18px; font-weight: 600; border: none; border-radius: 6px; cursor: pointer;">
                                🛒 Add to Cart
                            </button>
                        </form>
                    @else
                        <button disabled 
                                style="background-color: #9ca3af !important; color: white !important; width: 100%; padding: 14px; font-size: 18px; font-weight: 600; border: none; border-radius: 6px; cursor: not-allowed;">
                            Out of Stock
                        </button>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                            ← Back to Shop
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
