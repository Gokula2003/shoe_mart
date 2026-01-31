<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen pt-20">
    <!-- Navigation -->
    <x-navigation />

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-12 text-center animate-fade-in">
            <h1 class="text-5xl font-bold text-gray-900 mb-4">
                Our <span class="text-gradient">Premium</span> Collection
            </h1>
            <p class="text-xl text-gray-600">Discover footwear that elevates your style</p>
        </div>

        @if($products->isEmpty())
            <div class="bg-white rounded-2xl shadow-xl p-12 text-center animate-scale-in">
                <div class="w-24 h-24 bg-gradient-primary rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Products Yet</h3>
                <p class="text-gray-600">Check back soon for amazing deals!</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($products as $product)
                    <div class="group card-hover bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 animate-fade-in">
                        <!-- Product Image -->
                        <div class="relative h-64 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <span class="text-7xl opacity-50 group-hover:scale-110 transition-transform duration-300">👟</span>
                                </div>
                            @endif
                            
                            <!-- Badge -->
                            @if($product->stock < 10)
                                <div class="absolute top-4 right-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                    Low Stock
                                </div>
                            @elseif($product->created_at && $product->created_at->diffInDays(now()) < 7)
                                <div class="absolute top-4 right-4 bg-gradient-primary text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                    New
                                </div>
                            @endif
                            
                            <!-- Quick View Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-6">
                            <div class="mb-3">
                                <h3 class="font-bold text-xl text-gray-900 mb-2 group-hover:text-primary-600 transition-colors line-clamp-1">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-gray-600 text-sm leading-relaxed line-clamp-2 mb-4">
                                    {{ Str::limit($product->description, 80) }}
                                </p>
                            </div>
                            
                            <!-- Price and Stock -->
                            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
                                <div>
                                    <div class="text-3xl font-bold text-gradient">
                                        ${{ number_format($product->price, 2) }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-gray-500 uppercase tracking-wide">Stock</div>
                                    <div class="text-sm font-semibold {{ $product->stock < 10 ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $product->stock }} left
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Button -->
                            <a href="{{ route('products.show', $product->id) }}" 
                               class="btn-gradient w-full text-center shadow-md hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center group">
                                <span>View Details</span>
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($products->hasPages())
            <div class="mt-12 animate-fade-in">
                {{ $products->links() }}
            </div>
            @endif
        @endif
    </main>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
