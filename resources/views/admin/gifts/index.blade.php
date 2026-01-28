@extends('admin.layout')

@section('title', 'Gift Orders')

@section('content')
<div class="px-4 py-6">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Gift Orders</h1>
            <p class="text-gray-600">Manage all gift orders in your store</p>
        </div>
        <a href="{{ route('admin.gifts.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-3 px-6 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl">
            + Create Gift Order
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Filter Tabs -->
    <div class="mb-6 flex space-x-4">
        <a href="{{ route('admin.gifts.index') }}" class="px-4 py-2 rounded-lg {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
            All Orders
        </a>
        <a href="{{ route('admin.gifts.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg {{ request('status') === 'pending' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
            Pending
        </a>
        <a href="{{ route('admin.gifts.index', ['status' => 'processing']) }}" class="px-4 py-2 rounded-lg {{ request('status') === 'processing' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
            Processing
        </a>
        <a href="{{ route('admin.gifts.index', ['status' => 'shipped']) }}" class="px-4 py-2 rounded-lg {{ request('status') === 'shipped' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
            Shipped
        </a>
        <a href="{{ route('admin.gifts.index', ['status' => 'delivered']) }}" class="px-4 py-2 rounded-lg {{ request('status') === 'delivered' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
            Delivered
        </a>
    </div>

    <div class="admin-card p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sender</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recipient</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($gifts as $gift)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-mono text-sm">#{{ $gift->id }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $gift->sender->name }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <p class="font-medium">{{ $gift->recipient_name }}</p>
                                <p class="text-gray-500">{{ $gift->recipient_email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <p class="font-medium">{{ $gift->product->name }}</p>
                                <p class="text-gray-500">Qty: {{ $gift->quantity }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-semibold">${{ number_format($gift->total_amount, 2) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'processing' => 'bg-blue-100 text-blue-800',
                                    'shipped' => 'bg-purple-100 text-purple-800',
                                    'delivered' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$gift->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($gift->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $gift->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.gifts.show', $gift->id) }}" class="text-blue-600 hover:text-blue-900">
                                    View
                                </a>
                                @if($gift->status !== 'cancelled' && $gift->status !== 'delivered')
                                <form action="{{ route('admin.gifts.destroy', $gift->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Cancel this gift order?')">
                                        Cancel
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                </svg>
                                <p class="text-lg font-medium">No gift orders found</p>
                                <p class="text-sm mt-1">Gift orders will appear here</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($gifts->hasPages())
        <div class="mt-6">
            {{ $gifts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
