<header>
    <nav class="bg-cus-500 p-3 border-b border-gray-200 dark:border-gray-700 shadow">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-2xl font-bold text-white" href="{{ route('admin.home') }}">
                Dashboard
            </a>
            <div class="flex space-x-4 items-center">
                <ul class="flex space-x-4">
                        @guest
                            <li><button id="dark-mode-toggle" class="text-gray-800 text-white"><i class="fas fa-toggle-on"></i></button></li>
                            <li><a class="hover:text-blue-500 text-gray-800 text-white" href="{{ route('login') }}">Login</a></li>
                            <li><a class="hover:text-blue-500 text-gray-800 text-white" href="{{ route('register') }}">Register</a></li>
                        @else
                            <li><button id="dark-mode-toggle" class="text-gray-800 text-white"><i class="fas fa-toggle-on"></i></button></li>
                            <li><a class="hover:text-blue-500 text-gray-800 text-white" href="{{ route('profile', ['user' => Auth::user()->username]) }}">{{ Auth::user()->name }}</a></li>
                            <li><a class="hover:text-blue-500 text-gray-800 text-white" href="{{ route('products.index') }}">Home</a></li>
                            <li>
                                <button id="search-toggle" class="hover:text-blue-500 text-gray-800 text-white">
                                    <i class="fas fa-search"></i>
                                </button>
                            </li>
                            <li><a class="hover:text-blue-500 text-gray-800 text-white" href="{{ route('profile.edit') }}" title="Settings"><i class="fas fa-cog"></i></a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="hover:text-red-500 text-gray-800 text-white" title="Logout"><i class="fas fa-sign-out-alt"></i></button></form>
                            </li>
                           
                        @endguest
                </ul>
            </div>
        </div>

        <!-- Search Form (Hidden by default) -->
        <div id="search-form" class="hidden bg-gray-800 p-4">
            <div class="container mx-auto">
                <form action="{{ route('search') }}" method="GET" class="flex items-center justify-center gap-2">
                    <input type="text" name="query" class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search products..." required>
                    <button type="submit" class="bg-blue-700 hover:bg-blue-700 text-white px-6 py-2 rounded-r-md font-medium transition duration-200 border-2 border-white">
                        Search
                    </button>
                    <button type="button" id="search-close" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md font-medium transition duration-200">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>
</header>

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
