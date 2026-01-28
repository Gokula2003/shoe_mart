<div class="space-y-4">
    @if($showSuccess)
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            Product added to cart successfully!
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold mb-4">Add to Cart</h3>

        <form wire:submit.prevent="addToCart">
            <!-- Size Selection -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Size *</label>
                <select 
                    wire:model="size"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('size') border-red-500 @enderror"
                >
                    <option value="">Choose a size</option>
                    @foreach($availableSizes as $availableSize)
                        <option value="{{ $availableSize }}">{{ $availableSize }}</option>
                    @endforeach
                </select>
                @error('size')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Quantity Selection -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                <div class="flex items-center space-x-3">
                    <button 
                        type="button"
                        wire:click="decrement"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-lg transition"
                        {{ $quantity <= 1 ? 'disabled' : '' }}
                    >
                        -
                    </button>
                    <input 
                        type="number" 
                        wire:model="quantity"
                        min="1"
                        max="{{ $product->stock }}"
                        class="w-20 text-center px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('quantity') border-red-500 @enderror"
                        readonly
                    >
                    <button 
                        type="button"
                        wire:click="increment"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-lg transition"
                        {{ $quantity >= $product->stock ? 'disabled' : '' }}
                    >
                        +
                    </button>
                </div>
                @error('quantity')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Available stock: {{ $product->stock }}</p>
            </div>

            <!-- Add to Cart Button -->
            <button 
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                {{ $product->stock <= 0 ? 'disabled' : '' }}
            >
                @if($product->stock <= 0)
                    Out of Stock
                @else
                    Add to Cart
                @endif
            </button>
        </form>
    </div>
</div>
