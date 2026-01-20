<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ $settings->website_name ?? 'App' }}">
    <meta name="theme-color" content="#3b82f6">
    
    <title>@yield('title', $settings->website_name ?? 'App')</title>
    
    <!-- Favicon & App Icons -->
    @if (isset($settings) && $settings->fav_icon)
        <link rel="icon" type="image/png" href="{{ Storage::url($settings->fav_icon) }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ Storage::url($settings->fav_icon) }}">
        <link rel="android-touch-icon" href="{{ Storage::url($settings->fav_icon) }}">
    @endif
    
    <!-- Stylesheets -->
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    
    <!-- Scripts -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    
    <!-- Google AdSense -->
    @if($adsense ?? false)
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $adsense->publisher_id }}" crossorigin="anonymous"></script>
    @endif
    
    <!-- Mobile App Styles -->
    <style>
        * {
            -webkit-tap-highlight-color: transparent;
        }
        
        html, body {
            height: 100%;
            -webkit-user-select: none;
            user-select: none;
        }
        
        body {
            display: flex;
            flex-direction: column;
            background: #fff;
        }
        
        .dark body {
            background: #1e2125;
            color: #fff;
        }
        
        /* Safe area support for notched devices */
        .safe-area-top {
            padding-top: max(0.5rem, env(safe-area-inset-top));
        }
        
        .safe-area-bottom {
            padding-bottom: max(0.5rem, env(safe-area-inset-bottom));
        }
        
        .safe-area-left {
            padding-left: max(0.5rem, env(safe-area-inset-left));
        }
        
        .safe-area-right {
            padding-right: max(0.5rem, env(safe-area-inset-right));
        }
        
        /* Header styles */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 40;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            height: 56px;
        }
        
        .dark header {
            background: #2d2f33;
            border-bottom-color: #4a4e53;
        }
        
        /* Main content area */
        main {
            flex: 1;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            padding-top: 56px;
            padding-bottom: 72px;
            scroll-behavior: smooth;
        }
        
        .lg\:pl-64 {
            @apply lg:pl-64;
        }
        
        /* Bottom navigation */
        nav.bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 40;
            height: 72px;
            background: #fff;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            padding-top: 8px;
            padding-bottom: max(8px, env(safe-area-inset-bottom));
        }
        
        .dark nav.bottom-nav {
            background: #2d2f33;
            border-top-color: #4a4e53;
        }
        
        /* Smooth transitions */
        a, button {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Responsive: Hide bottom nav on desktop */
        @media (min-width: 1024px) {
            main {
                padding-bottom: 0;
            }
            nav.bottom-nav {
                display: none;
            }
            header {
                height: 64px;
            }
            main {
                padding-top: 64px;
                padding-left: 256px;
            }
        }
        
        /* Loading states */
        .skeleton {
            background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        
        /* Pull to refresh indicator */
        .pull-to-refresh {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60px;
            color: #3b82f6;
        }
    </style>
    
    @stack('styles')
</head>
<body class="{{ session('dark_mode', 'light') }} relative">
    <!-- Top Navigation -->
    @include('components.navigation.top-nav')
    
    <!-- Main Content Area -->
    <main id="main-content" class="bg-gray-50 dark:bg-gray-900">
        @yield('content')
    </main>
    
    <!-- Bottom Navigation (Mobile) -->
    @auth
        @include('components.navigation.bottom-nav')
    @endauth
    
    <!-- Side Navigation (Desktop) -->
    @auth
        @include('components.navigation.side-nav')
    @endauth
    
    <!-- Scripts -->
    @vite('resources/js/app.js')
    
    <script>
        // Dark mode toggle
        document.getElementById('dark-mode-toggle')?.addEventListener('click', function() {
            fetch('/api/toggle-dark-mode', { method: 'POST' })
                .then(r => r.json())
                .then(data => {
                    location.reload();
                });
        });
        
        // Handle mobile viewport
        window.addEventListener('orientationchange', () => {
            setTimeout(() => {
                window.scrollTo(0, 0);
            }, 100);
        });
        
        // Prevent zoom on input focus (mobile)
        document.addEventListener('touchstart', function(e) {
            if (e.target.matches('input, textarea, select')) {
                e.target.style.fontSize = '16px';
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
