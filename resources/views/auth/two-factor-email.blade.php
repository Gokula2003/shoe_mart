<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Two-Factor Authentication - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-2xl p-8 relative">
            <!-- Close Button -->
            <button onclick="window.location.href='{{ route('logout') }}'" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Icon Section -->
            <div class="text-center mb-6">
                <div class="relative inline-block">
                    <!-- Envelope Icon -->
                    <div class="w-28 h-20 bg-gradient-to-br from-orange-400 to-amber-500 rounded-2xl flex items-center justify-center shadow-lg transform rotate-3">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <!-- Key/Lock Icon -->
                    <div class="absolute -bottom-2 -left-2 w-12 h-12 bg-red-500 rounded-full flex items-center justify-center shadow-lg border-4 border-white">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-900 text-center mb-2">Verify Your Email Address</h1>
            <p class="text-sm text-gray-500 text-center mb-8 px-4">
                Lorem ipsum dolor sit amet consectetur. Cursus diam aliquam nunc fermentum facilisis.
            </p>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-3 animate-fadeIn">
                    <p class="text-green-800 text-sm text-center font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-3 animate-fadeIn">
                    <p class="text-red-700 text-sm text-center font-medium">
                        @foreach($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </p>
                </div>
            @endif

                <!-- Verification Form -->
                <form method="POST" action="{{ route('two-factor.verify') }}" id="verifyForm">
                    @csrf
                    
                    <div class="mb-8">
                        <label for="code" class="block text-sm font-semibold text-gray-700 mb-3">Enter 6-Digit Verification Code</label>
                        <input 
                            type="text" 
                            id="code" 
                            name="code" 
            <!-- Verification Form -->
            <form method="POST" action="{{ route('two-factor.verify') }}" id="verifyForm">
                @csrf
                
                <div class="mb-6">
                    <div class="flex justify-center gap-3" id="codeInputs">
                        <input type="text" class="code-input w-14 h-16 text-center text-2xl font-bold border-2 border-gray-200 rounded-xl focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition-all duration-200 bg-gray-50" maxlength="1" pattern="[0-9]" inputmode="numeric" required autofocus>
                        <input type="text" class="code-input w-14 h-16 text-center text-2xl font-bold border-2 border-gray-200 rounded-xl focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition-all duration-200 bg-gray-50" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="code-input w-14 h-16 text-center text-2xl font-bold border-2 border-gray-200 rounded-xl focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition-all duration-200 bg-gray-50" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="code-input w-14 h-16 text-center text-2xl font-bold border-2 border-gray-200 rounded-xl focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition-all duration-200 bg-gray-50" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="code-input w-14 h-16 text-center text-2xl font-bold border-2 border-gray-200 rounded-xl focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition-all duration-200 bg-gray-50" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="code-input w-14 h-16 text-center text-2xl font-bold border-2 border-gray-200 rounded-xl focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition-all duration-200 bg-gray-50" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                    </div>
                    <input type="hidden" id="code" name="code">
                </div>

                <!-- Change Email Link -->
                <p class="text-center text-sm text-gray-600 mb-6">
                    Want to Change Your Email Address? 
                    <a href="{{ route('profile.show') }}" class="text-orange-500 font-semibold hover:text-orange-600 transition">Change Here</a>
                </p>

                <button type="submit" class="w-full bg-gradient-to-r from-orange-400 to-orange-500 hover:from-orange-500 hover:to-orange-600 text-white py-4 px-6 rounded-full font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
                    Verify Email
                </button>
            </form>

            <!-- Resend Code -->
            <div class="text-center mt-6">
                <form method="POST" action="{{ route('two-factor.resend') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 hover:text-orange-500 font-semibold transition">
                        Resend Code
                    </button>
                </form
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }
    </style>

    <script>
        // Handle OTP input
        const codeInput = document.getElementById('code');
        const form = document.getElementById('verifyForm');

        // Only allow numbers
        codeInput.addEventListener('input', function(e) {
            // Remove non-numeric characters
            this.value = this.value.replace(/\D/g, '');
            
            // Limit to 6 digits
            if (this.value.length > 6) {
                this.value = this.value.substring(0, 6);
            }
            
            // Auto-submit when 6 digits are entered
            if (this.value.length === 6 && /^\d{6}$/.test(this.value)) {
                setTimeout(() => {
                    form.submit();
                }, 300);
            }
        });

        // Only allow numeric keys
        codeInput.addEventListener('keypress', function(e) {
            if (!/^\d$/.test(e.key) && e.key !== 'Enter') {
                e.preventDefault();
            }
        });

        // Prevent form submission if code is incomplete
        form.addEventListener('submit', function(e) {
            const code = codeInput.value;
            if (code.length !== 6 || !/^\d{6}$/.test(code)) {
                e.6 separate input boxes
        const inputs = document.querySelectorAll('.code-input');
        const hiddenInput = document.getElementById('code');
        const form = document.getElementById('verifyForm');

        inputs.forEach((input, index) => {
            // Auto-focus next input on digit entry
            input.addEventListener('input', function(e) {
                if (this.value.length === 1) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                    updateHiddenInput();
                    
                    // Auto-submit when all 6 digits are entered
                    if (index === inputs.length - 1) {
                        const code = Array.from(inputs).map(i => i.value).join('');
                        if (code.length === 6 && /^\d{6}$/.test(code)) {
                            setTimeout(() => {
                                form.submit();
                            }, 300);
                        }
                    }
                } else if (this.value.length > 1) {
                    this.value = this.value.charAt(0);
                }
            });

            // Handle backspace
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value === '' && index > 0) {
                    inputs[index - 1].focus();
                    inputs[index - 1].value = '';
                }
            });

            // Handle paste
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').replace(/\D/g, '').substring(0, 6);
                pastedData.split('').forEach((char, i) => {
                    if (inputs[i]) {
                        inputs[i].value = char;
                    }
                });
                if (pastedData.length > 0) {
                    const lastIndex = Math.min(pastedData.length - 1, inputs.length - 1);
                    inputs[lastIndex].focus();
                    updateHiddenInput();
                    
                    if (pastedData.length === 6) {
                        setTimeout(() => {
                            form.submit();
                        }, 300);
                    }
                }
            });

            // Only allow numbers
            input.addEventListener('keypress', function(e) {
                if (!/^\d$/.test(e.key)) {
                    e.preventDefault();
                }
            });
        });

        function updateHiddenInput() {
            hiddenInput.value = Array.from(inputs).map(i => i.value).join('');
        }

        // Prevent form submission if code is incomplete
        form.addEventListener('submit', function(e) {
            const code = Array.from(inputs).map(i => i.value).join('');
            if (code.length !== 6 || !/^\d{6}$/.test(code)) {
                e.preventDefault();
                inputs[0]