<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>After Care - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-navigation />

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-6">Shoe Care Guide</h1>
            
            <p class="text-lg text-gray-700 mb-8">
                Proper care and maintenance will extend the life of your shoes and keep them looking their best. 
                Follow our comprehensive guide to ensure your footwear stays in top condition.
            </p>

            <!-- General Care Tips -->
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">General Care Tips</h2>
                <div class="bg-blue-50 p-6 rounded-lg">
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Always remove dirt and dust after each wear with a soft brush or cloth</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Store shoes in a cool, dry place away from direct sunlight</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Use shoe trees to maintain shape and absorb moisture</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Rotate your shoes to allow them to air out between wears</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Never machine wash leather shoes</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Material-Specific Care -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <!-- Leather Care -->
                <div class="border rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Leather Shoes</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li><strong>Cleaning:</strong> Use a damp cloth with mild soap</li>
                        <li><strong>Conditioning:</strong> Apply leather conditioner monthly</li>
                        <li><strong>Polish:</strong> Use matching color polish to maintain shine</li>
                        <li><strong>Waterproofing:</strong> Apply waterproof spray regularly</li>
                        <li><strong>Drying:</strong> Air dry away from heat sources</li>
                    </ul>
                </div>

                <!-- Suede Care -->
                <div class="border rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Suede & Nubuck</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li><strong>Cleaning:</strong> Use a suede brush for dry dirt</li>
                        <li><strong>Stains:</strong> Use a suede eraser for marks</li>
                        <li><strong>Protection:</strong> Apply suede protector spray</li>
                        <li><strong>Avoid:</strong> Never use water or regular polish</li>
                        <li><strong>Restoration:</strong> Steam lightly to restore nap</li>
                    </ul>
                </div>

                <!-- Canvas Care -->
                <div class="border rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Canvas & Fabric</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li><strong>Cleaning:</strong> Gentle hand wash with mild detergent</li>
                        <li><strong>Stains:</strong> Pre-treat with stain remover</li>
                        <li><strong>Drying:</strong> Air dry completely before wearing</li>
                        <li><strong>Whitening:</strong> Use baking soda paste for white shoes</li>
                        <li><strong>Laces:</strong> Remove and wash separately</li>
                    </ul>
                </div>

                <!-- Athletic Shoes -->
                <div class="border rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Athletic Shoes</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li><strong>Cleaning:</strong> Remove insoles and wash separately</li>
                        <li><strong>Odor:</strong> Use baking soda or shoe deodorizers</li>
                        <li><strong>Drying:</strong> Stuff with newspaper to absorb moisture</li>
                        <li><strong>Replacement:</strong> Replace every 300-500 miles of running</li>
                        <li><strong>Storage:</strong> Keep in breathable shoe bags</li>
                    </ul>
                </div>
            </div>

            <!-- Seasonal Care -->
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Seasonal Care</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="font-semibold text-lg mb-3">Winter Care</h3>
                        <p class="text-gray-700 mb-3">Salt and moisture can damage shoes in winter:</p>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            <li>Apply waterproofing treatment before winter</li>
                            <li>Remove salt stains immediately with vinegar solution</li>
                            <li>Allow wet shoes to dry naturally for 24 hours</li>
                        </ul>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="font-semibold text-lg mb-3">Summer Care</h3>
                        <p class="text-gray-700 mb-3">Heat and humidity require extra attention:</p>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            <li>Use odor-fighting foot powder</li>
                            <li>Clean and air out shoes more frequently</li>
                            <li>Store in breathable containers to prevent mold</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Professional Services -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <!-- Repair Services -->
                <div class="bg-blue-100 border-l-4 border-blue-600 p-6 rounded">
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">Professional Repair Services</h2>
                    <p class="text-gray-700 mb-3">
                        Need professional help? We offer comprehensive shoe repair services:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 space-y-1 mb-4">
                        <li>Sole replacement and repair</li>
                        <li>Heel replacement</li>
                        <li>Zipper and buckle repair</li>
                        <li>Professional cleaning and restoration</li>
                        <li>Stretching and fitting adjustments</li>
                    </ul>
                    <a href="/contact" class="inline-block bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition">
                        Contact Us for Repairs
                    </a>
                </div>

                <!-- After Care Reservation -->
                <div class="bg-green-100 border-l-4 border-green-600 p-6 rounded">
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">After Care Reservation</h2>
                    <p class="text-gray-700 mb-3">
                        Book an appointment for professional shoe care services:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 space-y-1 mb-4">
                        <li>Deep cleaning and conditioning</li>
                        <li>Polishing and restoration</li>
                        <li>Waterproofing treatment</li>
                        <li>Odor removal</li>
                        <li>Expert consultation</li>
                    </ul>
                    <a href="{{ route('aftercare.booking') }}" 
                       style="background-color: #16a34a !important; color: white !important; padding: 12px 24px; font-size: 16px; font-weight: 600; border-radius: 6px; text-decoration: none; display: inline-block;">
                        📅 Book Reservation
                    </a>
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
