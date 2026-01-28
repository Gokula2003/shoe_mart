<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book After Care Reservation - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-gradient { background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); }
        .input-field { transition: all 0.3s ease; }
        .input-field:focus { transform: translateY(-2px); box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.2); }
        .service-card { transition: all 0.3s ease; cursor: pointer; }
        .service-card:hover { transform: scale(1.02); }
        .service-card.selected { border-color: #10b981; background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, transparent 100%); }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-green-50 min-h-screen">
    <!-- Navigation -->
    <x-navigation />

    <!-- Hero Section -->
    <div class="hero-gradient py-16 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
            <span class="text-6xl mb-4 block">📅</span>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Book After Care Reservation</h1>
            <p class="text-xl text-white/90">Schedule your professional shoe care service</p>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8 -mt-8">
        <div class="mb-6">
            <a href="{{ route('aftercare') }}" class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to After Care
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-xl shadow-lg flex items-center">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-2xl p-8 card-hover">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mr-4">
                    <span class="text-xl">✨</span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Reservation Form</h2>
                    <p class="text-gray-600">Fill out the details below to book your appointment</p>
                </div>
            </div>

            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-xl">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-bold">Please fix the following errors:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('aftercare.booking.submit') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Full Name *</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', auth()->user()->name ?? '') }}" 
                               required
                               class="input-field w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                               placeholder="John Doe">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Address *</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', auth()->user()->email ?? '') }}" 
                               required
                               class="input-field w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                               placeholder="john@example.com">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Phone Number *</label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}" 
                               required
                               maxlength="10"
                               pattern="[0-9]{10}"
                               class="input-field w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                               placeholder="1234567890"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>

                    <!-- Service Type -->
                    <div>
                        <label for="service_type" class="block text-sm font-bold text-gray-700 mb-2">Service Type *</label>
                        <select id="service_type" 
                                name="service_type" 
                                required
                                class="input-field w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                            <option value="">Select Service</option>
                            <option value="Deep Cleaning" {{ old('service_type') == 'Deep Cleaning' ? 'selected' : '' }}>🧹 Deep Cleaning</option>
                            <option value="Polishing & Restoration" {{ old('service_type') == 'Polishing & Restoration' ? 'selected' : '' }}>✨ Polishing & Restoration</option>
                            <option value="Waterproofing Treatment" {{ old('service_type') == 'Waterproofing Treatment' ? 'selected' : '' }}>💧 Waterproofing Treatment</option>
                            <option value="Odor Removal" {{ old('service_type') == 'Odor Removal' ? 'selected' : '' }}>🌸 Odor Removal</option>
                            <option value="Conditioning" {{ old('service_type') == 'Conditioning' ? 'selected' : '' }}>🧴 Conditioning</option>
                            <option value="Complete Care Package" {{ old('service_type') == 'Complete Care Package' ? 'selected' : '' }}>⭐ Complete Care Package</option>
                        </select>
                    </div>

                    <!-- Reservation Date -->
                    <div>
                        <label for="reservation_date" class="block text-sm font-bold text-gray-700 mb-2">Preferred Date *</label>
                        <input type="date" 
                               id="reservation_date" 
                               name="reservation_date" 
                               value="{{ old('reservation_date') }}" 
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               required
                               class="input-field w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                    </div>

                    <!-- Reservation Time -->
                    <div>
                        <label for="reservation_time" class="block text-sm font-bold text-gray-700 mb-2">Preferred Time *</label>
                        <select id="reservation_time" 
                                name="reservation_time" 
                                required
                                class="input-field w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                            <option value="">Select Time</option>
                            <option value="09:00" {{ old('reservation_time') == '09:00' ? 'selected' : '' }}>🌅 9:00 AM</option>
                            <option value="10:00" {{ old('reservation_time') == '10:00' ? 'selected' : '' }}>☀️ 10:00 AM</option>
                            <option value="11:00" {{ old('reservation_time') == '11:00' ? 'selected' : '' }}>☀️ 11:00 AM</option>
                            <option value="12:00" {{ old('reservation_time') == '12:00' ? 'selected' : '' }}>🌞 12:00 PM</option>
                            <option value="13:00" {{ old('reservation_time') == '13:00' ? 'selected' : '' }}>🌞 1:00 PM</option>
                            <option value="14:00" {{ old('reservation_time') == '14:00' ? 'selected' : '' }}>☀️ 2:00 PM</option>
                            <option value="15:00" {{ old('reservation_time') == '15:00' ? 'selected' : '' }}>☀️ 3:00 PM</option>
                            <option value="16:00" {{ old('reservation_time') == '16:00' ? 'selected' : '' }}>🌅 4:00 PM</option>
                            <option value="17:00" {{ old('reservation_time') == '17:00' ? 'selected' : '' }}>🌆 5:00 PM</option>
                        </select>
                    </div>
                </div>

                <!-- Additional Notes -->
                <div>
                    <label for="notes" class="block text-sm font-bold text-gray-700 mb-2">Additional Notes (Optional)</label>
                    <textarea id="notes" 
                              name="notes" 
                              rows="4" 
                              class="input-field w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all resize-none"
                              placeholder="Any specific concerns or requests about your shoes...">{{ old('notes') }}</textarea>
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 px-8 rounded-xl hover:from-green-600 hover:to-emerald-700 transition font-bold text-lg shadow-xl hover:shadow-2xl transform hover:scale-[1.02] flex items-center justify-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Submit Reservation
                    </button>
                    <a href="{{ route('aftercare') }}" 
                       class="flex-1 sm:flex-none bg-gray-100 text-gray-700 py-4 px-8 rounded-xl hover:bg-gray-200 transition font-bold text-lg flex items-center justify-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Service Information -->
        <div class="mt-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-3xl p-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>
            <div class="relative">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                        <span class="text-2xl">💡</span>
                    </div>
                    <h3 class="font-bold text-2xl">What to Expect</h3>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="flex items-start bg-white/10 rounded-xl p-4">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-white/90">Your reservation request will be reviewed within 24 hours</span>
                    </div>
                    <div class="flex items-start bg-white/10 rounded-xl p-4">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-white/90">We'll contact you via email or phone to confirm</span>
                    </div>
                    <div class="flex items-start bg-white/10 rounded-xl p-4">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-white/90">Please bring your shoes clean and in a bag</span>
                    </div>
                    <div class="flex items-start bg-white/10 rounded-xl p-4">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-white/90">Service typically takes 1-2 hours</span>
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
