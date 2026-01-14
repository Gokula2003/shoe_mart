<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-navigation />

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Checkout</h1>

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Checkout Form -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Shipping Information</h2>

                <form action="{{ route('order.place') }}" method="POST">
                    @csrf

                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ auth()->user()->name ?? '' }}" 
                                   required
                                   class="form-input w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                                   placeholder="John Doe">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ auth()->user()->email ?? '' }}" 
                                   required
                                   class="form-input w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                                   placeholder="john@example.com">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   required
                                   maxlength="10"
                                   pattern="[0-9]{10}"
                                   class="form-input w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                                   placeholder="1234567890"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Shipping Address</label>
                            <textarea id="address" 
                                      name="address" 
                                      rows="3" 
                                      required
                                      class="form-textarea w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                                      placeholder="Street address, City, State, ZIP">{{ auth()->user()->address ?? '' }}</textarea>
                        </div>

                        <!-- Payment Method -->
                        <div x-data="{ paymentMethod: 'cod' }">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="radio" 
                                           id="cod" 
                                           name="payment_method" 
                                           value="cod" 
                                           checked
                                           x-model="paymentMethod"
                                           class="h-4 w-4 text-blue-600">
                                    <label for="cod" class="ml-2 text-gray-700">Cash on Delivery</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" 
                                           id="card" 
                                           name="payment_method" 
                                           value="card"
                                           x-model="paymentMethod"
                                           class="h-4 w-4 text-blue-600">
                                    <label for="card" class="ml-2 text-gray-700">Credit/Debit Card</label>
                                </div>
                            </div>

                            <!-- Card Details Section (shown when card is selected) -->
                            <div x-show="paymentMethod === 'card'" 
                                 x-transition
                                 class="mt-4 p-4 bg-gray-50 rounded-lg space-y-4"
                                 style="display: none;">
                                
                                <h3 class="font-semibold text-gray-900 mb-3">Card Details</h3>
                                
                                <!-- Card Number -->
                                <div>
                                    <label for="card_number" class="block text-sm font-medium text-gray-700 mb-2">Card Number</label>
                                    <input type="text" 
                                           id="card_number" 
                                           name="card_number" 
                                           maxlength="19"
                                           placeholder="1234 5678 9012 3456"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                                           x-bind:required="paymentMethod === 'card'"
                                           pattern="[0-9\s]{13,19}">
                                </div>

                                <!-- Card Holder Name -->
                                <div>
                                    <label for="card_holder" class="block text-sm font-medium text-gray-700 mb-2">Card Holder Name</label>
                                    <input type="text" 
                                           id="card_holder" 
                                           name="card_holder" 
                                           placeholder="John Doe"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                                           x-bind:required="paymentMethod === 'card'">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Expiry Date -->
                                    <div>
                                        <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-2">Expiry Date</label>
                                        <input type="text" 
                                               id="expiry_date" 
                                               name="expiry_date" 
                                               placeholder="MM/YY"
                                               maxlength="5"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                                               x-bind:required="paymentMethod === 'card'"
                                               pattern="[0-9]{2}/[0-9]{2}">
                                    </div>

                                    <!-- CVV -->
                                    <div>
                                        <label for="cvv" class="block text-sm font-medium text-gray-700 mb-2">CVV</label>
                                        <input type="text" 
                                               id="cvv" 
                                               name="cvv" 
                                               placeholder="123"
                                               maxlength="3"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                                               x-bind:required="paymentMethod === 'card'"
                                               pattern="[0-9]{3}"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Order Notes (Optional)</label>
                            <textarea id="notes" 
                                      name="notes" 
                                      rows="2" 
                                      class="form-textarea w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                                      placeholder="Any special instructions for delivery"></textarea>
                        </div>
                    </div>

                    <button type="submit" 
                            style="background-color: #16a34a !important; color: white !important; width: 100%; padding: 14px; font-size: 18px; font-weight: 600; border: none; border-radius: 6px; cursor: pointer; margin-top: 24px;">
                        Place Order
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">Order Summary</h2>
                    
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <div class="flex items-center space-x-4 pb-4 border-b">
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center flex-shrink-0">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover rounded">
                                    @else
                                        <span class="text-gray-400 text-2xl">👟</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-600">Size: {{ $item->size }} | Qty: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Price Details</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                            <span class="font-semibold">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping Fee</span>
                            <span class="font-semibold text-green-600">Free</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax</span>
                            <span class="font-semibold">$0.00</span>
                        </div>
                        <div class="border-t pt-3 flex justify-between">
                            <span class="text-xl font-bold">Total Amount</span>
                            <span class="text-xl font-bold text-blue-600">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
