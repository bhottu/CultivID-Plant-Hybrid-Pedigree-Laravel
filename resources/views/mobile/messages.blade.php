@extends('layouts.mobile')

@section('title', 'Messages - ' . config('app.name'))

@section('header')
<div class="h-full flex items-center justify-between px-4">
    <h1 class="text-xl font-bold text-gray-900 dark:text-white">Messages</h1>
    <button onclick="startNewMessage()" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
        <i class="fas fa-pen text-gray-600 dark:text-gray-400"></i>
    </button>
</div>
@endsection

@section('content')
<div class="p-4">
    <!-- Search Messages -->
    <div class="mb-4">
        <div class="relative">
            <input type="text" placeholder="Search conversations..." class="w-full px-4 py-3 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <i class="fas fa-search absolute right-4 top-3 text-gray-400"></i>
        </div>
    </div>
    
    @auth
    <!-- Conversations List -->
    <div class="space-y-2">
        <!-- Conversation 1 (Example) -->
        <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
            <div class="relative">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold">A</div>
                <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 rounded-full border-2 border-white dark:border-gray-900"></div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-gray-900 dark:text-white text-sm">Alice Johnson</p>
                <p class="text-xs text-gray-600 dark:text-gray-400 truncate">That Monstera looks amazing! Where did you get...</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500 dark:text-gray-400">2 min</p>
                <span class="inline-block px-2 py-1 mt-1 bg-blue-600 text-white text-xs rounded-full font-medium">1</span>
            </div>
        </a>
        
        <!-- Conversation 2 (Example) -->
        <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
            <div class="relative">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold">M</div>
                <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 rounded-full border-2 border-white dark:border-gray-900"></div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-gray-900 dark:text-white text-sm">Mike's Garden Shop</p>
                <p class="text-xs text-gray-600 dark:text-gray-400 truncate">Your order is on the way! 📦 Expected delivery...</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500 dark:text-gray-400">1 hour</p>
            </div>
        </a>
        
        <!-- Conversation 3 (Example) -->
        <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
            <div class="relative">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white font-bold">S</div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-gray-900 dark:text-white text-sm">Sarah's Plant Tips</p>
                <p class="text-xs text-gray-600 dark:text-gray-400 truncate">Check out the new propagation guide I posted!</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500 dark:text-gray-400">3 hours</p>
            </div>
        </a>
        
        <!-- Conversation 4 (Example) -->
        <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
            <div class="relative">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center text-white font-bold">E</div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-gray-900 dark:text-white text-sm">Emma's Plants & Seeds</p>
                <p class="text-xs text-gray-600 dark:text-gray-400 truncate">Thanks for buying! Leave a review when you get a chance</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500 dark:text-gray-400">Yesterday</p>
            </div>
        </a>
        
        <!-- Conversation 5 (Example) -->
        <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
            <div class="relative">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center text-white font-bold">D</div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-gray-900 dark:text-white text-sm">David's Cactus Collection</p>
                <p class="text-xs text-gray-600 dark:text-gray-400 truncate">Want to exchange some rare cactus varieties?</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500 dark:text-gray-400">2 days</p>
            </div>
        </a>
    </div>
    @else
    <!-- Not Authenticated -->
    <div class="flex flex-col items-center justify-center h-96 text-center">
        <i class="fas fa-envelope text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Sign in to message</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Connect with other plant enthusiasts</p>
        <a href="{{ route('login') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
            Sign In
        </a>
    </div>
    @endauth
</div>

<script>
function startNewMessage() {
    @auth
    window.location.href = '#'; // Implement new message modal
    @else
    window.location.href = "{{ route('login') }}";
    @endauth
}
</script>
@endsection
