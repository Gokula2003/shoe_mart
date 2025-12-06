<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="/" class="text-2xl font-bold text-blue-600">ShoeMart</a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="/" class="text-gray-700 hover:text-blue-600 px-3 py-2 {{ request()->is('/') ? 'text-blue-600 font-semibold' : '' }}">Home</a>
                <a href="/about" class="text-gray-700 hover:text-blue-600 px-3 py-2 {{ request()->is('about') ? 'text-blue-600 font-semibold' : '' }}">About</a>
                <a href="/order" class="text-gray-700 hover:text-blue-600 px-3 py-2 {{ request()->is('order') ? 'text-blue-600 font-semibold' : '' }}">Order</a>
                <a href="/contact" class="text-gray-700 hover:text-blue-600 px-3 py-2 {{ request()->is('contact') ? 'text-blue-600 font-semibold' : '' }}">Contact</a>
                <a href="/aftercare" class="text-gray-700 hover:text-blue-600 px-3 py-2 {{ request()->is('aftercare') ? 'text-blue-600 font-semibold' : '' }}">After Care</a>
                <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 {{ request()->is('cart*') ? 'text-blue-600 font-semibold' : '' }}">
                    🛒 Cart
                </a>
                
                @auth
                    <!-- User Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md focus:outline-none">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10"
                             style="display: none;">
                            <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Dashboard
                            </a>
                            <a href="{{ route('profile.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Settings
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Create Account</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>
