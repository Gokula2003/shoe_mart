<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-3px); box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15); }
        .input-field { transition: all 0.3s ease; }
        .input-field:focus { transform: translateY(-2px); box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.2); }
        .payment-option { transition: all 0.3s ease; cursor: pointer; }
        .payment-option:hover { transform: scale(1.02); }
        .payment-option.selected { border-color: #667eea; background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, transparent 100%); }
        .order-item { transition: all 0.3s ease; }
        .order-item:hover { background: linear-gradient(90deg, rgba(102, 126, 234, 0.05) 0%, transparent 100%); }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-purple-50 min-h-screen">
    <!-- Navigation -->
    <x-navigation />

    <!-- Hero Section -->
    <div class="hero-gradient py-16 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
            <span class="text-6xl mb-4 block">💳</span>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Checkout</h1>
            <p class="text-xl text-white/90">Complete your order securely</p>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 -mt-8">
        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-xl shadow-lg flex items-center">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Checkout Form -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 card-hover">
                <div class="flex items-center mb-8">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-blue-500 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Shipping Information</h2>
                </div>

                <form action="{{ route('order.place') }}" method="POST">
                    @csrf

                    <div class="space-y-5">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ auth()->user()->name ?? '' }}" 
                                   required
                                   class="input-field w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                                   placeholder="John Doe">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ auth()->user()->email ?? '' }}" 
                                   required
                                   class="input-field w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                                   placeholder="john@example.com">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   required
                                   maxlength="10"
                                   pattern="[0-9]{10}"
                                   class="input-field w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all"
                                   placeholder="1234567890"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-bold text-gray-700 mb-2">Shipping Address</label>
                            <textarea id="address" 
                                      name="address" 
                                      rows="3" 
                                      required
                                      class="input-field w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all resize-none"
                                      placeholder="Street address, City, State, ZIP">{{ auth()->user()->address ?? '' }}</textarea>
                        </div>

                        <!-- Payment Method -->
                        <div x-data="{ paymentMethod: 'cod' }">
                            <label class="block text-sm font-bold text-gray-700 mb-4">Payment Method</label>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <label class="payment-option flex items-center p-4 border-2 rounded-xl cursor-pointer" 
                                       :class="paymentMethod === 'cod' ? 'border-purple-500 bg-purple-50' : 'border-gray-200'">
                                    <input type="radio" 
                                           id="cod" 
                                           name="payment_method" 
                                           value="cod" 
                                           checked
                                           x-model="paymentMethod"
                                           class="hidden">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-500 rounded-lg flex items-center justify-center mr-3">
                                        <span class="text-xl">💵</span>
                                    </div>
                                    <div>
                                        <span class="font-bold text-gray-900 block">Cash on Delivery</span>
                                        <span class="text-xs text-gray-500">Pay when you receive</span>
                                    </div>
                                </label>
                                <label class="payment-option flex items-center p-4 border-2 rounded-xl cursor-pointer"
                                       :class="paymentMethod === 'card' ? 'border-purple-500 bg-purple-50' : 'border-gray-200'">
                                    <input type="radio" 
                                           id="card" 
                                           name="payment_method" 
                                           value="card"
                                           x-model="paymentMethod"
                                           class="hidden">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg flex items-center justify-center mr-3">
                                        <span class="text-xl">💳</span>
                                    </div>
                                    <div>
                                        <span class="font-bold text-gray-900 block">Card Payment</span>
                                        <span class="text-xs text-gray-500">Credit/Debit card</span>
                                    </div>
                                </label>
                            </div>

                            <!-- Card Details Section (shown when card is selected) -->
                            <div x-show="paymentMethod === 'card'" 
                                 x-transition
                                 class="p-6 bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl space-y-4 border border-blue-100"
                                 style="display: none;">
                                
                                <h3 class="font-bold text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                    Card Details
                                </h3>
                                
                                <!-- Card Number -->
                                <div>
                                    <label for="card_number" class="block text-sm font-semibold text-gray-700 mb-2">Card Number</label>
                                    <input type="text" 
                                           id="card_number" 
                                           name="card_number" 
                                           maxlength="19"
                                           placeholder="1234 5678 9012 3456"
                                           class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           x-bind:required="paymentMethod === 'card'"
                                           pattern="[0-9\s]{13,19}">
                                </div>

                                <!-- Card Holder Name -->
                                <div>
                                    <label for="card_holder" class="block text-sm font-semibold text-gray-700 mb-2">Card Holder Name</label>
                                    <input type="text" 
                                           id="card_holder" 
                                           name="card_holder" 
                                           placeholder="John Doe"
                                           class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           x-bind:required="paymentMethod === 'card'">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Expiry Date -->
                                    <div>
                                        <label for="expiry_date" class="block text-sm font-semibold text-gray-700 mb-2">Expiry Date</label>
                                        <input type="text" 
                                               id="expiry_date" 
                                               name="expiry_date" 
                                               placeholder="MM/YY"
                                               maxlength="5"
                                               class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               x-bind:required="paymentMethod === 'card'"
                                               pattern="[0-9]{2}/[0-9]{2}">
                                    </div>

                                    <!-- CVV -->
                                    <div>
                                        <label for="cvv" class="block text-sm font-semibold text-gray-700 mb-2">CVV</label>
                                        <input type="text" 
                                               id="cvv" 
                                               name="cvv" 
                                               placeholder="123"
                                               maxlength="3"
                                               class="input-field w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               x-bind:required="paymentMethod === 'card'"
                                               pattern="[0-9]{3}"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-bold text-gray-700 mb-2">Order Notes (Optional)</label>
                            <textarea id="notes" 
                                      name="notes" 
                                      rows="2" 
                                      class="input-field w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all resize-none"
                                      placeholder="Any special instructions for delivery"></textarea>
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full mt-8 bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 px-6 rounded-xl hover:from-green-600 hover:to-emerald-700 transition font-bold text-lg shadow-xl hover:shadow-2xl transform hover:scale-[1.02] flex items-center justify-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Place Order
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl shadow-2xl p-8 card-hover">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Order Summary</h2>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <div class="order-item flex items-center space-x-4 pb-4 border-b border-gray-100 rounded-lg p-2">
                                <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden shadow-inner">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="text-gray-400 text-3xl">👟</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900">{{ $item->product->name }}</h3>
                                    <div class="flex gap-2 mt-1">
                                        <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-full">Size: {{ $item->size }}</span>
                                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-600 rounded-full">Qty: {{ $item->quantity }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-lg text-purple-600">${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-2xl p-8 card-hover">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Price Details</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600">Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                            <span class="font-semibold text-gray-900">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600">Shipping Fee</span>
                            <span class="font-semibold text-green-600 flex items-center">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Free
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600">Tax</span>
                            <span class="font-semibold text-gray-900">$0.00</span>
                        </div>
                        <div class="flex justify-between items-center py-4 bg-gradient-to-r from-purple-50 to-blue-50 rounded-xl px-4 -mx-4 mt-4">
                            <span class="text-xl font-bold text-gray-900">Total Amount</span>
                            <span class="text-2xl font-bold text-purple-600">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Trust Badges -->
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <span class="text-xs text-gray-600">Secure</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <span class="text-xs text-gray-600">Fast Delivery</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                </div>
                                <span class="text-xs text-gray-600">Easy Returns</span>
                            </div>
                        </div>
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
