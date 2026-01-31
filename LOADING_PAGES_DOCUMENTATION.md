# Loading Pages Documentation

## Loading Page Features

I've created beautiful, modern loading pages for both customer and admin sides of the ShoeMart application.

### Files Created:

1. **Customer Loading Component**
   - Location: `resources/views/components/loading.blade.php`
   - Features:
     - Modern gradient background (blue to purple)
     - Animated spinning ring
     - Pulsing shoe icon
     - Smooth progress bar
     - Bouncing loading dots
     - Auto-hide when page loads
     - Accessibility support (respects reduced motion preference)

2. **Admin Loading Component**
   - Location: `resources/views/components/admin-loading.blade.php`
   - Features:
     - Dark professional gradient background
     - Dual rotating rings (counter-rotating)
     - Admin shield icon with pulse animation
     - Shimmer progress bar effect
     - Status messages that change dynamically
     - Bouncing indicators with glow effects
     - Auto-hide when page loads

3. **Standalone Loading Pages**
   - Customer: `resources/views/loading-customer.blade.php`
   - Admin: `resources/views/admin/loading.blade.php`

4. **Integrated into Layouts**
   - Customer layouts: `layouts/app.blade.php` and `layouts/public.blade.php`
   - Admin layout: `admin/layout.blade.php`

### Usage:

#### In Blade Templates:
```blade
<!-- Customer loading -->
<x-loading title="ShoeMart" message="Loading your experience..." />

<!-- Admin loading -->
<x-admin-loading title="Admin Panel" message="Loading dashboard..." />

<!-- Custom messages -->
<x-loading title="Checkout" message="Processing your order..." />
```

#### Automatic Loading:
The loading screens are now automatically included in:
- All customer-facing pages (via app.blade.php and public.blade.php)
- All admin pages (via admin/layout.blade.php)

They will automatically:
1. Display when the page starts loading
2. Show animated progress indicators
3. Hide smoothly once the page is fully loaded
4. Respect user's motion preferences

### Key Features:

**Customer Side:**
- Light, friendly design matching the shopping experience
- Blue and purple gradient theme
- Shoe/airplane icon representing delivery
- 3 bouncing dots for playful interaction

**Admin Side:**
- Professional dark theme
- Security shield icon
- Dual counter-rotating rings for sophistication
- Dynamic status messages:
  - "Initializing..."
  - "Loading modules..."
  - "Connecting to database..."
  - "Preparing dashboard..."
  - "Almost ready..."
- Glowing indicators for premium feel

### Customization:

You can customize the loading screens by passing props:

```blade
<x-loading 
    title="Custom Title" 
    message="Custom loading message..." 
/>
```

### Browser Compatibility:
- Works in all modern browsers
- CSS animations with fallbacks
- Respects `prefers-reduced-motion` for accessibility

### Performance:
- Pure CSS animations (no JavaScript for animations)
- Lightweight components
- Automatic cleanup after loading
- No memory leaks
