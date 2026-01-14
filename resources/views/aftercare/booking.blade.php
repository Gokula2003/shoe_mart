<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book After Care Reservation - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-navigation />

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('aftercare') }}" class="text-blue-600 hover:text-blue-800">← Back to After Care</a>
        </div>

        <h1 class="text-4xl font-bold text-gray-900 mb-6">Book After Care Reservation</h1>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-8">
            <p class="text-gray-700 mb-6">
                Fill out the form below to book your shoe care service appointment. Our team will review your request and confirm the booking shortly.
            </p>

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
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
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', auth()->user()->name ?? '') }}" 
                               required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="John Doe">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', auth()->user()->email ?? '') }}" 
                               required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="john@example.com">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}" 
                               required
                               maxlength="10"
                               pattern="[0-9]{10}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="1234567890"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>

                    <!-- Service Type -->
                    <div>
                        <label for="service_type" class="block text-sm font-medium text-gray-700 mb-2">Service Type *</label>
                        <select id="service_type" 
                                name="service_type" 
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Service</option>
                            <option value="Deep Cleaning" {{ old('service_type') == 'Deep Cleaning' ? 'selected' : '' }}>Deep Cleaning</option>
                            <option value="Polishing & Restoration" {{ old('service_type') == 'Polishing & Restoration' ? 'selected' : '' }}>Polishing & Restoration</option>
                            <option value="Waterproofing Treatment" {{ old('service_type') == 'Waterproofing Treatment' ? 'selected' : '' }}>Waterproofing Treatment</option>
                            <option value="Odor Removal" {{ old('service_type') == 'Odor Removal' ? 'selected' : '' }}>Odor Removal</option>
                            <option value="Conditioning" {{ old('service_type') == 'Conditioning' ? 'selected' : '' }}>Conditioning</option>
                            <option value="Complete Care Package" {{ old('service_type') == 'Complete Care Package' ? 'selected' : '' }}>Complete Care Package</option>
                        </select>
                    </div>

                    <!-- Reservation Date -->
                    <div>
                        <label for="reservation_date" class="block text-sm font-medium text-gray-700 mb-2">Preferred Date *</label>
                        <input type="date" 
                               id="reservation_date" 
                               name="reservation_date" 
                               value="{{ old('reservation_date') }}" 
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Reservation Time -->
                    <div>
                        <label for="reservation_time" class="block text-sm font-medium text-gray-700 mb-2">Preferred Time *</label>
                        <select id="reservation_time" 
                                name="reservation_time" 
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Time</option>
                            <option value="09:00" {{ old('reservation_time') == '09:00' ? 'selected' : '' }}>9:00 AM</option>
                            <option value="10:00" {{ old('reservation_time') == '10:00' ? 'selected' : '' }}>10:00 AM</option>
                            <option value="11:00" {{ old('reservation_time') == '11:00' ? 'selected' : '' }}>11:00 AM</option>
                            <option value="12:00" {{ old('reservation_time') == '12:00' ? 'selected' : '' }}>12:00 PM</option>
                            <option value="13:00" {{ old('reservation_time') == '13:00' ? 'selected' : '' }}>1:00 PM</option>
                            <option value="14:00" {{ old('reservation_time') == '14:00' ? 'selected' : '' }}>2:00 PM</option>
                            <option value="15:00" {{ old('reservation_time') == '15:00' ? 'selected' : '' }}>3:00 PM</option>
                            <option value="16:00" {{ old('reservation_time') == '16:00' ? 'selected' : '' }}>4:00 PM</option>
                            <option value="17:00" {{ old('reservation_time') == '17:00' ? 'selected' : '' }}>5:00 PM</option>
                        </select>
                    </div>
                </div>

                <!-- Additional Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Additional Notes (Optional)</label>
                    <textarea id="notes" 
                              name="notes" 
                              rows="4" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Any specific concerns or requests about your shoes...">{{ old('notes') }}</textarea>
                </div>

                <!-- Submit Buttons -->
                <div class="flex space-x-4">
                    <button type="submit" 
                            style="background-color: #16a34a !important; color: white !important; padding: 14px 28px; font-size: 16px; font-weight: 600; border: none; border-radius: 6px; cursor: pointer;">
                        Submit Reservation
                    </button>
                    <a href="{{ route('aftercare') }}" 
                       style="background-color: #6b7280 !important; color: white !important; padding: 14px 28px; font-size: 16px; font-weight: 600; border: none; border-radius: 6px; cursor: pointer; text-decoration: none; display: inline-block;">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Service Information -->
        <div class="mt-8 bg-blue-50 border-l-4 border-blue-600 p-6 rounded">
            <h3 class="font-semibold text-lg text-gray-900 mb-3">What to Expect</h3>
            <ul class="space-y-2 text-gray-700">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Your reservation request will be reviewed within 24 hours</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>We'll contact you via email or phone to confirm your appointment</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Please bring your shoes clean and in a bag</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Service typically takes 1-2 hours depending on the type</span>
                </li>
            </ul>
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
