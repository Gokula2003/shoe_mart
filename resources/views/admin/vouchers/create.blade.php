@extends('admin.layout')

@section('title', 'Create Voucher')

@section('content')
<div class="px-4 py-6">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Create New Voucher</h1>
        <p class="text-gray-600">Add a new voucher to your store</p>
    </div>

    <div class="max-w-3xl mx-auto">
        <div class="admin-card p-8">
            <form action="{{ route('admin.vouchers.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                        Voucher Code <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="code" 
                        name="code" 
                        value="{{ old('code') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('code') border-red-500 @enderror"
                        placeholder="e.g., SUMMER2026"
                        required
                    >
                    @error('code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Enter a unique voucher code or leave blank to auto-generate</p>
                </div>

                <div class="mb-6">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Voucher Amount ($) <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="amount" 
                        name="amount" 
                        value="{{ old('amount') }}"
                        step="0.01"
                        min="0.01"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('amount') border-red-500 @enderror"
                        placeholder="50.00"
                        required
                    >
                    @error('amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                        placeholder="e.g., Summer Sale Voucher"
                    >{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-2">
                        Expiration Date
                    </label>
                    <input 
                        type="date" 
                        id="expires_at" 
                        name="expires_at" 
                        value="{{ old('expires_at') }}"
                        min="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('expires_at') border-red-500 @enderror"
                    >
                    @error('expires_at')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Leave blank for no expiration</p>
                </div>

                <div class="flex space-x-4">
                    <button 
                        type="submit" 
                        class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-3 px-6 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl"
                    >
                        Create Voucher
                    </button>
                    <a 
                        href="{{ route('admin.vouchers.index') }}" 
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
    // Auto-generate code button
    document.getElementById('code').addEventListener('focus', function() {
        if (!this.value) {
            this.placeholder = 'Generating code...';
            setTimeout(() => {
                this.value = 'VOUCHER' + Date.now().toString(36).toUpperCase();
                this.placeholder = 'e.g., SUMMER2026';
            }, 500);
        }
    });
</script>
@endsection
