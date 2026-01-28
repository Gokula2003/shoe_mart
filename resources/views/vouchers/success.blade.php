<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher Purchase Successful - ShoeMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-purple-50 via-white to-blue-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-2xl w-full bg-white rounded-2xl shadow-2xl p-8 md:p-12">
            <!-- Success Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Voucher Purchased Successfully!</h1>
                <p class="text-gray-600">Your gift voucher is ready to use</p>
            </div>

            <!-- Voucher Details -->
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl p-8 text-white mb-8">
                <div class="text-center mb-6">
                    <p class="text-sm opacity-90 mb-2">Your Voucher Code</p>
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg py-4 px-6 inline-block">
                        <p class="font-mono text-3xl font-bold tracking-wider">{{ $voucher->code }}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Value</p>
                        <p class="text-2xl font-bold">${{ number_format($voucher->amount, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm opacity-90 mb-1">Expires On</p>
                        <p class="text-lg font-semibold">{{ $voucher->expires_at->format('M d, Y') }}</p>
                    </div>
                </div>

                @if($voucher->description)
                    <div class="mt-6 pt-6 border-t border-white/30">
                        <p class="text-sm opacity-90 mb-2">Note</p>
                        <p class="text-base">{{ $voucher->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Instructions -->
            <div class="bg-blue-50 rounded-lg p-6 mb-8">
                <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    How to Use Your Voucher
                </h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start">
                        <span class="inline-block w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs mr-3 mt-0.5 flex-shrink-0">1</span>
                        <span>Enter your voucher code at checkout</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-block w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs mr-3 mt-0.5 flex-shrink-0">2</span>
                        <span>The voucher amount will be deducted from your total</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-block w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs mr-3 mt-0.5 flex-shrink-0">3</span>
                        <span>Save this code or check "My Vouchers" section anytime</span>
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('vouchers.shop') }}" class="flex-1 text-center px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                    View My Vouchers
                </a>
                <a href="{{ route('products.index') }}" class="flex-1 text-center px-6 py-3 border-2 border-purple-600 text-purple-600 rounded-lg hover:bg-purple-50 transition font-semibold">
                    Start Shopping
                </a>
            </div>
        </div>
    </div>
</body>
</html>
