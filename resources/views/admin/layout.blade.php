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
            display: none; 
        }
        .sidebar-open .sidebar-text {
            display: inline; 
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
        <div x-data="{ open: false }" x-bind:class="{'sidebar-open': open}" class="relative flex">
            <div :class="{'w-64': open, 'w-16': !open}" class="bg-gray-800 text-white flex flex-col transition-width duration-300">
                <!-- Toggle Button -->
                <button @click="open = !open" class="absolute top-4 left-4 text-white-600 dark:text-gray-300 z-10 flex items-center space-x-2 p-2  dark:bg-gray-700 rounded-lg" title="Open Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M3 12h18M3 18h18" />
                    </svg>
                   
                </button>


                <nav class="flex-1 px-2 py-4 bg-gray-800">
                    <ul class="space-y-2 pt-10">
                        <li>
                            <a href="{{ route('admin.home') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700" title="Home">
                            <i class="fas fa-home" ></i>
                                <span :class="{'sidebar-text': true}" class="ml-2" x-show="open">Home</span>
                            </a>
                        </li>

                        <div x-data="{ openItems: false }">
                            <li>
                                <a href="#" @click.prevent="openItems = !openItems" class="flex items-center justify-between px-4 py-2 text-gray-100 hover:bg-gray-700" title="Items">
                                    <span class="flex items-center">
                                    <i class="fas fa-box"></i>
                                        <span :class="{'sidebar-text': true}" class="ml-2" x-show="open">Items</span>
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 ml-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/>
                                    </svg>
                                </a>
                                <ul x-show="openItems" class="pl-4 space-y-1">
                                    <li>
                                        <a href="{{ route('admin.items.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700" title="All Items">
                                       - <span :class="{'sidebar-text': true}" class="ml-4"  x-show="open">All items</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.items.categories') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700" title="Categories">
                                           - <span :class="{'sidebar-text': true}" class="ml-4"  x-show="open">Categories</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </div>

                        <li>
                            <a href="{{ route('admin.payment.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700" title="PlantDB">
                            <i class="fa-solid fa-money-bill-transfer"></i>
                                <span :class="{'sidebar-text': true}" class="ml-2" x-show="open">Transactions</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.withdrawals.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700" title="PlantDB">
                            <i class="fa-solid fa-money-bill"></i>
                                <span :class="{'sidebar-text': true}" class="ml-2" x-show="open">Withdrawals</span>
                            </a>
                        </li>
                        

                        <li>
                            <a href="{{ route('admin.discuss') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700" title="Community">
                            <i class="fas fa-comments"></i>
                                <span :class="{'sidebar-text': true}" class="ml-2" x-show="open">Community</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700" title="Users">
                            <i class="fas fa-user"></i>
                                <span :class="{'sidebar-text': true}" class="ml-2" x-show="open">Users</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.plant-submissions.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700" title="PlantDB">
                            <i class="fas fa-seedling"></i>
                                <span :class="{'sidebar-text': true}" class="ml-2" x-show="open">Plant Database</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700" title="Settings">
                            <i class="fas fa-cog"></i>
                                <span :class="{'sidebar-text': true}" class="ml-2" x-show="open">Settings</span>
                            </a>
                        </li>
                    </ul>

                    <ul>
                        <div x-data="{ openMisc: false }">
                            <li>
                                <a href="#" @click.prevent="openMisc = !openMisc" class="flex items-center justify-between px-4 py-2 text-gray-100 hover:bg-gray-700" title="Miscellaneous">
                                    <span class="flex items-center">
                                    <i class="fas fa-th-large"></i>
                                        <span :class="{'sidebar-text': true}" class="ml-2" x-show="open">Misc</span>
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 ml-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/>
                                    </svg>
                                </a>
                                <ul x-show="openMisc" class="pl-4 space-y-1">
                                    <li>
                                        <a href="{{ route('currencies.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700" title="Currencies">
                                            - <span :class="{'sidebar-text': true}" class="ml-4"  x-show="open">Currencies</span>
                                        </a>
                                    </li>
                                </ul>
                                <ul x-show="openMisc" class="pl-4 space-y-1">
                                    <li>
                                        <a href="{{ route('google.settings') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700" title="Google Login Setting">
                                           - <span :class="{'sidebar-text': true}" class="ml-4"  x-show="open">Google Login Setting</span>
                                        </a>
                                    </li>
                                </ul>
                                <ul x-show="openMisc" class="pl-4 space-y-1">
                                    <li>
                                        <a href="{{ route('google.adsense.edit') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700" title="Google Adsense">
                                           - <span :class="{'sidebar-text': true}" class="ml-4"  x-show="open">Google Adsense</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </div>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="flex-1 bg-white p-6">
            @yield('content')
        </div>
    </div>

<script>

    @stack('scripts')
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
