<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-navigation />

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="text-gray-600 mt-2">Here's your ShoeMart dashboard overview</p>
        </div>

        @php
            $userOrders = \App\Models\Order::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
            $totalOrders = $userOrders->count();
            $completedOrders = $userOrders->where('status', 'delivered')->count();
            $totalSpent = $userOrders->sum('total');
        @endphp

        <!-- Dashboard Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Orders</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Completed Orders</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $completedOrders }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Spent</p>
                        <p class="text-2xl font-semibold text-gray-900">${{ number_format($totalSpent, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order History Section -->
        @if($userOrders->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Order History</h2>
            
            <div class="space-y-4">
                @foreach($userOrders as $order)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-semibold text-lg text-gray-900">Order #{{ $order->order_number }}</h3>
                                <p class="text-sm text-gray-600">
                                    Placed on {{ $order->created_at->format('M d, Y') }} at {{ $order->created_at->format('g:i A') }}
                                </p>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $order->status == 'accepted' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $order->status == 'declined' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $order->status == 'processing' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                {{ $order->status == 'shipped' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->status == 'cancelled' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        <!-- Order Items -->
                        <div class="mb-3">
                            <p class="text-sm font-medium text-gray-700 mb-2">Items:</p>
                            <div class="space-y-2">
                                @foreach($order->items as $item)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">{{ $item->product_name }} (x{{ $item->quantity }})</span>
                                        <span class="text-gray-900 font-medium">${{ number_format($item->subtotal, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="pt-3 border-t border-gray-200 flex justify-between items-center">
                            <span class="text-sm font-semibold text-gray-700">Total Amount:</span>
                            <span class="text-lg font-bold text-gray-900">${{ number_format($order->total, 2) }}</span>
                        </div>

                        <!-- Payment Method -->
                        <div class="mt-2 text-sm text-gray-600">
                            <span class="font-medium">Payment:</span> {{ strtoupper($order->payment_method) }}
                        </div>

                        <!-- Admin Notes (for declined orders) -->
                        @if($order->status == 'declined' && $order->admin_notes)
                            <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded">
                                <p class="text-sm text-red-800"><span class="font-semibold">Decline Reason:</span> {{ $order->admin_notes }}</p>
                            </div>
                        @endif

                        <!-- Order Status Progress -->
                        <div class="mt-4">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>Pending</span>
                                <span>Accepted</span>
                                <span>Processing</span>
                                <span>Shipped</span>
                                <span>Delivered</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                @php
                                    $progressWidth = 0;
                                    $progressColor = 'bg-gray-500';
                                    
                                    if ($order->status == 'pending') {
                                        $progressWidth = 20;
                                        $progressColor = 'bg-yellow-500';
                                    } elseif ($order->status == 'accepted') {
                                        $progressWidth = 40;
                                        $progressColor = 'bg-blue-500';
                                    } elseif ($order->status == 'processing') {
                                        $progressWidth = 60;
                                        $progressColor = 'bg-indigo-500';
                                    } elseif ($order->status == 'shipped') {
                                        $progressWidth = 80;
                                        $progressColor = 'bg-purple-500';
                                    } elseif ($order->status == 'delivered') {
                                        $progressWidth = 100;
                                        $progressColor = 'bg-green-500';
                                    } elseif ($order->status == 'declined' || $order->status == 'cancelled') {
                                        $progressWidth = 20;
                                        $progressColor = 'bg-red-500';
                                    }
                                @endphp
                                <div class="h-2 rounded-full transition-all duration-300 {{ $progressColor }}" style="width: {{ $progressWidth }}%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <a href="/order" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    <svg class="h-8 w-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="font-medium text-gray-900">Place Order</span>
                </a>

                <a href="/about" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                    <svg class="h-8 w-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium text-gray-900">About Us</span>
                </a>

                <a href="/contact" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                    <svg class="h-8 w-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-medium text-gray-900">Contact Us</span>
                </a>

                <a href="{{ route('profile.settings') }}" class="flex flex-col items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition">
                    <svg class="h-8 w-8 text-orange-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-medium text-gray-900">Settings</span>
                </a>
            </div>
        </div>

        <!-- After Care Reservations Progress -->
        @php
            $reservations = DB::table('aftercare_reservations')
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        @endphp

        @if($reservations->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">After Care Reservations</h2>
            
            <div class="space-y-4">
                @foreach($reservations as $reservation)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-semibold text-lg text-gray-900">{{ $reservation->service_type }}</h3>
                                <p class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('M d, Y') }} at 
                                    {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('g:i A') }}
                                </p>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                {{ $reservation->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $reservation->status == 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $reservation->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $reservation->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mb-2">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>Pending</span>
                                <span>Confirmed</span>
                                <span>Completed</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="h-2.5 rounded-full transition-all duration-300
                                    {{ $reservation->status == 'pending' ? 'bg-yellow-500 w-1/3' : '' }}
                                    {{ $reservation->status == 'confirmed' ? 'bg-blue-500 w-2/3' : '' }}
                                    {{ $reservation->status == 'completed' ? 'bg-green-500 w-full' : '' }}
                                    {{ $reservation->status == 'cancelled' ? 'bg-red-500 w-1/3' : '' }}">
                                </div>
                            </div>
                        </div>

                        <!-- Progress Steps -->
                        <div class="flex items-center justify-between mt-3">
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full 
                                    {{ in_array($reservation->status, ['pending', 'confirmed', 'completed']) ? 'bg-yellow-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                                    @if(in_array($reservation->status, ['confirmed', 'completed']))
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <span class="text-xs">1</span>
                                    @endif
                                </div>
                                <span class="ml-2 text-xs text-gray-600">Requested</span>
                            </div>

                            <div class="flex-1 h-0.5 mx-2 {{ in_array($reservation->status, ['confirmed', 'completed']) ? 'bg-blue-500' : 'bg-gray-300' }}"></div>

                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full 
                                    {{ in_array($reservation->status, ['confirmed', 'completed']) ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                                    @if($reservation->status == 'completed')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <span class="text-xs">2</span>
                                    @endif
                                </div>
                                <span class="ml-2 text-xs text-gray-600">Confirmed</span>
                            </div>

                            <div class="flex-1 h-0.5 mx-2 {{ $reservation->status == 'completed' ? 'bg-green-500' : 'bg-gray-300' }}"></div>

                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full 
                                    {{ $reservation->status == 'completed' ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                                    @if($reservation->status == 'completed')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <span class="text-xs">3</span>
                                    @endif
                                </div>
                                <span class="ml-2 text-xs text-gray-600">Completed</span>
                            </div>
                        </div>

                        @if($reservation->notes)
                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <p class="text-sm text-gray-600"><span class="font-medium">Notes:</span> {{ $reservation->notes }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Account Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Account Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-medium text-gray-500">Full Name</p>
                    <p class="mt-1 text-lg text-gray-900">{{ Auth::user()->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Email Address</p>
                    <p class="mt-1 text-lg text-gray-900">{{ Auth::user()->email }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm font-medium text-gray-500">Shipping Address</p>
                    <p class="mt-1 text-lg text-gray-900">{{ Auth::user()->address ?? 'No address set - Update in settings' }}</p>
                </div>
            </div>
        </div>
    </main>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
