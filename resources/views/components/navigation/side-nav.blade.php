<!-- Desktop Sidebar Navigation -->
<aside class="hidden lg:fixed lg:left-0 lg:top-0 lg:z-50 lg:w-64 lg:h-screen lg:flex lg:flex-col bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 pt-20">
    
    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto px-4 py-6">
        <div class="space-y-2">
            
            <!-- Home -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition {{ request()->routeIs('home') ? 'bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                <i class="fas fa-home w-5"></i>
                <span>Home</span>
            </a>
            
            <!-- Explore -->
            <a href="{{ route('search') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition {{ request()->routeIs('search') ? 'bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                <i class="fas fa-compass w-5"></i>
                <span>Explore</span>
            </a>
            
            <!-- Notifications -->
            <a href="{{ route('messages') ?? '#' }}" class="flex items-center justify-between gap-3 px-4 py-3 rounded-lg font-medium transition {{ request()->routeIs('messages') ? 'bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-bell w-5"></i>
                    <span>Notifications</span>
                </div>
                @if(Auth::user()->unreadNotifications()->count() > 0)
                    <span class="bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">
                        {{ Auth::user()->unreadNotifications()->count() }}
                    </span>
                @endif
            </a>
            
            <!-- Messages -->
            <a href="{{ route('messages') ?? '#' }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-envelope w-5"></i>
                <span>Messages</span>
            </a>
            
            <!-- Bookmarks -->
            <a href="{{ route('bookmarks') ?? '#' }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-bookmark w-5"></i>
                <span>Bookmarks</span>
            </a>
            
            <!-- Plants -->
            <a href="{{ route('plants.index') ?? '#' }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition {{ request()->routeIs('plants*') ? 'bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                <i class="fas fa-leaf w-5"></i>
                <span>Plants</span>
            </a>
            
            <!-- Products -->
            <a href="{{ route('products.index') ?? '#' }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition {{ request()->routeIs('products*') ? 'bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                <i class="fas fa-shopping-bag w-5"></i>
                <span>Products</span>
            </a>
            
        </div>
        
        <!-- Categories Section -->
        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
            <h3 class="px-4 py-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Categories</h3>
            <div class="space-y-1 mt-3">
                @foreach(['Vegetables', 'Fruits', 'Herbs', 'Flowers', 'Trees'] as $category)
                    <a href="{{ route('search', ['category' => $category]) }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <span>{{ $category }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </nav>
    
    <!-- User Card at Bottom -->
    <div class="border-t border-gray-200 dark:border-gray-700 p-4">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-lg p-4">
            <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">{{ Auth::user()->name }}</p>
            <p class="text-xs text-gray-600 dark:text-gray-400 mb-3">@{{ Auth::user()->username }}</p>
            
            <div class="space-y-2">
                <a href="{{ route('profile', ['user' => Auth::user()->id]) }}" class="block w-full text-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                    View Profile
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition border border-gray-200 dark:border-gray-600">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
    
</aside>
