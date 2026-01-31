<!-- Admin Side Loading Component -->
<div id="admin-loading-screen" class="fixed inset-0 z-50 flex items-center justify-center admin-loading-gradient">
    <div class="text-center">
        <!-- Animated Admin Icon Container -->
        <div class="relative mb-8">
            <!-- Outer Rotating Ring -->
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-40 h-40 border-8 border-slate-700 border-t-blue-500 border-r-blue-400 rounded-full animate-spin" style="animation-duration: 1.5s;"></div>
            </div>
            
            <!-- Inner Rotating Ring (Counter) -->
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-28 h-28 border-6 border-slate-600 border-b-cyan-400 rounded-full animate-spin-reverse" style="animation-duration: 2s;"></div>
            </div>
            
            <!-- Admin Shield Icon -->
            <div class="relative flex items-center justify-center w-40 h-40">
                <svg class="w-20 h-20 text-blue-400 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                </svg>
            </div>
        </div>
        
        <!-- Loading Text -->
        <h2 class="text-4xl font-bold text-white mb-3">
            {{ $title ?? 'Admin Panel' }}
        </h2>
        <p class="text-blue-200 text-lg mb-6 tracking-wide">
            {{ $message ?? 'Loading Dashboard...' }}
        </p>
        
        <!-- Modern Progress Bar -->
        <div class="relative w-80 h-3 bg-slate-800 rounded-full overflow-hidden mx-auto shadow-inner">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-cyan-500 to-blue-600 rounded-full animate-progress-bar"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-30 animate-shimmer"></div>
        </div>
        
        <!-- Status Text -->
        <div class="mt-4">
            <p class="text-slate-300 text-sm animate-pulse" id="loading-status">
                Initializing...
            </p>
        </div>
        
        <!-- Loading Indicators -->
        <div class="flex justify-center mt-6 space-x-3">
            <div class="w-4 h-4 bg-blue-500 rounded-full animate-bounce shadow-lg shadow-blue-500/50" style="animation-delay: 0s;"></div>
            <div class="w-4 h-4 bg-cyan-500 rounded-full animate-bounce shadow-lg shadow-cyan-500/50" style="animation-delay: 0.15s;"></div>
            <div class="w-4 h-4 bg-blue-400 rounded-full animate-bounce shadow-lg shadow-blue-400/50" style="animation-delay: 0.3s;"></div>
            <div class="w-4 h-4 bg-cyan-400 rounded-full animate-bounce shadow-lg shadow-cyan-400/50" style="animation-delay: 0.45s;"></div>
        </div>
    </div>
</div>

<style>
    .admin-loading-gradient {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #334155 50%, #1e293b 75%, #0f172a 100%);
        background-size: 400% 400%;
        animation: gradient-shift 8s ease infinite;
    }
    
    @keyframes gradient-shift {
        0%, 100% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
    }
    
    @keyframes progress-bar {
        0% {
            transform: translateX(-100%);
        }
        100% {
            transform: translateX(100%);
        }
    }
    
    .animate-progress-bar {
        animation: progress-bar 1.5s ease-in-out infinite;
    }
    
    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }
        100% {
            transform: translateX(100%);
        }
    }
    
    .animate-shimmer {
        animation: shimmer 2s ease-in-out infinite;
    }
    
    @keyframes spin-reverse {
        from {
            transform: rotate(360deg);
        }
        to {
            transform: rotate(0deg);
        }
    }
    
    .animate-spin-reverse {
        animation: spin-reverse 2s linear infinite;
    }
    
    /* Fade out animation */
    .admin-loading-fade-out {
        animation: adminFadeOut 0.6s ease-out forwards;
    }
    
    @keyframes adminFadeOut {
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
    // Loading status messages for admin panel
    const statusMessages = [
        'Initializing...',
        'Loading modules...',
        'Connecting to database...',
        'Preparing dashboard...',
        'Almost ready...'
    ];
    
    let currentStatus = 0;
    const statusElement = document.getElementById('loading-status');
    
    // Update status messages
    const statusInterval = setInterval(function() {
        if (statusElement && currentStatus < statusMessages.length - 1) {
            currentStatus++;
            statusElement.textContent = statusMessages[currentStatus];
        }
    }, 400);
    
    // Auto-hide loading screen when page is fully loaded
    window.addEventListener('load', function() {
        const loadingScreen = document.getElementById('admin-loading-screen');
        if (loadingScreen) {
            clearInterval(statusInterval);
            if (statusElement) {
                statusElement.textContent = 'Ready!';
            }
            
            setTimeout(function() {
                loadingScreen.classList.add('admin-loading-fade-out');
                setTimeout(function() {
                    loadingScreen.remove();
                }, 600);
            }, 300);
        }
    });
    
    // Hide immediately if user prefers reduced motion
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        window.addEventListener('load', function() {
            const loadingScreen = document.getElementById('admin-loading-screen');
            if (loadingScreen) {
                clearInterval(statusInterval);
                loadingScreen.remove();
            }
        });
    }
</script>
