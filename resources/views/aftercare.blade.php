<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>After Care - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-gradient { background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); }
        .care-icon { transition: all 0.3s ease; }
        .care-icon:hover { transform: scale(1.1) rotate(5deg); }
        .tip-card { border-left: 4px solid transparent; transition: all 0.3s ease; }
        .tip-card:hover { border-left-color: #10b981; background: linear-gradient(90deg, rgba(16, 185, 129, 0.05) 0%, transparent 100%); }
        .material-card { transition: all 0.3s ease; position: relative; overflow: hidden; }
        .material-card::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: linear-gradient(90deg, #667eea, #764ba2); transform: scaleX(0); transition: transform 0.3s ease; }
        .material-card:hover::before { transform: scaleX(1); }
        .material-card:hover { transform: translateY(-3px); }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        .shimmer { background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent); background-size: 200% 100%; animation: shimmer 2s infinite; }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-green-50 min-h-screen pt-20">
    <!-- Navigation -->
    <x-navigation />

    <!-- Hero Section -->
    <div class="hero-gradient py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;"></div>
        </div>
        <!-- Floating Icons -->
        <div class="absolute top-10 left-10 text-4xl opacity-30 animate-bounce">✨</div>
        <div class="absolute top-20 right-20 text-5xl opacity-30 animate-bounce" style="animation-delay: 0.5s;">👟</div>
        <div class="absolute bottom-10 left-1/4 text-3xl opacity-30 animate-bounce" style="animation-delay: 1s;">🧴</div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
            <span class="inline-block px-4 py-2 bg-white/20 text-white rounded-full text-sm font-semibold mb-4 backdrop-blur-sm">
                🌟 Expert Care Tips
            </span>
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">Shoe Care Guide</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto">
                Proper care and maintenance will extend the life of your shoes and keep them looking their best
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 -mt-12">
        <!-- General Care Tips -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 mb-12 card-hover">
            <div class="flex items-center mb-8">
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg care-icon">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">General Care Tips</h2>
            </div>
            
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-8 rounded-2xl">
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="tip-card flex items-start p-4 rounded-xl">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0 shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-gray-700 font-medium">Always remove dirt and dust after each wear with a soft brush or cloth</span>
                    </div>
                    <div class="tip-card flex items-start p-4 rounded-xl">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0 shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-gray-700 font-medium">Store shoes in a cool, dry place away from direct sunlight</span>
                    </div>
                    <div class="tip-card flex items-start p-4 rounded-xl">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0 shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-gray-700 font-medium">Use shoe trees to maintain shape and absorb moisture</span>
                    </div>
                    <div class="tip-card flex items-start p-4 rounded-xl">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0 shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-gray-700 font-medium">Rotate your shoes to allow them to air out between wears</span>
                    </div>
                    <div class="tip-card flex items-start p-4 rounded-xl">
                        <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0 shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <span class="text-gray-700 font-medium">Never machine wash leather shoes</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Material-Specific Care -->
        <div class="mb-12">
            <div class="text-center mb-10">
                <span class="inline-block px-4 py-2 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold mb-4">
                    📚 Material Guide
                </span>
                <h2 class="text-3xl font-bold text-gray-900">Material-Specific Care</h2>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Leather Care -->
                <div class="material-card bg-white rounded-2xl shadow-xl p-8">
                    <div class="flex items-center mb-6">
                        <span class="text-4xl mr-4">🥾</span>
                        <h3 class="text-2xl font-bold text-gray-900">Leather Shoes</h3>
                    </div>
                    <ul class="space-y-4 text-gray-700">
                        <li class="flex items-start"><span class="font-bold text-purple-600 mr-2 min-w-[100px]">Cleaning:</span> Use a damp cloth with mild soap</li>
                        <li class="flex items-start"><span class="font-bold text-purple-600 mr-2 min-w-[100px]">Conditioning:</span> Apply leather conditioner monthly</li>
                        <li class="flex items-start"><span class="font-bold text-purple-600 mr-2 min-w-[100px]">Polish:</span> Use matching color polish to maintain shine</li>
                        <li class="flex items-start"><span class="font-bold text-purple-600 mr-2 min-w-[100px]">Waterproofing:</span> Apply waterproof spray regularly</li>
                        <li class="flex items-start"><span class="font-bold text-purple-600 mr-2 min-w-[100px]">Drying:</span> Air dry away from heat sources</li>
                    </ul>
                </div>

                <!-- Suede Care -->
                <div class="material-card bg-white rounded-2xl shadow-xl p-8">
                    <div class="flex items-center mb-6">
                        <span class="text-4xl mr-4">👢</span>
                        <h3 class="text-2xl font-bold text-gray-900">Suede & Nubuck</h3>
                    </div>
                    <ul class="space-y-4 text-gray-700">
                        <li class="flex items-start"><span class="font-bold text-blue-600 mr-2 min-w-[100px]">Cleaning:</span> Use a suede brush for dry dirt</li>
                        <li class="flex items-start"><span class="font-bold text-blue-600 mr-2 min-w-[100px]">Stains:</span> Use a suede eraser for marks</li>
                        <li class="flex items-start"><span class="font-bold text-blue-600 mr-2 min-w-[100px]">Protection:</span> Apply suede protector spray</li>
                        <li class="flex items-start"><span class="font-bold text-blue-600 mr-2 min-w-[100px]">Avoid:</span> Never use water or regular polish</li>
                        <li class="flex items-start"><span class="font-bold text-blue-600 mr-2 min-w-[100px]">Restoration:</span> Steam lightly to restore nap</li>
                    </ul>
                </div>

                <!-- Canvas Care -->
                <div class="material-card bg-white rounded-2xl shadow-xl p-8">
                    <div class="flex items-center mb-6">
                        <span class="text-4xl mr-4">👟</span>
                        <h3 class="text-2xl font-bold text-gray-900">Canvas & Fabric</h3>
                    </div>
                    <ul class="space-y-4 text-gray-700">
                        <li class="flex items-start"><span class="font-bold text-green-600 mr-2 min-w-[100px]">Cleaning:</span> Gentle hand wash with mild detergent</li>
                        <li class="flex items-start"><span class="font-bold text-green-600 mr-2 min-w-[100px]">Stains:</span> Pre-treat with stain remover</li>
                        <li class="flex items-start"><span class="font-bold text-green-600 mr-2 min-w-[100px]">Drying:</span> Air dry completely before wearing</li>
                        <li class="flex items-start"><span class="font-bold text-green-600 mr-2 min-w-[100px]">Whitening:</span> Use baking soda paste for white shoes</li>
                        <li class="flex items-start"><span class="font-bold text-green-600 mr-2 min-w-[100px]">Laces:</span> Remove and wash separately</li>
                    </ul>
                </div>

                <!-- Athletic Shoes -->
                <div class="material-card bg-white rounded-2xl shadow-xl p-8">
                    <div class="flex items-center mb-6">
                        <span class="text-4xl mr-4">🏃</span>
                        <h3 class="text-2xl font-bold text-gray-900">Athletic Shoes</h3>
                    </div>
                    <ul class="space-y-4 text-gray-700">
                        <li class="flex items-start"><span class="font-bold text-orange-600 mr-2 min-w-[100px]">Cleaning:</span> Remove insoles and wash separately</li>
                        <li class="flex items-start"><span class="font-bold text-orange-600 mr-2 min-w-[100px]">Odor:</span> Use baking soda or shoe deodorizers</li>
                        <li class="flex items-start"><span class="font-bold text-orange-600 mr-2 min-w-[100px]">Drying:</span> Stuff with newspaper to absorb moisture</li>
                        <li class="flex items-start"><span class="font-bold text-orange-600 mr-2 min-w-[100px]">Replacement:</span> Replace every 300-500 miles of running</li>
                        <li class="flex items-start"><span class="font-bold text-orange-600 mr-2 min-w-[100px]">Storage:</span> Keep in breathable shoe bags</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Seasonal Care -->
        <div class="mb-12">
            <div class="text-center mb-10">
                <span class="inline-block px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold mb-4">
                    🌤️ Seasonal Tips
                </span>
                <h2 class="text-3xl font-bold text-gray-900">Seasonal Care</h2>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-8 border border-blue-100 card-hover">
                    <div class="flex items-center mb-4">
                        <span class="text-4xl mr-3">❄️</span>
                        <h3 class="font-bold text-2xl text-gray-900">Winter Care</h3>
                    </div>
                    <p class="text-gray-700 mb-4">Salt and moisture can damage shoes in winter:</p>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                            Apply waterproofing treatment before winter
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                            Remove salt stains immediately with vinegar solution
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
                            Allow wet shoes to dry naturally for 24 hours
                        </li>
                    </ul>
                </div>
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl p-8 border border-yellow-100 card-hover">
                    <div class="flex items-center mb-4">
                        <span class="text-4xl mr-3">☀️</span>
                        <h3 class="font-bold text-2xl text-gray-900">Summer Care</h3>
                    </div>
                    <p class="text-gray-700 mb-4">Heat and humidity require extra attention:</p>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></span>
                            Use odor-fighting foot powder
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></span>
                            Clean and air out shoes more frequently
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></span>
                            Store in breathable containers to prevent mold
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Professional Services -->
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Repair Services -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-3xl p-8 text-white relative overflow-hidden card-hover">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                <div class="relative">
                    <div class="text-5xl mb-4">🔧</div>
                    <h2 class="text-2xl font-bold mb-4">Professional Repair Services</h2>
                    <p class="mb-4 text-white/90">Need professional help? We offer comprehensive shoe repair services:</p>
                    <ul class="space-y-2 mb-6 text-white/90">
                        <li class="flex items-center"><span class="mr-2">•</span>Sole replacement and repair</li>
                        <li class="flex items-center"><span class="mr-2">•</span>Heel replacement</li>
                        <li class="flex items-center"><span class="mr-2">•</span>Zipper and buckle repair</li>
                        <li class="flex items-center"><span class="mr-2">•</span>Professional cleaning and restoration</li>
                        <li class="flex items-center"><span class="mr-2">•</span>Stretching and fitting adjustments</li>
                    </ul>
                    <a href="/contact" class="inline-block bg-white text-blue-600 py-3 px-6 rounded-xl hover:bg-gray-100 transition font-bold shadow-lg">
                        Contact Us for Repairs →
                    </a>
                </div>
            </div>

            <!-- After Care Reservation -->
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl p-8 text-white relative overflow-hidden card-hover">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                <div class="relative">
                    <div class="text-5xl mb-4">📅</div>
                    <h2 class="text-2xl font-bold mb-4">After Care Reservation</h2>
                    <p class="mb-4 text-white/90">Book an appointment for professional shoe care services:</p>
                    <ul class="space-y-2 mb-6 text-white/90">
                        <li class="flex items-center"><span class="mr-2">•</span>Deep cleaning and conditioning</li>
                        <li class="flex items-center"><span class="mr-2">•</span>Polishing and restoration</li>
                        <li class="flex items-center"><span class="mr-2">•</span>Waterproofing treatment</li>
                        <li class="flex items-center"><span class="mr-2">•</span>Odor removal</li>
                        <li class="flex items-center"><span class="mr-2">•</span>Expert consultation</li>
                    </ul>
                    <a href="{{ route('aftercare.booking') }}" class="inline-block bg-white text-green-600 py-3 px-6 rounded-xl hover:bg-gray-100 transition font-bold shadow-lg">
                        📅 Book Reservation →
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-20">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-400">&copy; {{ date('Y') }} ShoeMart. All rights reserved.</p>
        </div>
    </footer>
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
