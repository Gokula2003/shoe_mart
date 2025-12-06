<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-navigation />

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Our Shoe Collection</h1>
            <p class="text-gray-600 mt-2">Browse our premium selection of footwear</p>
        </div>

        @if($products->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-gray-600">No products available at the moment. Please check back later!</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                            @else
                                <span class="text-gray-400 text-2xl">👟</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg text-gray-900 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-bold text-blue-600">${{ number_format($product->price, 2) }}</span>
                                <span class="text-sm text-gray-500">Stock: {{ $product->stock }}</span>
                            </div>
                            <a href="{{ route('products.show', $product->id) }}" 
                               style="background-color: #2563eb !important; color: white !important; width: 100%; padding: 10px; font-size: 14px; font-weight: 600; border: none; border-radius: 6px; cursor: pointer; display: block; text-align: center; text-decoration: none;">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
