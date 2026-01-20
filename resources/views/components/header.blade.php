<div class="h-full flex items-center justify-between px-4">
    <!-- Logo -->
    <div class="flex items-center gap-3">
        @if (isset($settings) && $settings->logo)
            <img src="{{ Storage::url($settings->logo) }}" alt="Logo" class="h-8 w-auto rounded">
        @else
            <span class="font-bold text-gray-900 dark:text-white">{{ $settings->website_name ?? 'App' }}</span>
        @endif
    </div>
    
    <!-- Header Actions -->
    <div class="flex items-center gap-4">
        @auth
            <button onclick="toggleSearch()" class="p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-search"></i>
            </button>
            <button onclick="toggleCreate()" class="p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-plus"></i>
            </button>
            <button onclick="toggleDarkMode()" class="p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-moon"></i>
            </button>
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    <i class="fas fa-user"></i>
                </button>
                <div @click.away="open = false" x-show="open" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-lg shadow-lg border border-gray-200 dark:border-gray-600 z-50">
                    <a href="{{ route('profile', ['user' => Auth::user()->id]) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Profile</a>
                    <form action="{{ route('logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-red-600 dark:text-red-400">Logout</button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Login</a>
        @endauth
    </div>
</div>

<script>
function toggleDarkMode() {
    const isDark = document.documentElement.classList.contains('dark');
    const newMode = isDark ? 'light' : 'dark';
    
    fetch('/api/dark-mode', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ mode: newMode })
    }).then(() => location.reload());
}

function toggleSearch() {
    console.log('Search toggled');
}

function toggleCreate() {
    console.log('Create menu toggled');
}
</script>
