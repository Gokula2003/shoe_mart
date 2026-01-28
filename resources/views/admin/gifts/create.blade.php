@extends('admin.layout')

@section('title', 'Create Gift Order')

@section('content')
<div class="px-4 py-6">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Create Gift Order</h1>
        <p class="text-gray-600">Create a new gift order manually</p>
    </div>

    <div class="max-w-4xl mx-auto">
        <div class="admin-card p-8">
            <form action="{{ route('admin.gifts.store') }}" method="POST">
                @csrf

                <!-- Sender Information -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Sender Information</h2>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="sender_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Sender (User) <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="sender_id" 
                                name="sender_id" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sender_id') border-red-500 @enderror"
                                required
                            >
                                <option value="">-- Select Sender --</option>
                                @foreach(\App\Models\User::orderBy('name')->get() as $user)
                                <option value="{{ $user->id }}" {{ old('sender_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                                @endforeach
                            </select>
                            @error('sender_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Recipient Information -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Recipient Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="recipient_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Recipient Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="recipient_name" 
                                name="recipient_name" 
                                value="{{ old('recipient_name') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('recipient_name') border-red-500 @enderror"
                                required
                            >
                            @error('recipient_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="recipient_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Recipient Email <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="recipient_email" 
                                name="recipient_email" 
                                value="{{ old('recipient_email') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('recipient_email') border-red-500 @enderror"
                                required
                            >
                            @error('recipient_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="recipient_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Recipient Phone <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="tel" 
                                id="recipient_phone" 
                                name="recipient_phone" 
                                value="{{ old('recipient_phone') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('recipient_phone') border-red-500 @enderror"
                                required
                            >
                            @error('recipient_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="recipient_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Recipient Address <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="recipient_address" 
                                name="recipient_address" 
                                rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('recipient_address') border-red-500 @enderror"
                                required
                            >{{ old('recipient_address') }}</textarea>
                            @error('recipient_address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Product Information -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Product Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Product <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="product_id" 
                                name="product_id" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('product_id') border-red-500 @enderror"
                                required
                            >
                                <option value="">-- Select Product --</option>
                                @foreach(\App\Models\Product::where('stock', '>', 0)->orderBy('name')->get() as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} - ${{ number_format($product->price, 2) }} (Stock: {{ $product->stock }})
                                </option>
                                @endforeach
                            </select>
                            @error('product_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                Quantity <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="quantity" 
                                name="quantity" 
                                value="{{ old('quantity', 1) }}"
                                min="1"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('quantity') border-red-500 @enderror"
                                required
                            >
                            @error('quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="gift_message" class="block text-sm font-medium text-gray-700 mb-2">
                                Gift Message
                            </label>
                            <textarea 
                                id="gift_message" 
                                name="gift_message" 
                                rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('gift_message') border-red-500 @enderror"
                                placeholder="Optional gift message"
                            >{{ old('gift_message') }}</textarea>
                            @error('gift_message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button 
                        type="submit" 
                        class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-3 px-6 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl"
                    >
                        Create Gift Order
                    </button>
                    <a 
                        href="{{ route('admin.gifts.index') }}" 
                        class="flex-1 bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg hover:bg-gray-300 transition-all text-center"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Calculate total when product or quantity changes
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    
    function updateMaxQuantity() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption.value) {
            const stock = parseInt(selectedOption.dataset.stock);
            quantityInput.max = stock;
        }
    }
    
    productSelect.addEventListener('change', updateMaxQuantity);
    updateMaxQuantity();
</script>
@endsection
