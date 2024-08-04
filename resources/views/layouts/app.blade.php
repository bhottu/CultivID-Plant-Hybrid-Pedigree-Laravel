<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mingle')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    @if (isset($settings) && $settings->fav_icon)
    <link rel="icon" type="image/png" href="{{ Storage::url($settings->fav_icon) }}">
    @endif
    
    @if($adsense)
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $adsense->publisher_id }}" 
    crossorigin="anonymous"></script>
    @endif

    
    <style>
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
        
    </style>
</head>
<body class="{{ session('dark_mode', 'light') }}" x-data="{ showModal: false }">
<header>
    <nav class="bg-gray-800 p-6 border-b border-gray-200 dark:border-gray-700 shadow">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-2xl font-bold text-white" href="{{ route('home') }}">  
                @if (isset($settings) && $settings->logo)
                    <img class="h-10 w-auto rounded-md" src="{{ Storage::url($settings->logo) }}" alt="Logo">
                @endif
            </a> 
            <div class="flex space-x-4 items-center">
                <ul class="flex space-x-4">
                    @guest
                        <li><button id="dark-mode-toggle" class="text-white dark:text-gray-300"><i class="fas fa-toggle-on"></i></button></li>
                        <li><a class="hover:text-blue-500 text-white dark:text-gray-300" href="{{ route('login') }}">Login</a></li>
                        <li><a class="hover:text-blue-500 text-white dark:text-gray-300" href="{{ route('register') }}">Register</a></li>
                    @else
                        <li><button id="dark-mode-toggle" class="text-white dark:text-gray-300"><i class="fas fa-toggle-on"></i></button></li>
                        <li x-data="{ open: false }">
                            <button class="text-white text-2xl focus:outline-none" @click="open = !open">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4 11h-3v3h-2v-3H8v-2h3V8h2v3h3v2z"/>
                                </svg>
                            </button>
                            <ul x-show="open" @click.away="open = false" class="absolute bg-black shadow-md rounded-md overflow-hidden mt-2">
                                <li><a href="{{ route('products.create') }}" class="block px-4 py-2 text-white hover:bg-gray-700">Add Product</a></li>
                                <li><button @click="document.getElementById('uploadModal').classList.toggle('hidden')" class="block px-4 py-2 text-white hover:bg-gray-700">Add Discuss</button></li>
                            </ul>
                        </li>
                        <li><a class="hover:text-blue-500 text-white dark:text-gray-300" href="{{ route('profile', ['user' => Auth::user()->id]) }}">{{ Auth::user()->name }}</a></li>
                        <li><a class="hover:text-blue-500 text-white dark:text-gray-300" href="{{ route('profile.edit') }}">Setting</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="hover:text-blue-500 text-white dark:text-gray-300">Logout</button></form>
                        </li>
                       
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>

@yield('content')

@include('partials.footer')

<div id="uploadModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                    Add discuss
                </h3>
                <button class="text-black hover:text-gray-300" onclick="document.getElementById('uploadModal').classList.add('hidden')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mt-4">
                
                <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data" class="w-full">
                    @csrf
                    <div class="mb-4 w-full">
                        <label for="caption" class="sr-only">Caption</label>
                        <textarea name="caption" id="caption" placeholder="What's on your mind?" class="w-full border-b border-gray-300 focus:outline-none focus:border-blue-500 pb-1 resize-none" rows="4"></textarea>
                    </div>
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center">
                            <input type="file" name="image" id="image" class="hidden" accept="image/*" onchange="previewImage(event)">
                            <label for="image" class="block bg-gray-200 hover:bg-gray-300 py-2 px-4 rounded-md cursor-pointer"><i class="far fa-image"></i> Photo/Video</label>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Post</button>
                    </div>
                    <div id="image-preview"></div>
                </form>
                
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('image-preview');
            output.innerHTML = `<img src="${reader.result}" class="w-full mt-4">`;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<script src="{{ asset('js/app.js') }}"></script>

<script>
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const body = document.body;
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    if (isDarkMode) {
        body.classList.add('dark');
        darkModeToggle.innerHTML = '<i class="fas fa-toggle-off"></i>';
    } else {
        darkModeToggle.innerHTML = '<i class="fas fa-toggle-on"></i>';
    }
    darkModeToggle.addEventListener('click', () => {
        const isDark = body.classList.toggle('dark');
        localStorage.setItem('darkMode', isDark);
        if (isDark) {
            darkModeToggle.innerHTML = '<i class="fas fa-toggle-off"></i>';
        } else {
            darkModeToggle.innerHTML = '<i class="fas fa-toggle-on"></i>';
        }
    });
</script>

</body>
</html>
