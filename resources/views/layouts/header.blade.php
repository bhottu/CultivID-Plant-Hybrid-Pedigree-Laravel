<header>
    <nav class="bg-gray-800 p-6 border-b border-gray-200 dark:border-gray-700 shadow">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-2xl font-bold text-white" href="{{ route('admin.home') }}">
                Dashboard
            </a>
            <div class="flex space-x-4 items-center">
                <ul class="flex space-x-4">
                        @guest
                            <li><button id="dark-mode-toggle" class="text-gray-800 text-white"><i class="fas fa-toggle-on"></i></button></li>
                            <li><a class="hover:text-blue-500 text-gray-800 text-white" href="{{ route('index.sosmed') }}">Discuss</a></li>
                            <li><a class="hover:text-blue-500 text-gray-800 text-white" href="{{ route('products.index') }}">Products</a></li>
                            <li><a class="hover:text-blue-500 text-gray-800 text-white" href="{{ route('login') }}">Login</a></li>
                            <li><a class="hover:text-blue-500 text-gray-800 text-white" href="{{ route('register') }}">Register</a></li>
                        @else
                            <li><button id="dark-mode-toggle" class="text-gray-800 text-white"><i class="fas fa-toggle-on"></i></button></li>
                            <li><a class="hover:text-blue-500 text-gray-800 text-white" href="{{ route('profile', ['user' => Auth::user()->id]) }}">{{ Auth::user()->name }}</a></li>
                            <li><a class="hover:text-blue-500 text-gray-800 text-white" href="{{ route('products.index') }}">Home</a></li>
                            <li><a class="hover:text-blue-500 text-gray-800 text-white" href="{{ route('index.sosmed') }}">Discuss</a></li>
                            <li><a class="hover:text-blue-500 text-gray-800 text-white" href="{{ route('profile.edit') }}">Setting</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="hover:text-red-500 text-gray-800 text-white">Logout</button></form>
                            </li>
                           
                        @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>
