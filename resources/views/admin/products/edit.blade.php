@extends('admin.layout')

@section('title', 'Edit Product')

@section('content')
<div class="px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Products</a>
    </div>

    <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit Product</h1>

    <div class="bg-white rounded-lg shadow-md p-6">
        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $product->name) }}" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="e.g., Nike Air Max 270">
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select id="category" 
                            name="category" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Category</option>
                        <option value="Running" {{ old('category', $product->category) == 'Running' ? 'selected' : '' }}>Running</option>
                        <option value="Casual" {{ old('category', $product->category) == 'Casual' ? 'selected' : '' }}>Casual</option>
                        <option value="Basketball" {{ old('category', $product->category) == 'Basketball' ? 'selected' : '' }}>Basketball</option>
                        <option value="Skateboard" {{ old('category', $product->category) == 'Skateboard' ? 'selected' : '' }}>Skateboard</option>
                        <option value="Walking" {{ old('category', $product->category) == 'Walking' ? 'selected' : '' }}>Walking</option>
                        <option value="Formal" {{ old('category', $product->category) == 'Formal' ? 'selected' : '' }}>Formal</option>
                    </select>
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price ($) *</label>
                    <input type="number" 
                           id="price" 
                           name="price" 
                           value="{{ old('price', $product->price) }}" 
                           step="0.01" 
                           min="0" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="0.00">
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity *</label>
                    <input type="number" 
                           id="stock" 
                           name="stock" 
                           value="{{ old('stock', $product->stock) }}" 
                           min="0" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="0">
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                <textarea id="description" 
                          name="description" 
                          rows="4" 
                          required
                          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Enter detailed product description">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Current Image -->
            @if($product->image)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-32 w-32 object-cover rounded">
                </div>
            @endif

            <!-- Product Image -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $product->image ? 'Change Image (Optional)' : 'Product Image' }}
                </label>
                <input type="file" 
                       id="image" 
                       name="image" 
                       accept="image/jpeg,image/png,image/jpg,image/gif"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-sm text-gray-500">Accepted formats: JPEG, PNG, JPG, GIF (Max: 2MB)</p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex space-x-4">
                <button type="submit" 
                        style="background-color: #2563eb !important; color: white !important; padding: 12px 24px; font-size: 16px; font-weight: 600; border: none; border-radius: 6px; cursor: pointer;">
                    Update Product
                </button>
                <a href="{{ route('admin.products.index') }}" 
                   style="background-color: #6b7280 !important; color: white !important; padding: 12px 24px; font-size: 16px; font-weight: 600; border: none; border-radius: 6px; cursor: pointer; text-decoration: none; display: inline-block;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
