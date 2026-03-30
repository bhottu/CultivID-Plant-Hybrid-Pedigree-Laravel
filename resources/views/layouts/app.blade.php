<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Cultiv ID adalah platform plant pedigree, registrasi hybrid tanaman, komunitas tanaman dan marketplace tanaman hias.')">
    {{-- ================= SEO BASIC ================= --}}
    <title>
        @hasSection('title')
            @yield('title') | Cultiv ID
        @else
            Cultiv ID – Plant Pedigree, Plant Registry & Plant Market
        @endif
    </title>

    {{-- ================= OPEN GRAPH (WA / FB / IG) ================= --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Cultiv ID">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('title')) ?: 'Cultiv ID – Plant Pedigree & Registry')">
    <meta property="og:description" content="@yield('og_description', 'Plant Pedigree, Plant Registry & Plant Market')">
    <meta property="og:image" content="@yield('og_image', asset('default-og.jpg'))">
    
    <link rel="stylesheet" href="{{ mix('css/app.css') }}?JanganNgintip={{ time() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="manifest" href="/manifest.json">

    @if (isset($settings) && $settings->fav_icon)
    <link rel="icon" type="image/png" href="{{ Storage::url($settings->fav_icon) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ Storage::url($settings->fav_icon) }}">
    <link rel="android-touch-icon" href="{{ Storage::url($settings->fav_icon) }}">
    <link rel="windows-touch-icon" href="{{ Storage::url($settings->fav_icon) }}">
    @endif

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>

  

    @if($adsense)
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $adsense->publisher_id }}" crossorigin="anonymous"></script>
    @endif

    <style>
        @layer utilities {
            .bg-cus-500 {
                background-color: #365b6d;
            }
            .bg-cusx-500 {
                background-color: #365b6d;
            }
        }
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
            color: #365b6d;
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

        /* Hide scrollbar  */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for Firefox */
        .scrollbar-hide {
            scrollbar-width: none;
        }

        /* Hide scrollbar for IE/Edge lama */
        .scrollbar-hide {
            -ms-overflow-style: none;
        }

        [x-cloak] { display: none !important; }
       
    </style>
</head>
<body class="{{ session('dark_mode', 'light') }}" x-data="{ showModal: false }">
    <div class="min-h-screen flex flex-col">
        {{-- Fixed Header --}}
        <header class="fixed top-0 left-0 right-0  h-14 bg-cus-500 dark:border-gray-700 z-40 flex items-center px-4 ">
            <div class="flex items-center justify-between w-full mx-auto">
                

                @if(request()->route() && request()->route()->getName() !== 'home')
                    <div class="relative hidden md:block">
                        <button 
                            id="menuToggle"
                            class="text-white w-8 h-8 flex items-center justify-center focus:outline-none"
                            aria-label="Menu"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>

                    <button onclick="window.history.back()" class="text-white text-lg mr-2 md:hidden">
                        <i class="fas fa-arrow-left"></i>
                    </button>

                    <a href="{{ route('home') }}" class="hidden md:block text-2xl font-bold text-white flex items-center gap-2">
                        @if (isset($settings) && $settings->logo)
                            <img class="h-8 w-auto rounded-md" src="{{ Storage::url($settings->logo) }}" alt="Logo"> 
                        @else
                            Cultiv ID
                        @endif
                    </a>

                @endif

                @if(!(request()->route() && request()->route()->getName() !== 'home'))
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-white flex items-center gap-2">
                        @if (isset($settings) && $settings->logo)
                            <img class="h-8 w-auto rounded-md" src="{{ Storage::url($settings->logo) }}" alt="Logo"> 
                            <div class="text-xxxs pt-2">
                                v1.0.52
                            </div>

                        @else
                            Cultiv ID
                        @endif
                    </a>
                @endif


                <div class="ml-auto flex items-center gap-4">

                    <button id="installApp" class="hidden flex border border-white items-center gap-2 hover:bg-blue-400  text-white px-3 py-2 rounded-lg text-xs font-medium transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Install App</span>
                    </button>

                    {{-- Search Form (Hidden by default) --}}
                    <div id="search-form" class="hidden bg-cus-500 ml-auto ">
            
                        <form action="{{ route('search') }}" method="GET" class="flex gap-2">
                            <input type="text" name="query" class="w-full  px-2 py-1 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search here.." required>
                            <button type="submit" class="bg-cus-500 hover:bg-blue-700 text-white px-4 py-2 rounded-r-md font-medium transition duration-200 border-2 border-white">
                                Search
                            </button>
                            <button type="button" id="search-close" class="bg-cus-500 hover:bg-gray-600 rounded-r-md text-white px-4 py-2 rounded-md font-medium transition duration-200">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                
                    </div>
                    <button id="search-toggle" class="hidden md:block hover:text-blue-500 text-gray-800 text-white transition">
                        <i class="fas fa-search"></i>
                    </button>

                    @php
                    $unreadCount = \App\Models\Notification::where('user_id', Auth::id())
                        ->where('is_read', false)
                        ->count();
                    @endphp

                    <a href="{{ route('notifications.index') }}" class="relative inline-block">
                        
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6 text-white hover:text-gray-500 transition">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>

                       @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-1
                                min-w-[12px] h-[12px]
                                px-1
                                bg-red-600 text-white
                                text-xs
                                flex items-center justify-center
                                rounded-full leading-none">
                                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                            </span>
                        @endif

                    </a>

                    

                    {{--  CART 
                        <a href="{{ route('checkout') }}" class="relative inline-flex items-center">
                            
                            <!-- ICON CART -->
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="h-6 w-6 text-white hover:text-blue-600 transition" 
                                fill="none" 
                                viewBox="0 0 24 24" 
                                stroke="currentColor" 
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M7 13L5.4 5M16 21a1 1 0 100-2 1 1 0 000 2zM9 21a1 1 0 100-2 1 1 0 000 2z"/>
                            </svg>

                            <!-- BADGE JUMLAH ITEM 
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())
                                    ->where('status', 'active')
                                    ->withCount('items')
                                    ->first();
                            @endphp

                            @if($cartCount && $cartCount->items_count > 0)
                                <span class="
                                    absolute -top-1 -right-1
                                    min-w-[13px] h-[13px]
                                    px-1
                                    bg-red-500 text-white
                                    text-[10px] font-semibold
                                    flex items-center justify-center
                                    rounded-full
                                    leading-none
                                ">
                                    {{ $cartCount->items_count }}
                                </span>
                            @endif 
                            -->


                        </a>
                    --}}


                    
                </div>

                    <div id="installModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
                        <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-sm font-bold">Install Cultiv.ID</h3>
                                <button onclick="closeInstallModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                            </div>
                            
                            <div class="space-y-4 text-gray-600">
                                <p class="text-sm">Ikuti langkah berikut untuk menambahkan aplikasi ke layar utama Anda:</p>
                                
                                <div id="iosInstructions" class="hidden space-y-3">
                                    <div class="flex items-start gap-3">
                                        <span class="bg-gray-100 p-2 rounded-full">1</span>
                                        <p>Tekan tombol Share di bagian bawah browser.</p>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <span class="bg-gray-100 p-2 rounded-full">2</span>
                                        <p>Scroll ke bawah dan pilih 'Add to Home Screen'.</p>
                                    </div>
                                </div>

                                <div id="androidInstructions" class="space-y-3">
                                    <div class="flex items-start gap-3">
                                        <span class="bg-gray-100 p-2 rounded-full">1</span>
                                        <p>Klik tombol Install yang muncul di browser.</p>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <span class="bg-gray-100 p-2 rounded-full">2</span>
                                        <p>Atau klik titik tiga (menu) dan pilih 'Install App'.</p>
                                    </div>
                                </div>
                            </div>

                            <button onclick="closeInstallModal()" class="w-full mt-6 bg-gray-900 text-white py-3 rounded-xl font-semibold">
                                Ok
                            </button>
                        </div>
                    </div>

                


                <div id="mobileMenu" class="fixed inset-0 bg-white z-50 hidden flex-col">
                    {{-- Header nav bar--}}
                    <div class="flex left-0 right-0 h-14  items-center justify-between px-4 py-4 z-40 border-b bg-cus-500">
                        <span class="text-sm font-semibold text-gray-800">
                            @if(!(request()->route() && request()->route()->getName() !== 'home'))
                                <a href="{{ route('home') }}" class="text-2xl font-bold text-white flex items-center gap-2">
                                    @if (isset($settings) && $settings->logo)
                                        <img class="h-8 w-auto rounded-md" src="{{ Storage::url($settings->logo) }}" alt="Logo"> 
                                        <div class="text-xxxs pt-2">
                                            v1.0.52
                                        </div>
                                    @else
                                        Cultiv ID
                                    @endif
                                </a>
                            @endif
                        </span>

                        <button id="menuClose" class="text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 overflow-y-auto px-6 py-6 space-y-4">
                        @php
                                $profileUrl = auth()->check()
                                    ? route('profile', auth()->user()->username)
                                    : route('login');
                            @endphp
                        @guest
                            <a href="{{ route('login') }}" class="flex items-center p-2 text-sm gap-3 dark:text-gray-400 dark:bg-gray-700 font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 17l5-5m0 0l-5-5m5 5H3"/>
                                </svg>
                        <span class="flex-1 text-left whitespace-nowrap text-gray-700">Login / Register</span>
                            </a>
                            
                        @else

                        <div class="bg-white p-4 rounded shadow-sm border border-gray-200">
                                        <p class="flex text-xs text-gray-500 italic text-left">
                                            <ul class="my-6 space-y-3">
                                                    <a href="{{ route('plant-submissions.create') }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>

                                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Add Plants & Hybrid</span>  
                                                        
                                                    </a>
                                            </ul>
                                            <ul class="my-6 space-y-3">
                                                    <a href="{{ route('products.create') ?? '#' }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>

                                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Add Product</span>  
                                                        
                                                    </a>
                                            </ul>
                                            <ul class="my-6 space-y-3">
                                                    <a href="{{ route('post.create') ?? '#' }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>

                                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Add Post</span>  
                                                        
                                                    </a>
                                            </ul>
                                            <ul class="my-6 space-y-3 border-t mt-2">
                                                <a href="{{ route('all.products') }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-red-50 hover:bg-green-50 group" disabled>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                    </svg>

                                                    <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Market</span>  
                                                    
                                                </a>
                                            </ul>
                                            <ul class="my-6 space-y-3 border-b">
                                                <a href="{{ route('index.sosmed') }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-blue-50 hover:bg-green-50 group" disabled>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <circle cx="9" cy="7" r="3"/>
                                                        <circle cx="17" cy="7" r="3"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2
                                                                M13 15h4a4 4 0 014 4v2"/>
                                                    </svg>

                                                    <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Community</span>  
                                                    
                                                </a>
                                            </ul>
                                        </p>
                        </div> 

                        <div class="bg-white p-4 rounded shadow-sm border border-gray-200">     
                                <ul class="my-6 space-y-3"> 
                                    <a href="{{ $profileUrl }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg> 
                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">
                                            My Profile
                                        </span>
                                    </a>
                                </ul>
                                <ul class="my-6 space-y-3">
                                                <a href="{{ route('wallet.index') }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700 dark:text-gray-400" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M21 12v6a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h11l5 5z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16 12h.01" />
                                                    </svg>

                                                    <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">My Wallet</span>  
                                                    
                                                    <span class="text-heading text-xs font-medium px-1.5 py-0.5 text-gray-700 dark:text-gray-400">
                                                    
                                                            Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}
                                                        
                                                    </span>
                                                    
                                                </a>
                                            </ul>
                                            <ul class="my-6 space-y-3">
                                                    <a href="{{ route('profile.edit') }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.1 2.1 0 013.003 3.003L7.5 18.855 3 21l2.145-4.5L16.862 3.487z"></path>
                                                        </svg>

                                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Edit profile</span>  
                                                        
                                                    </a>
                                                </ul>
                                                <ul class="my-6 space-y-3">
                                                    <a href="{{ route('plant-submissions.index') }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20V10m0 0c-3 0-6-2-6-5 3 0 6 2 6 5zm0 0c3 0 6-2 6-5-3 0-6 2-6 5z"></path>
                                                        </svg>

                                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">My submissions</span>  
                                                        
                                                    </a>
                                                </ul>
                                                <ul class="my-6 space-y-3">
                                                    <a href="{{ route('posts.by.username', auth()->user()->username) }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 4h6m-6 4h6m-6 4h6M5 20h14a1 1 0 001-1V7l-5-5H6a1 1 0 00-1 1v16a1 1 0 001 1z"></path>
                                                        </svg>

                                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">My posts</span>  
                                                        
                                                    </a>
                                                </ul>
                                                <ul class="my-6 space-y-3">
                                                    <a href="{{ route('products.by.username', auth()->user()->username) }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                                        <svg class="w-4 h-4 text-gray-700 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                        </svg>

                                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">My products</span>  
                                                        
                                                    </a>
                                                </ul>
                                                <ul class="my-6 space-y-3">
                                                    <div class="flex dark:text-gray-400 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50  hover:bg-green-50  group">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700 dark:text-gray-400" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                                                        </svg>

                                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Dark mode</span>
                                                        <span class="text-heading text-xs font-medium px-1.5 py-0.5"> 
                                                            <button class="dark-mode-toggle text-gray-700 dark:text-gray-400 text-sm">
                                                            <i class="fas fa-toggle-on"></i>
                                                            </button>
                                                    </span>
                                                    </div>
                                                </ul>
                                                <ul class="my-6 space-y-3 rounded-full bg-red-100">
                                                    <form method="POST" action="{{ route('logout') }}">
                                                        @csrf

                                                        <button type="submit"
                                                            class="group flex w-full items-center gap-3 rounded-base p-2
                                                            text-sm font-semibold
                                                            bg-red-100 hover:bg-red-50
                                                            transition-colors rounded-full">

                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-4 w-4 shrink-0 text-gray-700"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor"
                                                            stroke-width="1.8">
                                                            <path stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h1a3 3 0 013 3v1" />
                                                            </svg>

                                                            <span class="flex-1 text-left whitespace-nowrap text-gray-700">
                                                                Logout
                                                            </span>
                                                        </button>
                                                    </form>
                                                </ul>
                        </div>

                        @endguest

                        <div class="bg-white p-4 rounded shadow-sm border border-gray-200">   

                            <a href="{{ route('admin.settings.about') }}" class="flex dark:text-gray-400 dark:bg-gray-700 items-center p-2 text-sm gap-3 text-heading rounded-base bg-gray-50 hover:bg-green-50 group">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.75"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="w-4 h-4">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 10v5"/>
                                <path d="M12 7h.01"/>
                                </svg>

                                About Us
                            </a>

                            <a href="{{ route('admin.settings.contact') }}" class="flex dark:text-gray-400 dark:bg-gray-700 items-center p-2 text-sm gap-3 text-heading rounded-base bg-gray-50 hover:bg-green-50 group">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.75"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="w-4 h-4">
                                <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                                </svg>
                                Contact Us
                            </a>

                            <a href="{{ route('admin.settings.privacy') }}" class="flex dark:text-gray-400 dark:bg-gray-700 items-center p-2 text-sm gap-3 text-heading rounded-base bg-gray-50 hover:bg-green-50 group">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.75"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="w-4 h-4">
                                <path d="M12 3l7 4v5c0 5-3.5 9-7 9s-7-4-7-9V7l7-4z"/>
                                <path d="M9 12l2 2 4-4"/>
                                </svg>
                                Privacy Policy
                            </a>

                             <a href="{{ route('become.partner') }}" class="flex dark:text-gray-400 dark:bg-gray-700 items-center p-2 text-sm gap-3 text-heading rounded-base bg-gray-50 hover:bg-green-50 group">
                                <svg id="Layer_1" class="w-4 h-4" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 67.72"><defs>
                                    <style>.cls-1{fill-rule:evenodd;}</style></defs><title>hand-shake</title>
                                    <path class="cls-1" d="M3.24,16.78l2.3,28.47c.31,2.94,1,4.83,1.84,5.87a2.82,2.82,0,0,0,2.85.85l.27,0H21.78a3.84,3.84,0,0,0,3.31-1.32l.05-.06A8.31,8.31,0,0,0,26.32,46V14.57a1.21,1.21,0,0,1-.07-.43.49.49,0,0,1,0-.12A2.93,2.93,0,0,0,25,11.92a7.16,7.16,0,0,0-3.88-.78H7a4.3,4.3,0,0,0-3.19,1.17c-.67.8-.91,2.18-.58,4.33v.14ZM93.1,15.57a10.86,10.86,0,0,1,.09-1.43L88,10.65c-.75-.5-1.57-1.08-2.4-1.66-3-2.08-6-4.22-9.33-5.09a26.12,26.12,0,0,0-5.94-.82,20.38,20.38,0,0,0-5.46.6,14,14,0,0,0-3,1.14,10.75,10.75,0,0,0-2.31,1.64L56,10.63a1.59,1.59,0,0,1-.44.52L45.89,22.66a4.21,4.21,0,0,0,.84,1.85,4.09,4.09,0,0,0,1.78,1.26,5.77,5.77,0,0,0,2.52.31,8.21,8.21,0,0,0,4.42-1.83L58.14,22c.68-.56,1.25-1.08,1.81-1.59a24.11,24.11,0,0,1,3.78-3c3-1.8,6-1.86,9,3.12L87.93,48H93.1V15.57Zm1.23-4.39a5.67,5.67,0,0,1,.8-.9A8.24,8.24,0,0,1,100.8,8.5H114c2.77,0,5,.49,6.58,1.69,1.73,1.34,2.55,3.37,2.2,6.29l-2.92,30.21a10.68,10.68,0,0,1-2.2,6.27,6.74,6.74,0,0,1-5.7,2.22H100.09a6.06,6.06,0,0,1-4.26-1.31,8,8,0,0,1-2.15-2.81H89.57a7.09,7.09,0,0,1,.08,4.52,7.43,7.43,0,0,1-2.47,3.5,8.47,8.47,0,0,1-3.87,1.71,7.68,7.68,0,0,1-4.17-.46,10.83,10.83,0,0,1-4.91,3.13A8.53,8.53,0,0,1,69,63.22a10.44,10.44,0,0,1-5.56,3.46,10.22,10.22,0,0,1-6.62-1,9.76,9.76,0,0,1-2.29,1.35,8.61,8.61,0,0,1-3.55.65,9.66,9.66,0,0,1-6.55-2.39,19.2,19.2,0,0,1-3.68-5.09L34.19,48.8H29.11a9,9,0,0,1-1.51,3.63l-.07.1A6.74,6.74,0,0,1,21.7,55H10.61a5.66,5.66,0,0,1-5.56-1.89c-1.3-1.51-2.2-4-2.58-7.57v-.13L.17,17.05c-.46-3.06,0-5.23,1.28-6.71A7.13,7.13,0,0,1,6.87,8.06H21.1a10,10,0,0,1,5.57,1.27h0a5.73,5.73,0,0,1,2.43,3.25h9.55a27.48,27.48,0,0,1,7.13-3.67A19.39,19.39,0,0,1,54,8.27l3.27-3.89.12-.13a13.71,13.71,0,0,1,3-2.16A17.83,17.83,0,0,1,64.06.69,24.23,24.23,0,0,1,70.35,0,29.26,29.26,0,0,1,77,.92h0c3.81,1,7.1,3.31,10.3,5.55.77.54,1.53,1.07,2.35,1.62l4.65,3.09ZM15.77,38.76a2.66,2.66,0,1,1-2.65,2.65,2.66,2.66,0,0,1,2.65-2.65ZM86.36,50.92a1.57,1.57,0,0,1-.88-1L70.06,22.09c-1.71-2.86-3.25-2.94-4.75-2.05A22.52,22.52,0,0,0,62,22.71c-.68.62-1.36,1.24-1.92,1.7l-2.73,2.25a11.38,11.38,0,0,1-6.09,2.5,9,9,0,0,1-3.86-.5,7.28,7.28,0,0,1-3.11-2.22,7.44,7.44,0,0,1-1.59-4.11,1.58,1.58,0,0,1,.45-1.22l8.33-9.91a15,15,0,0,0-4.81.67,25.56,25.56,0,0,0-6.63,3.48,1.5,1.5,0,0,1-1,.33H29.41v30h5.67a1.55,1.55,0,0,1,1.38.84l7,12.15a17.79,17.79,0,0,0,3,4.34,6.77,6.77,0,0,0,4.58,1.6,5.63,5.63,0,0,0,2.3-.42,5.8,5.8,0,0,0,1.31-.75L50.14,55a1.54,1.54,0,0,1,2.71-1.45l4.94,9.23a6.67,6.67,0,0,0,8.87-1.54L59.55,50.06A1.54,1.54,0,0,1,60,47.93a1.56,1.56,0,0,1,2.13.47l7.49,11.77a5.81,5.81,0,0,0,3.78.32,7.65,7.65,0,0,0,3.44-2.24L70.07,45.47A1.55,1.55,0,0,1,72.8,44l7,13.22a4.44,4.44,0,0,0,3,.5,5.27,5.27,0,0,0,2.45-1.08,4.27,4.27,0,0,0,1.45-2,4.12,4.12,0,0,0-.23-3,1.48,1.48,0,0,1-.12-.71Zm20.32-12.16A2.66,2.66,0,1,1,104,41.41a2.66,2.66,0,0,1,2.65-2.65Z"/></svg>
                                Become a Partner
                            </a>

                        </div>

                    </div>
                </div>



            </div>
        </header>

        {{-- Content Area (Scrollable) --}}
        <main id="app-content" class="min-h-screen mt-14 mb-20">
            @if(request()->header('HX-Request'))
                @yield('content')
            @else
                @yield('content')
            @endif
        </main>

        {{-- Fixed Bottom Navigation --}}
        <nav class="fixed md:hidden bottom-0 left-0 right-0 h-20 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 z-40 flex justify-around items-end pb-2 px-1 mx-auto">
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center gap-1 text-gray-600 dark:text-gray-300 hover:text-green-600 transition-colors flex-1 py-2 text-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10.5L12 3l9 7.5M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10"/>
                </svg>
                <span class="text-xs">Home</span>
            </a>

            <a href="{{ route('index.sosmed') }}" class="flex flex-col items-center justify-center gap-1 text-gray-600 dark:text-gray-300 hover:text-green-600 transition-colors flex-1 py-2 text-center">
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

            <a href="{{ route('all.products') }}"  class="flex flex-col items-center justify-center gap-1 text-gray-600 dark:text-gray-300 hover:text-green-600 transition-colors flex-1 py-2 text-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span class="text-xs">Market</span>
            </a>

            <a href="{{ $profileUrl }}" class="flex flex-col items-center justify-center gap-1 text-gray-600 dark:text-gray-300 hover:text-green-600 transition-colors flex-1 py-2 text-center">
                
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>

                <span class="text-xs">Profile</span>
            </a>

        </nav>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const darkModeToggles = document.querySelectorAll('.dark-mode-toggle');
            const body = document.body;
            const isDarkMode = localStorage.getItem('darkMode') === 'dark';

            // Initialize dark mode state on page load
            if (isDarkMode) {
                body.classList.add('dark');
            } else {
                body.classList.remove('dark');
            }

            // Add event listener to all toggle buttons
            darkModeToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const isDark = body.classList.toggle('dark');
                    const newMode = isDark ? 'dark' : 'light';

                    // Update the localStorage value
                    localStorage.setItem('darkMode', newMode);

                    // Update the toggle button icon for all toggles
                    darkModeToggles.forEach(btn => {
                        btn.innerHTML = isDark ? '<i class="fas fa-toggle-off"></i>' : '<i class="fas fa-toggle-on"></i>';
                    });
                });
            });
        });
    </script>

    <script src="{{ asset('js/app.js') }}"></script>

    {{-- Add Menu Modal --}}
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
                {{-- Add Hybrids --}}
                <a href="{{ route('plant-submissions.create') }}" class="flex items-center gap-4 p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-xl hover:shadow-lg transition-all">
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center text-white text-xl">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold dark:text-gray-300">Add Plant or Hybrid</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Start building your pedigree</p>
                    </div>
                </a>

                {{-- Add Product --}}
                <a href="{{ route('products.create') ?? '#' }}" class="flex items-center gap-4 p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-xl hover:shadow-lg transition-all">
                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center text-white text-xl">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold dark:text-gray-300">Add Product</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Sell your products</p>
                    </div>
                </a>

                {{-- Add Discuss --}}
                <a href="{{ route('post.create') ?? '#' }}" class="flex items-center gap-4 p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-xl hover:shadow-lg transition-all">
                    <div class="w-12 h-12 bg-gray-500 rounded-lg flex items-center justify-center text-white text-xl">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold dark:text-gray-300">Add Discussion</h3>
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

    

<script>
    {{-- Bagian Menu Mobile (Gunakan Event Delegation agar HTMX aman) --}}
    document.addEventListener('click', (e) => {
        const mobileMenu = document.getElementById('mobileMenu');
        
        if (e.target.closest('#menuToggle')) {
            mobileMenu?.classList.remove('hidden');
            mobileMenu?.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }
        
        if (e.target.closest('#menuClose')) {
            mobileMenu?.classList.add('hidden');
            mobileMenu?.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        {{--  Close modal install jika klik tombol close di dalam modal --}}
        if (e.target.closest('#closeModalBtn')) { 
            closeInstallModal();
        }
    });

    {{-- Bagian PWA Install --}}
    let deferredPrompt;

    {{-- 1. Tangkap event secepat mungkin (Global) --}}
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        console.log('PWA: Prompt ready');
        refreshInstallBtn(); 
    });

    {{-- 2. Fungsi Utama untuk Menampilkan Tombol --}}
    function refreshInstallBtn() {
        const installBtn = document.getElementById('installApp');
        if (!installBtn) return;

        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches;

        
        if (deferredPrompt || (isIOS && !isStandalone)) {
            installBtn.classList.remove('hidden');
        }
    }

    
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('#installApp');
        if (!btn) return;

        if (deferredPrompt) {
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            if (outcome === 'accepted') btn.classList.add('hidden');
            deferredPrompt = null;
        } else {
            showInstallModal();
        }
    });

    function showInstallModal() {
        const installModal = document.getElementById('installModal');
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        
        if (!installModal) return;

        installModal.classList.remove('hidden');
        if (isIOS) {
            document.getElementById('iosInstructions')?.classList.remove('hidden');
            document.getElementById('androidInstructions')?.classList.add('hidden');
        } else {
            
            document.getElementById('iosInstructions')?.classList.add('hidden');
            document.getElementById('androidInstructions')?.classList.remove('hidden');
        }
    }

    function closeInstallModal() {
        document.getElementById('installModal')?.classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', refreshInstallBtn);

    document.addEventListener('htmx:afterSwap', function() {
        refreshInstallBtn();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchToggle = document.getElementById('search-toggle');
        const searchForm = document.getElementById('search-form');
        const searchClose = document.getElementById('search-close');

        // Toggle search form visibility
        searchToggle.addEventListener('click', function() {
            searchForm.classList.toggle('hidden');
        });

        // Close search form
        searchClose.addEventListener('click', function() {
            searchForm.classList.add('hidden');
        });

        // Close search form when clicking outside
        document.addEventListener('click', function(event) {
            if (!searchToggle.contains(event.target) && !searchForm.contains(event.target)) {
                searchForm.classList.add('hidden');
            }
        });

        // Close search form on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                searchForm.classList.add('hidden');
            }
        });
    });
</script>


</body>
    @stack('scripts')
</html>