<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-navigation />

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-6">About ShoeMart</h1>
            
            <div class="prose max-w-none">
                <p class="text-lg text-gray-700 mb-4">
                    Welcome to ShoeMart, your premier destination for quality footwear. We've been serving customers 
                    with the finest selection of shoes since our founding, and we're committed to providing exceptional 
                    products and customer service.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Our Story</h2>
                <p class="text-gray-700 mb-4">
                    ShoeMart was founded with a simple mission: to provide high-quality, comfortable, and stylish 
                    footwear for everyone. What started as a small family business has grown into a trusted name 
                    in the footwear industry.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Our Values</h2>
                <ul class="list-disc list-inside text-gray-700 space-y-2 mb-4">
                    <li><strong>Quality First:</strong> We source only the best materials and partner with reputable manufacturers.</li>
                    <li><strong>Customer Satisfaction:</strong> Your happiness is our top priority.</li>
                    <li><strong>Sustainability:</strong> We're committed to environmentally responsible practices.</li>
                    <li><strong>Innovation:</strong> We stay ahead of trends while respecting timeless styles.</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Why Choose Us?</h2>
                <div class="grid md:grid-cols-3 gap-6 mt-6">
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h3 class="font-semibold text-lg mb-2">Wide Selection</h3>
                        <p class="text-gray-700">From casual to formal, athletic to fashion-forward, we have shoes for every occasion.</p>
                    </div>
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h3 class="font-semibold text-lg mb-2">Expert Service</h3>
                        <p class="text-gray-700">Our knowledgeable team is here to help you find the perfect fit.</p>
                    </div>
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h3 class="font-semibold text-lg mb-2">Competitive Prices</h3>
                        <p class="text-gray-700">Quality footwear at prices that won't break the bank.</p>
                    </div>
                </div>
            </div>
        </div>
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
