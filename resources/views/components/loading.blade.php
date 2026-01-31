<!-- Customer Side Loading Component -->
<div id="loading-screen" class="fixed inset-0 z-50 flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-purple-50">
    <div class="text-center">
        <!-- Animated Logo Container -->
        <div class="relative mb-8">
            <!-- Spinning Ring -->
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-32 h-32 border-8 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
            </div>
            
            <!-- Logo/Icon -->
            <div class="relative flex items-center justify-center w-32 h-32">
                <svg class="w-16 h-16 text-blue-600 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/>
                </svg>
            </div>
        </div>
        
        <!-- Loading Text -->
        <h2 class="text-3xl font-bold text-gray-800 mb-2 animate-pulse">
            {{ $title ?? 'ShoeMart' }}
        </h2>
        <p class="text-gray-600 mb-6 animate-pulse">
            {{ $message ?? 'Loading your experience...' }}
        </p>
        
        <!-- Progress Bar -->
        <div class="w-64 h-2 bg-gray-200 rounded-full overflow-hidden mx-auto">
            <div class="h-full bg-gradient-to-r from-blue-600 to-purple-600 rounded-full animate-loading-bar"></div>
        </div>
        
        <!-- Loading Dots -->
        <div class="flex justify-center mt-4 space-x-2">
            <div class="w-3 h-3 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0s;"></div>
            <div class="w-3 h-3 bg-purple-600 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
            <div class="w-3 h-3 bg-pink-600 rounded-full animate-bounce" style="animation-delay: 0.4s;"></div>
        </div>
    </div>
</div>

<style>
    @keyframes loading-bar {
        0% {
            width: 0%;
        }
        50% {
            width: 70%;
        }
        100% {
            width: 100%;
        }
    }
    
    .animate-loading-bar {
        animation: loading-bar 2s ease-in-out infinite;
    }
    
    /* Fade out animation */
    .loading-fade-out {
        animation: fadeOut 0.5s ease-out forwards;
    }
    
    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
            visibility: hidden;
        }
    }
</style>

<script>
    // Auto-hide loading screen when page is fully loaded
    window.addEventListener('load', function() {
        const loadingScreen = document.getElementById('loading-screen');
        if (loadingScreen) {
            setTimeout(function() {
                loadingScreen.classList.add('loading-fade-out');
                setTimeout(function() {
                    loadingScreen.remove();
                }, 500);
            }, 500); // Small delay for smooth transition
        }
    });
    
    // Alternative: Hide immediately if user prefers reduced motion
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        window.addEventListener('load', function() {
            const loadingScreen = document.getElementById('loading-screen');
            if (loadingScreen) {
                loadingScreen.remove();
            }
        });
    }
</script>
