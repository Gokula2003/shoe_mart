<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Voucher Billing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Order Summary -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Order Summary</h3>
                <div class="bg-purple-50 rounded-lg p-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-700">Voucher Amount:</span>
                        <span class="text-2xl font-bold text-purple-700">${{ number_format($voucherData['amount'], 2) }}</span>
                    </div>
                    @if($voucherData['description'])
                        <div class="mt-3 pt-3 border-t border-purple-200">
                            <p class="text-sm text-gray-600"><strong>Note:</strong> {{ $voucherData['description'] }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Billing Form -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Payment Details</h3>

                <form action="{{ route('vouchers.billing.process') }}" method="POST" id="billingForm">
                    @csrf

                    <!-- Sender Details -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Contact Information</h4>
                        
                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email', auth()->user()->email) }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                placeholder="your@email.com"
                            >
                            @error('email')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone') }}"
                                required
                                maxlength="10"
                                pattern="[0-9]{10}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                                placeholder="1234567890"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            >
                            @error('phone')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Card Payment -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Card Payment</h4>
                        
                        <!-- Card Holder Name -->
                        <div class="mb-4">
                            <label for="card_holder" class="block text-sm font-medium text-gray-700 mb-2">
                                Card Holder Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="card_holder" 
                                name="card_holder" 
                                value="{{ old('card_holder') }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('card_holder') border-red-500 @enderror"
                                placeholder="John Doe"
                            >
                            @error('card_holder')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Card Number -->
                        <div class="mb-4">
                            <label for="card_number" class="block text-sm font-medium text-gray-700 mb-2">
                                Card Number <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="card_number" 
                                name="card_number" 
                                value="{{ old('card_number') }}"
                                required
                                maxlength="16"
                                pattern="[0-9]{16}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('card_number') border-red-500 @enderror"
                                placeholder="1234 5678 9012 3456"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            >
                            @error('card_number')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Expiry and CVV -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="expiry_month" class="block text-sm font-medium text-gray-700 mb-2">
                                    Month <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="expiry_month" 
                                    name="expiry_month" 
                                    value="{{ old('expiry_month') }}"
                                    required
                                    maxlength="2"
                                    pattern="[0-9]{2}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('expiry_month') border-red-500 @enderror"
                                    placeholder="MM"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                >
                                @error('expiry_month')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="expiry_year" class="block text-sm font-medium text-gray-700 mb-2">
                                    Year <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="expiry_year" 
                                    name="expiry_year" 
                                    value="{{ old('expiry_year') }}"
                                    required
                                    maxlength="4"
                                    pattern="[0-9]{4}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('expiry_year') border-red-500 @enderror"
                                    placeholder="YYYY"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                >
                                @error('expiry_year')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cvv" class="block text-sm font-medium text-gray-700 mb-2">
                                    CVV <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="cvv" 
                                    name="cvv" 
                                    value="{{ old('cvv') }}"
                                    required
                                    maxlength="3"
                                    pattern="[0-9]{3}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('cvv') border-red-500 @enderror"
                                    placeholder="123"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                >
                                @error('cvv')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Security Notice -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <div class="text-sm text-blue-800">
                                <p class="font-semibold mb-1">Secure Payment</p>
                                <p>Your payment information is encrypted and secure. We never store your full card details.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4">
                        <a href="{{ route('vouchers.shop') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-4 px-6 rounded-lg transition duration-200 text-center">
                            Cancel
                        </a>
                        <button 
                            type="submit"
                            class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-4 px-6 rounded-lg transition duration-200 shadow-lg hover:shadow-xl transform hover:scale-105"
                        >
                            Complete Purchase - ${{ number_format($voucherData['amount'], 2) }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Email validation
        document.getElementById('email').addEventListener('input', function(e) {
            const email = e.target.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                e.target.setCustomValidity('Please enter a valid email address');
            } else {
                e.target.setCustomValidity('');
            }
        });

        // Format card number with spaces
        document.getElementById('card_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '');
            if (value.length > 16) {
                value = value.substring(0, 16);
            }
            e.target.value = value;
        });
    </script>
    @endpush
</x-app-layout>
