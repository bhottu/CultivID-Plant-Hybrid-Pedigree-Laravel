<div class="h-full flex justify-around items-start pt-2">
    <!-- Home -->
    <a href="{{ route('home') }}" class="flex flex-col items-center justify-center gap-1 py-2 px-4 rounded-lg transition-colors {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
        <i class="fas fa-home text-xl"></i>
        <span class="text-xs font-medium">Home</span>
    </a>
    
    <!-- Explore -->
    <a href="{{ route('search') }}" class="flex flex-col items-center justify-center gap-1 py-2 px-4 rounded-lg transition-colors {{ request()->routeIs('search') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
        <i class="fas fa-compass text-xl"></i>
        <span class="text-xs font-medium">Explore</span>
    </a>
    
    <!-- Create -->
    @auth
    <button onclick="showCreateMenu()" class="flex flex-col items-center justify-center gap-1 py-2 px-4 rounded-lg text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
        <i class="fas fa-plus-circle text-xl"></i>
        <span class="text-xs font-medium">Create</span>
    </button>
    @endauth
    
    <!-- Messages -->
    <a href="{{ route('messages') ?? '#' }}" class="flex flex-col items-center justify-center gap-1 py-2 px-4 rounded-lg transition-colors {{ request()->routeIs('messages') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
        <i class="fas fa-envelope text-xl"></i>
        <span class="text-xs font-medium">Messages</span>
    </a>
    
    <!-- Profile -->
    @auth
    <a href="{{ route('profile', ['user' => Auth::user()->id]) }}" class="flex flex-col items-center justify-center gap-1 py-2 px-4 rounded-lg transition-colors {{ request()->routeIs('profile') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
        @if(Auth::user()->profile_photo)
            <img src="{{ Storage::url(Auth::user()->profile_photo) }}" alt="Profile" class="w-5 h-5 rounded-full object-cover">
        @else
            <i class="fas fa-user-circle text-xl"></i>
        @endif
        <span class="text-xs font-medium">Profile</span>
    </a>
    @else
    <a href="{{ route('login') }}" class="flex flex-col items-center justify-center gap-1 py-2 px-4 rounded-lg text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
        <i class="fas fa-sign-in-alt text-xl"></i>
        <span class="text-xs font-medium">Login</span>
    </a>
    @endauth
</div>

<script>
function showCreateMenu() {
    // Implementation: Show create menu modal
    console.log('Show create menu');
}
</script>
