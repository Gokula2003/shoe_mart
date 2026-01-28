<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift Order Successful - ShoeMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-pink-50 via-white to-purple-50">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-3xl w-full bg-white rounded-2xl shadow-2xl p-8 md:p-12">
            <!-- Success Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Gift Order Placed Successfully!</h1>
                <p class="text-gray-600">Your thoughtful gift is on its way</p>
            </div>

            <!-- Order Summary Card -->
            <div class="bg-gradient-to-r from-pink-500 to-purple-500 rounded-xl p-8 text-white mb-8">
                <div class="text-center mb-6">
                    <p class="text-sm opacity-90 mb-2">Order Number</p>
                    <p class="text-2xl font-bold">#{{ str_pad($giftOrder->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>

                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm opacity-90 mb-2">Product</p>
                            <p class="font-semibold text-lg">{{ $giftOrder->product->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm opacity-90 mb-2">Quantity</p>
                            <p class="font-semibold text-lg">{{ $giftOrder->quantity }} {{ $giftOrder->quantity > 1 ? 'pairs' : 'pair' }}</p>
                        </div>
                        <div>
                            <p class="text-sm opacity-90 mb-2">Total Amount</p>
                            <p class="font-bold text-2xl">${{ number_format($giftOrder->total_amount, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm opacity-90 mb-2">Status</p>
                            <p class="font-semibold text-lg capitalize">{{ $giftOrder->status }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recipient Information -->
            <div class="bg-pink-50 rounded-lg p-6 mb-8">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Recipient Information
                </h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-600">Name</p>
                        <p class="font-semibold text-gray-900">{{ $giftOrder->recipient_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Email</p>
                        <p class="font-semibold text-gray-900">{{ $giftOrder->recipient_email }}</p>
                    </div>
                    @if($giftOrder->recipient_phone)
                        <div>
                            <p class="text-gray-600">Phone</p>
                            <p class="font-semibold text-gray-900">{{ $giftOrder->recipient_phone }}</p>
                        </div>
                    @endif
                    <div>
                        <p class="text-gray-600">Delivery Address</p>
                        <p class="font-semibold text-gray-900">{{ $giftOrder->recipient_address }}</p>
                    </div>
                </div>
            </div>

            <!-- Gift Message -->
            @if($giftOrder->gift_message)
                <div class="bg-purple-50 rounded-lg p-6 mb-8">
                    <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        Your Gift Message
                    </h3>
                    <p class="text-gray-700 italic">"{{ $giftOrder->gift_message }}"</p>
                </div>
            @endif

            <!-- Next Steps -->
            <div class="bg-blue-50 rounded-lg p-6 mb-8">
                <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    What Happens Next?
                </h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start">
                        <span class="inline-block w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs mr-3 mt-0.5 flex-shrink-0">1</span>
                        <span>We'll process your gift order and prepare it for shipping</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-block w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs mr-3 mt-0.5 flex-shrink-0">2</span>
                        <span>The recipient will receive an email notification about their gift</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-block w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs mr-3 mt-0.5 flex-shrink-0">3</span>
                        <span>You'll receive tracking information once the gift is shipped</span>
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('gift.send') }}" class="flex-1 text-center px-6 py-3 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition font-semibold">
                    Send Another Gift
                </a>
                <a href="{{ route('products.index') }}" class="flex-1 text-center px-6 py-3 border-2 border-pink-600 text-pink-600 rounded-lg hover:bg-pink-50 transition font-semibold">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</body>
</html>
