<div>
    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Gift Vouchers</h1>
                <p class="text-lg text-gray-600">Perfect gift for shoe lovers! Purchase a voucher and share the joy of shopping.</p>
            </div>

            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg mb-8" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                    <p class="font-medium">{{ session('message') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Purchase Voucher Section -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Purchase a Voucher</h2>
                    
                    <form wire:submit.prevent="purchaseVoucher">
                        <!-- Predefined Amounts -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Select Amount</label>
                            <div class="grid grid-cols-3 gap-3">
                                @foreach($voucherAmounts as $amount)
                                    <button 
                                        type="button"
                                        wire:click="selectAmount({{ $amount }})"
                                        class="py-4 px-6 rounded-lg border-2 transition-all {{ $selectedAmount == $amount ? 'border-purple-600 bg-purple-50 text-purple-700' : 'border-gray-300 hover:border-purple-400' }}"
                                    >
                                        <span class="text-xl font-bold">${{ $amount }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Custom Amount -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Or Enter Custom Amount</label>
                            <div class="flex gap-2">
                                <div class="relative flex-1">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">$</span>
                                    <input 
                                        type="number" 
                                        wire:model="customAmount"
                                        min="10"
                                        step="1"
                                        placeholder="Enter amount (min $10)"
                                        class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                    >
                                </div>
                                <button 
                                    type="button"
                                    wire:click="setCustomAmount"
                                    class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition"
                                >
                                    Apply
                                </button>
                            </div>
                            @error('selectedAmount')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Add a Note (Optional)</label>
                            <textarea 
                                wire:model="description"
                                rows="3"
                                placeholder="Add a personal message..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            ></textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Summary -->
                        @if($selectedAmount)
                            <div class="bg-purple-50 rounded-lg p-4 mb-6">
                                <div class="flex justify-between items-center text-lg font-semibold">
                                    <span>Voucher Value:</span>
                                    <span class="text-purple-700">${{ number_format($selectedAmount, 2) }}</span>
                                </div>
                            </div>
                        @endif

                        <!-- Purchase Button -->
                        <button 
                            type="submit"
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-4 px-6 rounded-lg transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg hover:shadow-xl transform hover:scale-105"
                            {{ !$selectedAmount ? 'disabled' : '' }}
                        >
                            Purchase Voucher
                        </button>
                    </form>
                </div>

                <!-- My Vouchers Section -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">My Vouchers</h2>
                    
                    @if(auth()->check())
                        @if($myVouchers->count() > 0)
                            <div class="space-y-4">
                                @foreach($myVouchers as $voucher)
                                    <div class="border-2 {{ $voucher->is_used ? 'border-gray-300 bg-gray-50' : 'border-purple-300 bg-purple-50' }} rounded-lg p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <p class="text-sm text-gray-600">Code</p>
                                                <p class="font-mono text-lg font-bold text-purple-700">{{ $voucher->code }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-2xl font-bold {{ $voucher->is_used ? 'text-gray-500' : 'text-purple-700' }}">
                                                    ${{ number_format($voucher->amount, 2) }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        @if($voucher->description)
                                            <p class="text-sm text-gray-600 mb-2">{{ $voucher->description }}</p>
                                        @endif
                                        
                                        <div class="flex justify-between items-center text-xs text-gray-500">
                                            <span>
                                                @if($voucher->is_used)
                                                    <span class="inline-block px-2 py-1 bg-gray-200 text-gray-700 rounded">Used</span>
                                                @elseif($voucher->expires_at && $voucher->expires_at->isPast())
                                                    <span class="inline-block px-2 py-1 bg-red-200 text-red-700 rounded">Expired</span>
                                                @else
                                                    <span class="inline-block px-2 py-1 bg-green-200 text-green-700 rounded">Active</span>
                                                @endif
                                            </span>
                                            <span>
                                                Expires: {{ $voucher->expires_at ? $voucher->expires_at->format('M d, Y') : 'Never' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                </svg>
                                <p class="text-gray-500">You don't have any vouchers yet.</p>
                                <p class="text-sm text-gray-400 mt-2">Purchase one to get started!</p>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-600 mb-4">Please log in to view your vouchers</p>
                            <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                                Log In
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
