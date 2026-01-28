@extends('admin.layout')

@section('title', 'Add Product')

@section('content')
<div class="px-4 py-6">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Add Product</h1>
        <p class="text-gray-600">Choose what type of product you want to add</p>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="admin-card p-8">
            <form id="productTypeForm" method="GET">
                <div class="mb-6">
                    <label for="productType" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Product Type
                    </label>
                    <select 
                        id="productType" 
                        name="type" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required
                    >
                        <option value="">-- Choose Product Type --</option>
                        <option value="shoe">Shoe Product</option>
                        <option value="voucher">Voucher</option>
                        <option value="gift">Gift Order</option>
                    </select>
                </div>

                <div id="productDescription" class="mb-6 p-4 bg-blue-50 rounded-lg hidden">
                    <p class="text-sm text-gray-700"></p>
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-3 px-6 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl"
                >
                    Continue
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const productType = document.getElementById('productType');
    const productDescription = document.getElementById('productDescription');
    const form = document.getElementById('productTypeForm');
    
    const descriptions = {
        shoe: 'Add a new shoe product to your inventory with details like name, price, description, and stock.',
        voucher: 'Create a voucher that customers can purchase and use for discounts on their orders.',
        gift: 'Create a gift order where customers can send products as gifts to recipients.'
    };
    
    productType.addEventListener('change', function() {
        if (this.value) {
            productDescription.classList.remove('hidden');
            productDescription.querySelector('p').textContent = descriptions[this.value];
        } else {
            productDescription.classList.add('hidden');
        }
    });
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const selectedType = productType.value;
        
        if (!selectedType) {
            alert('Please select a product type');
            return;
        }
        
        // Redirect based on selection
        switch(selectedType) {
            case 'shoe':
                window.location.href = '{{ route('admin.products.create') }}';
                break;
            case 'voucher':
                window.location.href = '{{ route('admin.vouchers.create') }}';
                break;
            case 'gift':
                window.location.href = '{{ route('admin.gifts.create') }}';
                break;
        }
    });
</script>
@endsection
