<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $settings->website_name ?? 'App')</title>
    
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @if (isset($settings) && $settings->fav_icon)
    <link rel="icon" type="image/png" href="{{ Storage::url($settings->fav_icon) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ Storage::url($settings->fav_icon) }}">
    @endif
    
    @if($adsense ?? false)
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $adsense->publisher_id }}" crossorigin="anonymous"></script>
    @endif
    
    <style>
        * { -webkit-tap-highlight-color: transparent; }
        
        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        
        body {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        #app-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 56px;
            z-index: 40;
            padding-top: max(0.5rem, env(safe-area-inset-top));
        }
        
        #app-content {
            flex: 1;
            margin-top: 56px;
            margin-bottom: 72px;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
        }
        
        #app-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 72px;
            z-index: 40;
            padding-bottom: max(0.5rem, env(safe-area-inset-bottom));
        }
        
        /* SPA Navigation Animations */
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        #app-content.animate-in {
            animation: slideInUp 0.3s ease-out forwards;
        }
        
        #app-content.animate-out {
            animation: slideInDown 0.3s ease-in reverse forwards;
        }
        
        /* Loading indicator */
        #spa-loader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            z-index: 999;
            background: linear-gradient(90deg, #3b82f6, #1e40af);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        #spa-loader:not(.hidden) {
            opacity: 1;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }
        
        .animate-pulse {
            animation: pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @media (min-width: 1024px) {
            #app-nav { display: none; }
            #app-content { margin-bottom: 0; }
        }
    </style>
    
    @stack('styles')
</head>
<body class="{{ session('dark_mode', 'light') }}">
    <!-- SPA Request: Return only content without full page wrapper -->
    @if(request()->attributes->get('spa_request', false))
        <main id="app-content" class="bg-gray-50 dark:bg-gray-900">
            @yield('content')
        </main>
    @else
        <!-- Full Page Render: Header + Content + Nav -->
        
        <!-- Header -->
        <header id="app-header" class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
            @yield('header')
        </header>
        
        <!-- Main Content -->
        <main id="app-content" class="bg-gray-50 dark:bg-gray-900">
            @yield('content')
        </main>
        
        <!-- Bottom Navigation -->
        @auth
        <nav id="app-nav" class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            @include('components.bottom-nav')
        </nav>
        @endauth
        
        <!-- SPA Navigation Script -->
        @vite('resources/js/app.js')
        <script src="{{ asset('js/spa-navigator.js') }}" defer></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const content = document.getElementById('app-content');
                if (content) {
                    content.addEventListener('scroll', function() {
                        document.body.style.position = this.scrollTop > 0 ? 'relative' : 'static';
                    });
                }
            });
            
            // Handle page visibility to refresh data if needed
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    window.dispatchEvent(new CustomEvent('spa:visible'));
                }
            });
        </script>
        
        @stack('scripts')
    @endif
</body>
</html>
