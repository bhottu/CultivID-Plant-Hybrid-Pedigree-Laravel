<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
   
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.min.js" defer></script>
    <script src="//cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <style>
        .sidebar-text {
            display: none; /* Hidden by default */
        }
        .sidebar-open .sidebar-text {
            display: inline; /* Show when sidebar is open */
        }
        .cke_notification {
        display: none !important;
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
        
    
    </style>
</head>
<body class="{{ session('dark_mode', 'light') }}">
    
    @include('layouts.header')

    <div class="flex min-h-screen bg-white-800">
        <!-- Sidebar -->
        <div x-data="{ open: true }" x-bind:class="{'sidebar-open': open}" class="relative flex">
            <div :class="{'w-64': open, 'w-16': !open}" class="bg-gray-800 text-white flex flex-col transition-width duration-300">
                <!-- Toggle Button -->
                <button @click="open = !open" class="absolute top-4 left-4 text-gray-600 dark:text-gray-300 z-10 flex items-center space-x-2 p-2 bg-gray-200 dark:bg-gray-700 rounded-lg">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M3 12h18M3 18h18" />
    </svg>
    <span class="hidden md:inline">
                @if (isset($settings) && $settings->logo)
                    {{ $settings->website_name }}
                @endif
    </span> <!-- Teks yang akan ditampilkan di samping tombol -->
</button>


                <nav class="flex-1 px-2 py-4 bg-gray-800">
                    <ul class="space-y-2 pt-10">
                        <li>
                            <a href="{{ route('admin.home') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75V21h18V9.75L12 3 3 9.75zM13.5 21v-7.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21H6v-6.75a2.25 2.25 0 0 1 2.25-2.25h4.5A2.25 2.25 0 0 1 15 14.25V21h-1.5z"/>
                            </svg>
                                <span :class="{'sidebar-text': true}" class="ml-2" x-show="open">Home</span>
                            </a>
                        </li>

                        <div x-data="{ openItems: true }">
                            <li>
                                <a href="#" @click.prevent="openItems = !openItems" class="flex items-center justify-between px-4 py-2 text-gray-100 hover:bg-gray-700">
                                    <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z"/>
                                    </svg>

                                        <span :class="{'sidebar-text': true}" class="ml-2" x-show="open">Items</span>
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 ml-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/>
                                    </svg>
                                </a>
                                <ul x-show="openItems" class="pl-4 space-y-1">
                                    <li>
                                        <a href="{{ route('admin.items.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700">
                                            <span :class="{'sidebar-text': true}" class="ml-4"  x-show="open">All items</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.items.categories') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700">
                                            <span :class="{'sidebar-text': true}" class="ml-4"  x-show="open">Categories</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </div>

                        <li>
                            <a href="{{ route('admin.discuss') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-6.24-.402c-2.05.266-4.002.728-5.873 1.377a2.127 2.127 0 0 0-2.76 2.735v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194v4.622l4.155-4.155"/>
                            </svg>
                                <span :class="{'sidebar-text': true}" class="ml-2" x-show="open">Discuss</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 21v-1.125c0-1.657-1.343-3-3-3h-3c-1.657 0-3 1.343-3 3V21m3-11.25h-.008v.008H12v-.008m-4.5 0H7.492v.008H7.5v-.008M18 10.5c0 3-1.5 5.25-6 5.25s-6-2.25-6-5.25 1.5-5.25 6-5.25 6 2.25 6 5.25z"/>
                            </svg>
                                <span :class="{'sidebar-text': true}" class="ml-2" x-show="open">Users</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.743 3.607a1.125 1.125 0 0 1 2.514 0l.075.177a6.375 6.375 0 0 1 3.25 1.045l.133.113a1.125 1.125 0 0 1 .208 1.333l-.066.132a6.375 6.375 0 0 1 1.305 1.435l.097.15a1.125 1.125 0 0 1-.083 1.35l-.123.093a6.375 6.375 0 0 1 .455 1.486l.013.072a1.125 1.125 0 0 1-1.226 1.226l-.072-.013a6.375 6.375 0 0 1-1.486.455l-.093.123a1.125 1.125 0 0 1-1.35-.083l-.15-.097a6.375 6.375 0 0 1-1.435 1.305l-.132-.066a1.125 1.125 0 0 1-1.333.208l-.113-.133a6.375 6.375 0 0 1-1.045 3.25l-.177.075a1.125 1.125 0 0 1-1.35-.083l-.097-.15a6.375 6.375 0 0 1-1.305-1.435l-.066-.132a1.125 1.125 0 0 1-.208-1.333l.113-.133a6.375 6.375 0 0 1-1.045-3.25l-.075-.177a1.125 1.125 0 0 1 .083-1.35l.15-.097a6.375 6.375 0 0 1 1.435-1.305l.132-.066a1.125 1.125 0 0 1 1.333-.208l.113.133a6.375 6.375 0 0 1 3.25-1.045l.177-.075zM12 9.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5z"/>
                            </svg>
                                <span :class="{'sidebar-text': true}" class="ml-2" x-show="open">Settings</span>
                            </a>
                        </li>
                    </ul>

                    <ul>
                        <div x-data="{ openMisc: true }">
                            <li>
                                <a href="#" @click.prevent="openMisc = !openMisc" class="flex items-center justify-between px-4 py-2 text-gray-100 hover:bg-gray-700">
                                    <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/>
                                    </svg>

                                        <span :class="{'sidebar-text': true}" class="ml-2" x-show="open">Misc</span>
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 ml-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/>
                                    </svg>
                                </a>
                                <ul x-show="openMisc" class="pl-4 space-y-1">
                                    <li>
                                        <a href="{{ route('currencies.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700">
                                            <span :class="{'sidebar-text': true}" class="ml-4"  x-show="open">Currencies</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </div>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 bg-white p-6">
            @yield('content')
        </div>
    </div>

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
