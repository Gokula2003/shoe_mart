<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-navigation />

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Our Products</h1>

        @if($products->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-gray-600 text-lg">No products available at the moment.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                            @else
                                <span class="text-gray-400 text-5xl">👟</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg text-gray-900 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($product->description, 80) }}</p>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-blue-600 font-bold text-xl">${{ number_format($product->price, 2) }}</span>
                                <span class="text-gray-500 text-sm">Stock: {{ $product->stock }}</span>
                            </div>
                            <a href="{{ route('products.show', $product->id) }}" 
                               style="background-color: #2563eb !important; color: white !important; display: block; width: 100%; text-align: center; padding: 12px 16px; font-size: 16px; font-weight: 600; border-radius: 6px; text-decoration: none; cursor: pointer;">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <p class="text-center">&copy; {{ date('Y') }} ShoeMart. All rights reserved.</p>
        </div>
    </footer>
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
