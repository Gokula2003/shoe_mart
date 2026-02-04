<!-- Loading Screen Component -->
<div id="loading-screen" class="fixed inset-0 z-[9999] flex items-center justify-center overflow-hidden bg-blue-900" style="display: flex;">
    <div class="text-center">
        <!-- Shoe Icon made with Tailwind CSS -->
        <div class="relative mx-auto mb-8 w-40 h-32 animate-bounce">
            <!-- Shoe sole -->
            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-36 h-8 bg-white rounded-full"></div>
            <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 w-32 h-6 bg-white rounded-full opacity-80"></div>
            
            <!-- Shoe body -->
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 w-28 h-16 bg-white rounded-t-3xl rounded-bl-3xl"></div>
            
            <!-- Shoe toe cap -->
            <div class="absolute bottom-8 left-2 w-16 h-12 bg-white rounded-full"></div>
            
            <!-- Shoe collar -->
            <div class="absolute top-8 right-6 w-20 h-16 bg-white rounded-t-full rounded-br-3xl"></div>
            
            <!-- Shoe laces area -->
            <div class="absolute top-12 right-10 w-12 h-8 bg-blue-900 rounded-lg opacity-20"></div>
            
            <!-- Shadow -->
            <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-40 h-4 bg-blue-950 rounded-full opacity-30 blur-sm"></div>
        </div>
        
        <!-- Loading Text -->
        <h2 class="text-3xl font-bold text-white tracking-wider animate-pulse">
            LOADING SHOEMART
        </h2>
        
        <!-- Loading dots -->
        <div class="flex justify-center mt-6 space-x-2">
            <div class="w-3 h-3 bg-white rounded-full animate-bounce" style="animation-delay: 0s;"></div>
            <div class="w-3 h-3 bg-white rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
            <div class="w-3 h-3 bg-white rounded-full animate-bounce" style="animation-delay: 0.4s;"></div>
        </div>
    </div>
</div>

<style>
    #loading-screen {
        opacity: 1;
        transition: opacity 0.5s ease-out;
    }
    
    #loading-screen.hidden {
        opacity: 0;
        pointer-events: none;
    }
</style>

<script>
    // Show loading screen on page load
    document.addEventListener('DOMContentLoaded', function() {
        const loadingScreen = document.getElementById('loading-screen');
        
        // Hide loading screen after page is fully loaded
        window.addEventListener('load', function() {
            if (loadingScreen) {
                setTimeout(function() {
                    loadingScreen.classList.add('hidden');
                    setTimeout(function() {
                        loadingScreen.style.display = 'none';
                    }, 500);
                }, 1000); // Show for at least 1 second
            }
        });
    });
    
    // Show loading screen when navigating to another page
    document.addEventListener('DOMContentLoaded', function() {
        const links = document.querySelectorAll('a:not([target="_blank"])');
        const loadingScreen = document.getElementById('loading-screen');
        
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                // Don't show loading for same page anchors
                if (this.getAttribute('href')?.startsWith('#')) {
                    return;
                }
                
                // Show loading screen
                if (loadingScreen) {
                    loadingScreen.style.display = 'flex';
                    loadingScreen.classList.remove('hidden');
                }
            });
        });
    });
    
    // Show loading on form submissions
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        const loadingScreen = document.getElementById('loading-screen');
        
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                if (loadingScreen) {
                    loadingScreen.style.display = 'flex';
                    loadingScreen.classList.remove('hidden');
                }
            });
        });
    });
</script>
