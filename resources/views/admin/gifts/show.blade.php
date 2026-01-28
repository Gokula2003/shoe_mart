@extends('admin.layout')

@section('title', 'Gift Order Details')

@section('content')
<div class="px-4 py-6">
    <div class="mb-8">
        <a href="{{ route('admin.gifts.index') }}" class="text-blue-600 hover:text-blue-800 font-medium mb-4 inline-flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Gift Orders
        </a>
        <h1 class="text-4xl font-bold text-gray-900 mb-2 mt-4">Gift Order #{{ $giftOrder->id }}</h1>
        <p class="text-gray-600">View and manage gift order details</p>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Status -->
            <div class="admin-card p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Order Status</h2>
                <form action="{{ route('admin.gifts.updateStatus', $giftOrder->id) }}" method="POST" class="flex items-center space-x-4">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="pending" {{ $giftOrder->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $giftOrder->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $giftOrder->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $giftOrder->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $giftOrder->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Tracking Number -->
            <div class="admin-card p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Tracking Information</h2>
                <form action="{{ route('admin.gifts.updateTracking', $giftOrder->id) }}" method="POST" class="flex items-center space-x-4">
                    @csrf
                    @method('PATCH')
                    <input 
                        type="text" 
                        name="tracking_number" 
                        value="{{ $giftOrder->tracking_number }}"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter tracking number"
                    >
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Update Tracking
                    </button>
                </form>
                @if($giftOrder->tracking_number)
                <p class="mt-2 text-sm text-gray-600">Current: <span class="font-mono font-bold">{{ $giftOrder->tracking_number }}</span></p>
                @endif
            </div>

            <!-- Product Details -->
            <div class="admin-card p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Product Details</h2>
                <div class="flex items-start space-x-4">
                    @if($giftOrder->product->image)
                    <img src="{{ asset('storage/' . $giftOrder->product->image) }}" alt="{{ $giftOrder->product->name }}" class="w-24 h-24 object-cover rounded-lg">
                    @else
                    <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    @endif
                    <div class="flex-1">
                        <h3 class="font-bold text-lg">{{ $giftOrder->product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ $giftOrder->product->description }}</p>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <p><span class="text-gray-600">Price:</span> <span class="font-semibold">${{ number_format($giftOrder->product->price, 2) }}</span></p>
                            <p><span class="text-gray-600">Quantity:</span> <span class="font-semibold">{{ $giftOrder->quantity }}</span></p>
                            <p class="col-span-2"><span class="text-gray-600">Total Amount:</span> <span class="font-bold text-lg text-blue-600">${{ number_format($giftOrder->total_amount, 2) }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gift Message -->
            @if($giftOrder->gift_message)
            <div class="admin-card p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Gift Message</h2>
                <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                    <p class="text-gray-700 italic">"{{ $giftOrder->gift_message }}"</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Sender Information -->
            <div class="admin-card p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Sender</h2>
                <div class="space-y-2 text-sm">
                    <p><span class="text-gray-600">Name:</span> <span class="font-semibold">{{ $giftOrder->sender->name }}</span></p>
                    <p><span class="text-gray-600">Email:</span> <span class="font-semibold">{{ $giftOrder->sender->email }}</span></p>
                    <p><span class="text-gray-600">Phone:</span> <span class="font-semibold">{{ $giftOrder->sender->phone ?? 'N/A' }}</span></p>
                </div>
            </div>

            <!-- Recipient Information -->
            <div class="admin-card p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Recipient</h2>
                <div class="space-y-2 text-sm">
                    <p><span class="text-gray-600">Name:</span> <span class="font-semibold">{{ $giftOrder->recipient_name }}</span></p>
                    <p><span class="text-gray-600">Email:</span> <span class="font-semibold">{{ $giftOrder->recipient_email }}</span></p>
                    <p><span class="text-gray-600">Phone:</span> <span class="font-semibold">{{ $giftOrder->recipient_phone }}</span></p>
                    <div class="mt-4">
                        <p class="text-gray-600 mb-1">Shipping Address:</p>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-gray-900">{{ $giftOrder->recipient_address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="admin-card p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Timeline</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex items-start">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mt-1.5 mr-3"></div>
                        <div>
                            <p class="font-semibold">Order Created</p>
                            <p class="text-gray-600">{{ $giftOrder->created_at->format('M d, Y H:i A') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-2 h-2 bg-gray-300 rounded-full mt-1.5 mr-3"></div>
                        <div>
                            <p class="font-semibold">Last Updated</p>
                            <p class="text-gray-600">{{ $giftOrder->updated_at->format('M d, Y H:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @if($giftOrder->status !== 'cancelled' && $giftOrder->status !== 'delivered')
            <div class="admin-card p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Actions</h2>
                <form action="{{ route('admin.gifts.destroy', $giftOrder->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this gift order?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                        Cancel Order
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
