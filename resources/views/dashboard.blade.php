<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-gray-600">Here's what's happening with your account today.</p>
            </div>

            <!-- Stats Cards -->
            @php
                $totalOrders = Auth::user()->orders()->count();
                $cartItems = Auth::user()->cartItems()->count();
                $giftsSent = Auth::user()->sentGifts()->count();
                $totalSpent = Auth::user()->orders()->sum('total');
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Orders -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mb-1">Total Orders</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalOrders }}</p>
                </div>

                <!-- Cart Items -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mb-1">Cart Items</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $cartItems }}</p>
                </div>

                <!-- Gifts Sent -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mb-1">Gifts Sent</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $giftsSent }}</p>
                </div>

                <!-- Total Spent -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mb-1">Total Spent</p>
                    <p class="text-3xl font-bold text-gray-900">${{ number_format($totalSpent, 0) }}</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('products.index') }}" class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition-all text-center group">
                        <div class="w-16 h-16 bg-blue-500 rounded-2xl mx-auto mb-3 flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-900 text-sm">Shop Now</p>
                    </a>

                    <a href="{{ route('cart.index') }}" class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition-all text-center group">
                        <div class="w-16 h-16 bg-green-500 rounded-2xl mx-auto mb-3 flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-900 text-sm">View Cart</p>
                    </a>

                    <a href="{{ route('orders.history') }}" class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition-all text-center group">
                        <div class="w-16 h-16 bg-purple-500 rounded-2xl mx-auto mb-3 flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-900 text-sm">My Orders</p>
                    </a>

                    <a href="{{ route('gift.send') }}" class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition-all text-center group">
                        <div class="w-16 h-16 bg-pink-500 rounded-2xl mx-auto mb-3 flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-900 text-sm">Send Gift</p>
                    </a>
                </div>
            </div>

            <!-- Bottom Section: Recent Orders & Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Orders (2/3 width) -->
                @php
                    $recentOrders = Auth::user()->orders()->with('items.product')->latest()->take(3)->get();
                @endphp
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Recent Orders</h2>
                        <a href="{{ route('orders.history') }}" class="text-sm text-blue-600 hover:text-blue-700 font-semibold">View all</a>
                    </div>
                    
                    @if($recentOrders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                                @php
                                    $firstItem = $order->items->first();
                                @endphp
                                <div class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-50 transition-colors">
                                    <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        @if($firstItem && $firstItem->product && $firstItem->product->image)
                                            <img src="{{ Storage::url($firstItem->product->image) }}" alt="{{ $firstItem->product->name }}" class="w-full h-full object-cover rounded-xl">
                                        @else
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-gray-900 truncate">
                                            {{ $firstItem ? $firstItem->product->name : 'Order #'.$order->id }}
                                        </p>
                                        <p class="text-sm text-gray-500">#ORD-{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }} • {{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        <p class="font-bold text-gray-900">${{ number_format($order->total, 2) }}</p>
                                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-lg
                                            {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' : 
                                               ($order->status === 'processing' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No orders yet</h3>
                            <p class="text-gray-500 mb-4">Start shopping to see your orders here!</p>
                            <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                                Browse Products
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Recent Activity (1/3 width) -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Recent Activity</h2>
                    
                    <div class="space-y-6">
                        @if($recentOrders->count() > 0)
                            @foreach($recentOrders->take(3) as $order)
                                <div class="flex items-start space-x-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        @if($order->status === 'delivered')
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900">
                                            @if($order->status === 'delivered')
                                                Order #ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }} shipped
                                            @else
                                                Order #ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }} {{ $order->status }}
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        @if($cartItems > 0)
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Added items to cart</p>
                                    <p class="text-xs text-gray-500 mt-1">Recently</p>
                                </div>
                            </div>
                        @endif

                        @if($giftsSent > 0)
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Gift sent successfully</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $giftsSent }} day{{ $giftsSent > 1 ? 's' : '' }} ago</p>
                                </div>
                            </div>
                        @endif

                        @if($recentOrders->count() === 0 && $cartItems === 0 && $giftsSent === 0)
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm text-gray-500">No recent activity</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
