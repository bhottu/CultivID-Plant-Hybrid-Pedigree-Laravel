<!-- Compact Header for Mobile/Tablet -->
<header class="safe-area-top bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="flex items-center justify-between h-14 px-4">
        <!-- Logo/Brand -->
        <a href="{{ route('home') }}" class="flex items-center flex-1">
            @if (isset($settings) && $settings->logo)
                <img class="h-8 w-auto rounded-md" src="{{ Storage::url($settings->logo) }}" alt="Logo">
            @else
                <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $settings->website_name ?? 'App' }}</span>
            @endif
        </a>
        
        <!-- Actions -->
        <div class="flex items-center gap-2">
            <!-- Search Button -->
            @auth
                <button id="search-btn" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-gray-700 dark:text-gray-300" title="Search">
                    <i class="fas fa-search w-5 h-5"></i>
                </button>
                
                <!-- Create Button -->
                <button id="create-btn" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-gray-700 dark:text-gray-300" title="Create">
                    <i class="fas fa-plus w-5 h-5"></i>
                </button>
            @endauth
            
            <!-- Dark Mode Toggle -->
            <button class="dark-mode-toggle p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-gray-700 dark:text-gray-300" title="Toggle Dark Mode">
                <i class="fas fa-moon w-5 h-5"></i>
            </button>
            
            <!-- User Menu -->
            @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-gray-700 dark:text-gray-300">
                        <i class="fas fa-user w-5 h-5"></i>
                    </button>
                    
                    <div @click.away="open = false" x-show="open" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                        <a href="{{ route('profile', ['user' => Auth::user()->id]) }}" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
                            <p class="font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">@{{ Auth::user()->username }}</p>
                        </a>
                        <a href="{{ route('profile', ['user' => Auth::user()->id]) }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="fas fa-user mr-2"></i> My Profile
                        </a>
                        <a href="{{ route('settings') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="fas fa-cog mr-2"></i> Settings
                        </a>
                        <button onclick="document.getElementById('logout-form').submit()" class="w-full text-left px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </div>
                </div>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}" class="px-3 py-1 text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400">Login</a>
            @endauth
        </div>
    </div>
    
    <!-- Search Bar (Hidden by default) -->
    <div id="search-bar" class="hidden border-t border-gray-200 dark:border-gray-700 p-3 bg-gray-50 dark:bg-gray-700">
        <form action="{{ route('search') }}" method="GET" class="flex gap-2">
            <input type="text" name="query" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search posts, plants, users..." required>
            <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</header>

<!-- Create Menu (Action Sheet) -->
<div id="create-menu" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50" @click="$el.classList.add('hidden')">
    <div class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 rounded-t-3xl max-h-96 overflow-y-auto" @click.stop>
        <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Create</h3>
            <button onclick="document.getElementById('create-menu').classList.add('hidden')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            <!-- Create Post -->
            <a href="#" onclick="event.preventDefault(); openCreatePostModal()" class="flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-400">
                    <i class="fas fa-pen-fancy"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white">Create Post</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Share your thoughts</p>
                </div>
            </a>
            
            <!-- Upload Plant -->
            <a href="{{ route('plant-submissions.create') }}" class="flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-600 dark:text-green-400">
                    <i class="fas fa-leaf"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white">Submit Plant</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Identify new species</p>
                </div>
            </a>
            
            <!-- Create Collection -->
            <a href="#" class="flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center text-purple-600 dark:text-purple-400">
                    <i class="fas fa-heart"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white">Create Collection</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Curate your favorites</p>
                </div>
            </a>
        </div>
    </div>
</div>

<script>
    document.getElementById('search-btn')?.addEventListener('click', function() {
        document.getElementById('search-bar').classList.toggle('hidden');
    });
    
    document.getElementById('create-btn')?.addEventListener('click', function() {
        document.getElementById('create-menu').classList.toggle('hidden');
    });
</script>
