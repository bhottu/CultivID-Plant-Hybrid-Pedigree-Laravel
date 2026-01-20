<!-- Bottom Navigation Bar (Mobile Only) -->
<nav class="bottom-nav lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 safe-area-bottom">
    <div class="flex justify-around items-stretch w-full h-full max-w-full">
        
        <!-- Home -->
        <a href="{{ route('home') }}" class="flex flex-col items-center justify-center flex-1 gap-1 py-2 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400 border-t-2 border-blue-600' : '' }}">
            <i class="fas fa-home text-xl"></i>
            <span class="text-xs font-medium">Home</span>
        </a>
        
        <!-- Explore/Search -->
        <a href="{{ route('search') }}" class="flex flex-col items-center justify-center flex-1 gap-1 py-2 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition {{ request()->routeIs('search') ? 'text-blue-600 dark:text-blue-400 border-t-2 border-blue-600' : '' }}">
            <i class="fas fa-compass text-xl"></i>
            <span class="text-xs font-medium">Explore</span>
        </a>
        
        <!-- Create -->
        <button id="bottom-create-btn" class="flex flex-col items-center justify-center flex-1 gap-1 py-2 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition">
            <i class="fas fa-circle-plus text-xl"></i>
            <span class="text-xs font-medium">Create</span>
        </button>
        
        <!-- Messages/Notifications -->
        <a href="{{ route('messages') ?? '#' }}" class="flex flex-col items-center justify-center flex-1 gap-1 py-2 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition {{ request()->routeIs('messages') ? 'text-blue-600 dark:text-blue-400 border-t-2 border-blue-600' : '' }}">
            <div class="relative">
                <i class="fas fa-bell text-xl"></i>
                @if(Auth::check() && Auth::user()->unreadNotifications()->count() > 0)
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">
                        {{ Auth::user()->unreadNotifications()->count() }}
                    </span>
                @endif
            </div>
            <span class="text-xs font-medium">Messages</span>
        </a>
        
        <!-- Profile -->
        <a href="{{ route('profile', ['user' => Auth::user()->id]) }}" class="flex flex-col items-center justify-center flex-1 gap-1 py-2 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition {{ request()->routeIs('profile') ? 'text-blue-600 dark:text-blue-400 border-t-2 border-blue-600' : '' }}">
            @if(Auth::user()->profile_photo)
                <img src="{{ Storage::url(Auth::user()->profile_photo) }}" alt="Profile" class="w-6 h-6 rounded-full object-cover">
            @else
                <i class="fas fa-user-circle text-xl"></i>
            @endif
            <span class="text-xs font-medium">Profile</span>
        </a>
        
    </div>
</nav>

<!-- Create Menu for Bottom Nav -->
<div id="bottom-create-menu" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50" @click="$el.classList.add('hidden')">
    <div class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 rounded-t-3xl max-h-96 overflow-y-auto pb-20" @click.stop>
        <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white dark:bg-gray-800">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">What's on your mind?</h3>
            <button onclick="document.getElementById('bottom-create-menu').classList.add('hidden')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            <!-- Create Post -->
            <button onclick="event.preventDefault(); openCreatePostModal(); document.getElementById('bottom-create-menu').classList.add('hidden')" class="w-full flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-left">
                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-400 flex-shrink-0">
                    <i class="fas fa-pen-fancy"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white">Create Post</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Share a thought or photo</p>
                </div>
            </button>
            
            <!-- Upload Plant -->
            <a href="{{ route('plant-submissions.create') }}" class="w-full flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-left">
                <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-600 dark:text-green-400 flex-shrink-0">
                    <i class="fas fa-leaf"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white">Submit Plant</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Identify a plant species</p>
                </div>
            </a>
            
            <!-- Share Location -->
            <button onclick="event.preventDefault(); openLocationModal(); document.getElementById('bottom-create-menu').classList.add('hidden')" class="w-full flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-left">
                <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center text-red-600 dark:text-red-400 flex-shrink-0">
                    <i class="fas fa-map-pin"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white">Share Location</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Find plants nearby</p>
                </div>
            </button>
            
            <!-- Add to Collection -->
            <button onclick="event.preventDefault(); openCollectionModal(); document.getElementById('bottom-create-menu').classList.add('hidden')" class="w-full flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-left">
                <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center text-purple-600 dark:text-purple-400 flex-shrink-0">
                    <i class="fas fa-heart"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white">Create Collection</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Organize your favorites</p>
                </div>
            </button>
        </div>
    </div>
</div>

<script>
    document.getElementById('bottom-create-btn')?.addEventListener('click', function() {
        document.getElementById('bottom-create-menu').classList.toggle('hidden');
    });
    
    // Close menu when clicking outside
    document.getElementById('bottom-create-menu')?.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
</script>
