<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @if($orders->count() > 0)
                <!-- Orders List -->
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <!-- Order Header -->
                            <div class="p-6 border-b border-gray-200 bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">Order #{{ $order->order_number }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                               ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : 
                                               ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))) }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                        <p class="text-2xl font-bold text-gray-900 mt-2">${{ number_format($order->total, 2) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="p-6">
                                <h4 class="text-sm font-semibold text-gray-700 mb-4">Order Items</h4>
                                <div class="space-y-4">
                                    @foreach($order->items as $item)
                                        <div class="flex items-center space-x-4 pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                     alt="{{ $item->product_name }}" 
                                                     class="w-20 h-20 object-cover rounded-lg shadow-md">
                                            @else
                                                <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            
                                            <div class="flex-1">
                                                <h5 class="font-semibold text-gray-900">{{ $item->product_name }}</h5>
                                                <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                                                <p class="text-sm text-gray-600">Price: ${{ number_format($item->price, 2) }}</p>
                                            </div>
                                            
                                            <div class="text-right">
                                                <p class="font-bold text-gray-900">${{ number_format($item->subtotal, 2) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Order Summary -->
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between text-gray-600">
                                            <span>Subtotal:</span>
                                            <span>${{ number_format($order->subtotal, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between text-gray-600">
                                            <span>Tax (10%):</span>
                                            <span>${{ number_format($order->tax, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t border-gray-200">
                                            <span>Total:</span>
                                            <span>${{ number_format($order->total, 2) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Shipping Info -->
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <h5 class="text-sm font-semibold text-gray-700 mb-2">Shipping Information</h5>
                                    <div class="text-sm text-gray-600">
                                        <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                                        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                                        <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                                        <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
                                        <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="mt-8">
                        {{ $orders->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-12 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Orders Yet</h3>
                    <p class="text-gray-600 mb-6">You haven't placed any orders yet. Start shopping to see your orders here!</p>
                    <a href="{{ route('products.index') }}" class="btn-gradient inline-block">
                        Browse Products
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
