<div>
    <div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Send Shoes as a Gift</h1>
                <p class="text-lg text-gray-600">Surprise someone special with the perfect pair of shoes!</p>
            </div>

            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg mb-8" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                    <p class="font-medium">{{ session('message') }}</p>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-8" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Product Selection or Gift Form -->
            @if($showProductSelection)
                <!-- Product Selection -->
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Select a Product to Gift</h2>
                    
                    <!-- Search Bar -->
                    <div class="mb-6">
                        <input 
                            type="text" 
                            wire:model.live="searchTerm"
                            placeholder="Search for shoes..."
                            class="w-full px-6 py-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent text-lg"
                        >
                    </div>

                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @forelse($products as $product)
                            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition cursor-pointer" wire:click="selectProduct({{ $product->id }})">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-800 mb-1">{{ $product->name }}</h3>
                                    <p class="text-pink-600 font-bold text-lg">${{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <p class="text-gray-500">No products found</p>
                            </div>
                        @endforelse
                    </div>

                    @if($products->hasPages())
                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            @else
                <!-- Gift Form -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Selected Product -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Selected Product</h3>
                            
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                            @endif
                            
                            <h4 class="font-semibold text-gray-800 mb-2">{{ $product->name }}</h4>
                            <p class="text-pink-600 font-bold text-xl mb-4">${{ number_format($product->price, 2) }}</p>
                            
                            <!-- Quantity -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                                <div class="flex items-center space-x-3">
                                    <button 
                                        type="button"
                                        wire:click="$set('quantity', {{ max(1, $quantity - 1) }})"
                                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-lg transition"
                                    >
                                        -
                                    </button>
                                    <input 
                                        type="number" 
                                        wire:model="quantity"
                                        min="1"
                                        class="w-20 text-center px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500"
                                    >
                                    <button 
                                        type="button"
                                        wire:click="$set('quantity', {{ $quantity + 1 }})"
                                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-lg transition"
                                    >
                                        +
                                    </button>
                                </div>
                            </div>

                            <div class="border-t pt-4">
                                <div class="flex justify-between items-center text-lg font-bold">
                                    <span>Total:</span>
                                    <span class="text-pink-600">${{ number_format($product->price * $quantity, 2) }}</span>
                                </div>
                            </div>

                            <button 
                                type="button"
                                wire:click="changeProduct"
                                class="w-full mt-4 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
                            >
                                Change Product
                            </button>
                        </div>
                    </div>

                    <!-- Gift Details Form -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-lg p-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6">Recipient Details</h2>
                            
                            <form wire:submit.prevent="sendGift">
                                <!-- Recipient Name -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Recipient Name *</label>
                                    <input 
                                        type="text" 
                                        wire:model="recipient_name"
                                        placeholder="Enter recipient's full name"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('recipient_name') border-red-500 @enderror"
                                    >
                                    @error('recipient_name')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Recipient Email -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Recipient Email *</label>
                                    <input 
                                        type="email" 
                                        wire:model="recipient_email"
                                        placeholder="recipient@example.com"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('recipient_email') border-red-500 @enderror"
                                    >
                                    @error('recipient_email')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Recipient Phone -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Recipient Phone</label>
                                    <input 
                                        type="tel" 
                                        wire:model="recipient_phone"
                                        maxlength="10"
                                        pattern="[0-9]{10}"
                                        placeholder="1234567890"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                    >
                                </div>

                                <!-- Recipient Address -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Address *</label>
                                    <textarea 
                                        wire:model="recipient_address"
                                        rows="3"
                                        placeholder="Enter complete delivery address"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('recipient_address') border-red-500 @enderror"
                                    ></textarea>
                                    @error('recipient_address')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Gift Message -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Gift Message</label>
                                    <textarea 
                                        wire:model="gift_message"
                                        rows="4"
                                        placeholder="Add a personal message for the recipient..."
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                    ></textarea>
                                    @error('gift_message')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <button 
                                    type="submit"
                                    class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-4 px-6 rounded-lg transition duration-200 shadow-lg hover:shadow-xl transform hover:scale-105"
                                >
                                    Send Gift
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
