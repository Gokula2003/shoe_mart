<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Two-Factor Authentication - {{ config('app.name', 'ShoeMart') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-purple-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-2xl p-8">
            <!-- Icon -->
            <div class="text-center mb-6">
                <div class="w-20 h-20 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Two-Factor Authentication</h1>
                <p class="text-gray-600 mt-2">Enter the 6-digit code sent to your email</p>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <ul class="list-disc list-inside text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Verification Form -->
            <form method="POST" action="{{ route('two-factor.verify') }}" id="verifyForm">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-4 text-center">Verification Code</label>
                    <div class="flex justify-center gap-3" id="codeInputs">
                        <input type="text" class="code-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-600/20 transition" maxlength="1" pattern="[0-9]" inputmode="numeric" required autofocus>
                        <input type="text" class="code-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-600/20 transition" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="code-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-600/20 transition" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="code-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-600/20 transition" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="code-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-600/20 transition" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="code-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:border-purple-600 focus:ring-4 focus:ring-purple-600/20 transition" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                    </div>
                    <input type="hidden" id="code" name="code">
                </div>

                <button type="submit" style="display: inline-flex !important; visibility: visible !important; opacity: 1 !important; align-items: center; justify-content: center;" class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-3 px-6 rounded-xl font-bold text-lg hover:from-purple-700 hover:to-blue-700 transition shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
                    Verify Code
                </button>
            </form>

            <!-- Resend Code -->
            <form method="POST" action="{{ route('two-factor.resend') }}" class="mt-4">
                @csrf
                <button type="submit" style="display: inline-flex !important; visibility: visible !important; opacity: 1 !important; align-items: center; justify-content: center;" class="w-full text-purple-600 hover:text-purple-800 py-2 font-semibold transition">
                    Didn't receive the code? Resend
                </button>
            </form>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf
                <button type="submit" style="display: inline-flex !important; visibility: visible !important; opacity: 1 !important; align-items: center; justify-content: center;" class="w-full text-gray-500 hover:text-gray-700 py-2 text-sm transition">
                    Cancel & Logout
                </button>
            </form>
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-2xl p-4 text-sm text-blue-800">
            <div class="flex items-start">
                <svg class="w-5 h-5 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="font-semibold mb-1">Security Notice</p>
                    <p>The verification code expires in 10 minutes. If you have any issues, please contact support.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle 6 separate input boxes
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
                            form.submit();
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
                        form.submit();
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
                inputs[0].focus();
            }
        });
    </script>
</body>
</html>
