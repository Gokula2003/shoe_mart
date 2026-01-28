@extends('admin.layout')

@section('title', 'Orders')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center mb-8">
        <div class="sm:flex-auto">
            <h1 class="text-3xl font-bold text-gray-900">Orders Management</h1>
            <p class="mt-2 text-gray-600">View and manage customer orders</p>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="mb-8 bg-white rounded-2xl shadow-lg p-2 inline-flex space-x-2">
        <a href="{{ route('admin.orders.index') }}?status=all" 
           class="px-6 py-3 rounded-xl font-semibold text-sm transition-all {{ request('status', 'all') == 'all' ? 'bg-gradient-to-r from-purple-600 to-blue-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
            All Orders
        </a>
        <a href="{{ route('admin.orders.index') }}?status=pending" 
           class="px-6 py-3 rounded-xl font-semibold text-sm transition-all flex items-center {{ request('status') == 'pending' ? 'bg-gradient-to-r from-yellow-500 to-orange-500 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
            <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2 {{ request('status') == 'pending' ? 'bg-white' : '' }}"></span>
            Pending
        </a>
        <a href="{{ route('admin.orders.index') }}?status=accepted" 
           class="px-6 py-3 rounded-xl font-semibold text-sm transition-all flex items-center {{ request('status') == 'accepted' ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 {{ request('status') == 'accepted' ? 'bg-white' : '' }}"></span>
            Accepted
        </a>
        <a href="{{ route('admin.orders.index') }}?status=declined" 
           class="px-6 py-3 rounded-xl font-semibold text-sm transition-all flex items-center {{ request('status') == 'declined' ? 'bg-gradient-to-r from-red-500 to-rose-500 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
            <span class="w-2 h-2 bg-red-500 rounded-full mr-2 {{ request('status') == 'declined' ? 'bg-white' : '' }}"></span>
            Declined
        </a>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th scope="col" class="py-4 pl-6 pr-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Order #</th>
                        <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                        <th scope="col" class="relative py-4 pl-3 pr-6">
                            <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gradient-to-r hover:from-purple-50 hover:to-transparent transition-all duration-200">
                        <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-bold">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-purple-600 hover:text-purple-800 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                {{ $order->order_number }}
                            </a>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-blue-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-3">
                                    {{ strtoupper(substr($order->customer_name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $order->customer_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->customer_email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4">
                            <div class="font-medium text-gray-900">{{ $order->created_at->format('M d, Y') }}</div>
                            <div class="text-sm text-gray-500">{{ $order->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4">
                            <span class="text-lg font-bold text-green-600">${{ number_format($order->total, 2) }}</span>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                            @if($order->status == 'pending')
                                <span class="inline-flex items-center rounded-full bg-gradient-to-r from-yellow-100 to-yellow-50 px-3 py-1.5 text-xs font-bold text-yellow-700 border border-yellow-200">
                                    <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse"></span>
                                    Pending
                                </span>
                            @elseif($order->status == 'accepted')
                                <span class="inline-flex items-center rounded-full bg-gradient-to-r from-green-100 to-green-50 px-3 py-1.5 text-xs font-bold text-green-700 border border-green-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Accepted
                                </span>
                            @elseif($order->status == 'declined')
                                <span class="inline-flex items-center rounded-full bg-gradient-to-r from-red-100 to-red-50 px-3 py-1.5 text-xs font-bold text-red-700 border border-red-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Declined
                                </span>
                            @elseif($order->status == 'processing')
                                <span class="inline-flex items-center rounded-full bg-gradient-to-r from-blue-100 to-blue-50 px-3 py-1.5 text-xs font-bold text-blue-700 border border-blue-200">
                                    <svg class="w-3 h-3 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    Processing
                                </span>
                            @elseif($order->status == 'shipped')
                                <span class="inline-flex items-center rounded-full bg-gradient-to-r from-purple-100 to-purple-50 px-3 py-1.5 text-xs font-bold text-purple-700 border border-purple-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                    Shipped
                                </span>
                            @elseif($order->status == 'delivered')
                                <span class="inline-flex items-center rounded-full bg-gradient-to-r from-green-100 to-green-50 px-3 py-1.5 text-xs font-bold text-green-700 border border-green-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Delivered
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-gray-100 px-3 py-1.5 text-xs font-bold text-gray-700">{{ ucfirst($order->status) }}</span>
                            @endif
                        </td>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                   class="inline-flex items-center px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition font-semibold">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View
                                </a>
                                @if($order->status == 'pending')
                                    <form action="{{ route('admin.orders.accept', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition font-semibold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Accept
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-3 py-12 text-center">
                            <div class="text-6xl mb-4">📋</div>
                            <p class="text-gray-500 text-lg">No orders found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection
