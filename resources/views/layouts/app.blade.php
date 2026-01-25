<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cultiv ID')</title>
   <!--  <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}?JanganNgintip={{ time() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <link rel="manifest" href="/manifest.json">

    @if (isset($settings) && $settings->fav_icon)
    <link rel="icon" type="image/png" href="{{ Storage::url($settings->fav_icon) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ Storage::url($settings->fav_icon) }}">
    <link rel="android-touch-icon" href="{{ Storage::url($settings->fav_icon) }}">
    <link rel="windows-touch-icon" href="{{ Storage::url($settings->fav_icon) }}">
    @endif

    @if($adsense)
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $adsense->publisher_id }}" crossorigin="anonymous"></script>
    @endif

    <style>
        .nav-overlap {
            position: absolute;
            bottom: -20%;
            left: 0;
            right: 0;
        }

        .dark {
            background-color: #1e2125;
            color: #fff;
        }
        .dark .bg-white {
            background-color: #2d2f33;
        }
        .dark .text-gray-500 {
            color: #8a8d91;
        }
        .dark .border-gray-300 {
            border-color: #4a4e53;
        }
        .dark .hover\:bg-gray-200:hover {
            background-color: #383b3e;
        }
        .dark .text-gray-800 {
            color: #c8ccd1;
        }
        .dark .text-red-600 {
            color: #ff4d4f;
        }
        .dark .bg-gray-300 {
            background-color: #4a4e53;
        }
        .dark .bg-gray-200 {
            background-color: #4a4e53;
        }
        .dark .bg-gray-100 {
            background-color: #4a4e53;
        }
        .dark .text-blue-500 {
            color: #1890ff;
        }

        #app-content {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .htmx-request.htmx-settling #app-content {
            opacity: 1;
        }

        .htmx-request.htmx-swapping #app-content {
            opacity: 0.6;
        }

        .htmx-indicator {
            display: none;
        }

        .htmx-request .htmx-indicator {
            display: inline;
        }

        .htmx-request.htmx-settling .htmx-indicator {
            display: none;
        }

        [x-cloak] { display: none !important; }
       
    </style>
</head>
<body class="{{ session('dark_mode', 'light') }}" x-data="{ showModal: false }">
    <div class="min-h-screen flex flex-col">
        <!-- Fixed Header -->
        <header class="fixed top-0 left-0 right-0 h-14 bg-gray-800 border-b border-gray-200 dark:border-gray-700 z-40 flex items-center px-4 ">
            <div class="flex items-center justify-between w-full mx-auto max-w-lg">
                @if(request()->route() && request()->route()->getName() !== 'home')
                    <button onclick="window.history.back()" class="text-white text-lg mr-2">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                @endif
                @if(!(request()->route() && request()->route()->getName() !== 'home'))
                <a href="{{ route('home') }}" class="text-2xl font-bold text-white flex items-center gap-2">
                    @if (isset($settings) && $settings->logo)
                        <img class="h-8 w-auto rounded-md" src="{{ Storage::url($settings->logo) }}" alt="Logo"> 
                        <div class="text-xxxs pt-2">
                             v1.0.16
                        </div>

                    @else
                        Cultiv ID
                    @endif
                </a>
                @endif
                
                <div class="flex gap-3">
                    @guest
                        <a href="{{ route('login') }}" class="text-white text-sm font-semibold hover:text-blue-400">Login</a>
                    @else
                        <button id="dark-mode-toggle" class="text-white text-lg">
                            <i class="fas fa-toggle-on"></i>
                        </button>
                        @if(auth()->user()->profile_photo_path)
                            <a href="{{ route('profile', auth()->user()->username) }}" hx-get="{{ route('profile', auth()->user()->username) }}" hx-target="#app-content" hx-push-url="true" class="w-8 h-8 rounded-full hover:opacity-80 transition">
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Profile Photo" class="w-8 h-8 rounded-full">
                            </a>
                        @else
                            <a href="{{ route('profile', auth()->user()->username) }}" hx-get="{{ route('profile', auth()->user()->username) }}" hx-target="#app-content" hx-push-url="true" class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-xs font-semibold text-white">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </a>
                        @endif
                    @endguest
                </div>
            </div>
        </header>

        <!-- Content Area (Scrollable) -->
        <main id="app-content" class="flex-1 mt-14 mb-20 overflow-y-auto">
            @if(request()->header('HX-Request'))
                @yield('content')
            @else
                @yield('content')
            @endif
        </main>

        <!-- Fixed Bottom Navigation -->
        <nav class="fixed bottom-0 left-0 right-0 h-20 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 z-40 flex justify-around items-end pb-2 px-1 mx-auto max-w-lg">
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center gap-1 text-gray-600 dark:text-gray-300 hover:text-green-600 transition-colors flex-1 py-2 text-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10.5L12 3l9 7.5M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10"/>
                </svg>
                <span class="text-xs">Home</span>
            </a>

            <a href="{{ route('index.sosmed') }}" hx-get="{{ route('index.sosmed') }}" hx-target="#app-content" hx-push-url="true" class="flex flex-col items-center justify-center gap-1 text-gray-600 dark:text-gray-300 hover:text-green-600 transition-colors flex-1 py-2 text-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="9" cy="7" r="3"/>
                    <circle cx="17" cy="7" r="3"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2
                            M13 15h4a4 4 0 014 4v2"/>
                </svg>
                <span class="text-xs">Community</span>

            </a>

            <button onclick="showAddMenu()" class="flex flex-col items-center justify-center gap-1 text-gray-600 dark:text-gray-300 hover:text-green-600 transition-colors flex-1 py-2 text-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="text-xs">Add</span>
            </button>

            <a href="{{ route('all.products') }}" hx-get="{{ route('all.products') }}" hx-target="#app-content" hx-push-url="true" class="flex flex-col items-center justify-center gap-1 text-gray-600 dark:text-gray-300 hover:text-green-600 transition-colors flex-1 py-2 text-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span class="text-xs">Market</span>
            </a>

            
                
            @php
                $profileUrl = auth()->check()
                    ? route('profile', auth()->user()->username)
                    : route('login');
            @endphp

            <a href="{{ $profileUrl }}"
            hx-get="{{ $profileUrl }}"
            hx-target="#app-content"
            hx-push-url="true"
            class="flex flex-col items-center justify-center gap-1 text-gray-600 dark:text-gray-300 hover:text-green-600 transition-colors flex-1 py-2 text-center">
                
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>

                <span class="text-xs">Profile</span>
            </a>

        </nav>
    </div>

    <script>
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        const body = document.body;
        const isDarkMode = localStorage.getItem('darkMode') === 'true';
        if (isDarkMode) {
            body.classList.add('dark');
            if (darkModeToggle) darkModeToggle.innerHTML = '<i class="fas fa-toggle-off"></i>';
        } else {
            if (darkModeToggle) darkModeToggle.innerHTML = '<i class="fas fa-toggle-on"></i>';
        }
        if (darkModeToggle) {
            darkModeToggle.addEventListener('click', () => {
                const isDark = body.classList.toggle('dark');
                localStorage.setItem('darkMode', isDark);
                darkModeToggle.innerHTML = isDark ? '<i class="fas fa-toggle-off"></i>' : '<i class="fas fa-toggle-on"></i>';
            });
        }
    </script>

    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Add Menu Modal -->
    <div id="addMenuModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-end">
        <div class="w-full bg-white dark:bg-gray-800 rounded-t-3xl p-3 animate-slide-up">
                <div class="flex justify-center py-2">
                  <div class="w-10 h-1 bg-gray-300 rounded-full"></div>
                </div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">What do you want to do?</h2>
                <button onclick="closeAddMenu()" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-2xl">×</button>
            </div>

            <div class="space-y-3">
                <!-- Add Hybrids -->
                <a href="{{ route('plant-submissions.create') }}" class="flex items-center gap-4 p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-xl hover:shadow-lg transition-all">
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center text-white text-xl">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-white">Add Hybrids</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Share your plant hybrids</p>
                    </div>
                </a>

                <!-- Add Product -->
                <a href="{{ route('products.create') ?? '#' }}" class="flex items-center gap-4 p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-xl hover:shadow-lg transition-all">
                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center text-white text-xl">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-white">Add Product</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Sell your products</p>
                    </div>
                </a>

                <!-- Add Discuss -->
                <a href="{{ route('post.create') ?? '#' }}" class="flex items-center gap-4 p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-xl hover:shadow-lg transition-all">
                    <div class="w-12 h-12 bg-gray-500 rounded-lg flex items-center justify-center text-white text-xl">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-white">Add Discussion</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Share your thoughts</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <style>
        @keyframes slideUp {
            from {
                transform: translateY(100%);
            }
            to {
                transform: translateY(0);
            }
        }
        
        .animate-slide-up {
            animation: slideUp 0.3s ease-out;
        }
    </style>

    <script>
        function showAddMenu() {
            const modal = document.getElementById('addMenuModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeAddMenu() {
            const modal = document.getElementById('addMenuModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('addMenuModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddMenu();
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAddMenu();
            }
        });
    </script>

    


</body>
    @stack('scripts')
</html>
