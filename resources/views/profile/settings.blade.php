<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Settings - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-navigation />

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Account Settings</h1>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Change Password -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Change Password</h2>
                
                @if ($errors->any() && $errors->has('current_password'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.updatePassword') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                        <input id="current_password" type="password" name="current_password" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                        <input id="password" type="password" name="password" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <button type="submit" class="btn-primary" style="background-color: #16a34a !important; color: white !important; width: 100%; padding: 12px; font-size: 16px; font-weight: 600; border: none; border-radius: 6px; cursor: pointer;">
                        Update Password
                    </button>
                </form>
            </div>

            <!-- Change Address -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Change Address</h2>
                
                @if ($errors->any() && $errors->has('address'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.updateAddress') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <textarea id="address" name="address" rows="6" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">{{ old('address', $user->address) }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Enter your complete shipping address</p>
                    </div>

                    <button type="submit" class="btn-primary" style="background-color: #16a34a !important; color: white !important; width: 100%; padding: 12px; font-size: 16px; font-weight: 600; border: none; border-radius: 6px; cursor: pointer;">
                        Update Address
                    </button>
                </form>
            </div>
        </div>

        <!-- User Information -->
        <div class="mt-6 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Account Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Name</p>
                    <p class="mt-1 text-gray-900">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Email</p>
                    <p class="mt-1 text-gray-900">{{ $user->email }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm font-medium text-gray-500">Current Address</p>
                    <p class="mt-1 text-gray-900">{{ $user->address ?? 'No address set' }}</p>
                </div>
            </div>
        </div>
    </main>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
