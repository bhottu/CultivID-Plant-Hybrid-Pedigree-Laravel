@extends('layouts.mobile')

@section('title', 'Explore - ' . config('app.name'))

@section('header')
@include('components.header')
@endsection

@section('content')
<div class="p-4">
    <!-- Search Bar -->
    <div class="mb-6">
        <div class="relative">
            <input type="text" placeholder="Search plants, people, posts..." class="w-full px-4 py-3 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <i class="fas fa-search absolute right-4 top-3 text-gray-400"></i>
        </div>
    </div>
    
    <!-- Category Filter -->
    <div class="mb-6 flex gap-2 overflow-x-auto pb-2">
        <button class="px-4 py-2 rounded-full bg-blue-600 text-white whitespace-nowrap font-medium text-sm">All</button>
        <button class="px-4 py-2 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white whitespace-nowrap font-medium text-sm hover:bg-gray-300 dark:hover:bg-gray-600">Plants</button>
        <button class="px-4 py-2 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white whitespace-nowrap font-medium text-sm hover:bg-gray-300 dark:hover:bg-gray-600">Products</button>
        <button class="px-4 py-2 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white whitespace-nowrap font-medium text-sm hover:bg-gray-300 dark:hover:bg-gray-600">People</button>
    </div>
    
    <!-- Featured Section -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Featured</h2>
        <div class="grid grid-cols-2 gap-4">
            <!-- Plant Card 1 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow border border-gray-200 dark:border-gray-700">
                <div class="aspect-square bg-gradient-to-br from-green-200 to-green-400 flex items-center justify-center">
                    <i class="fas fa-leaf text-5xl text-white"></i>
                </div>
                <div class="p-3">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Monstera Deliciosa</h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400">250+ posts</p>
                </div>
            </div>
            
            <!-- Plant Card 2 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow border border-gray-200 dark:border-gray-700">
                <div class="aspect-square bg-gradient-to-br from-blue-200 to-blue-400 flex items-center justify-center">
                    <i class="fas fa-clover text-5xl text-white"></i>
                </div>
                <div class="p-3">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Pothos</h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400">180+ posts</p>
                </div>
            </div>
            
            <!-- Plant Card 3 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow border border-gray-200 dark:border-gray-700">
                <div class="aspect-square bg-gradient-to-br from-yellow-200 to-yellow-400 flex items-center justify-center">
                    <i class="fas fa-flower text-5xl text-white"></i>
                </div>
                <div class="p-3">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Jade Plant</h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400">160+ posts</p>
                </div>
            </div>
            
            <!-- Plant Card 4 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow border border-gray-200 dark:border-gray-700">
                <div class="aspect-square bg-gradient-to-br from-purple-200 to-purple-400 flex items-center justify-center">
                    <i class="fas fa-leaf text-5xl text-white"></i>
                </div>
                <div class="p-3">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm">Snake Plant</h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400">200+ posts</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Trending Section -->
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Trending Posts</h2>
        <div class="space-y-4">
            <!-- Post Item 1 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm">J</div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 dark:text-white text-sm">John Gardener</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">2 hours ago</p>
                    </div>
                    <button class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full">
                        <i class="fas fa-ellipsis-h text-gray-600 dark:text-gray-400"></i>
                    </button>
                </div>
                <p class="text-sm text-gray-700 dark:text-gray-300 mb-3">Just propagated my Monstera! 🌿 Here's the step-by-step guide on how to do it successfully.</p>
                <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700 pt-3">
                    <button class="flex items-center gap-1 hover:text-red-600 dark:hover:text-red-400">
                        <i class="fas fa-heart"></i> <span>234 Likes</span>
                    </button>
                    <button class="flex items-center gap-1 hover:text-blue-600 dark:hover:text-blue-400">
                        <i class="fas fa-comment"></i> <span>45 Comments</span>
                    </button>
                    <button class="flex items-center gap-1 hover:text-green-600 dark:hover:text-green-400">
                        <i class="fas fa-share"></i> <span>12 Shares</span>
                    </button>
                </div>
            </div>
            
            <!-- Post Item 2 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold text-sm">S</div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 dark:text-white text-sm">Sarah's Garden</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">4 hours ago</p>
                    </div>
                    <button class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full">
                        <i class="fas fa-ellipsis-h text-gray-600 dark:text-gray-400"></i>
                    </button>
                </div>
                <p class="text-sm text-gray-700 dark:text-gray-300 mb-3">Selling premium Pothos cuttings! DM for details and bulk discounts available 🎉</p>
                <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700 pt-3">
                    <button class="flex items-center gap-1 hover:text-red-600 dark:hover:text-red-400">
                        <i class="fas fa-heart"></i> <span>156 Likes</span>
                    </button>
                    <button class="flex items-center gap-1 hover:text-blue-600 dark:hover:text-blue-400">
                        <i class="fas fa-comment"></i> <span>32 Comments</span>
                    </button>
                    <button class="flex items-center gap-1 hover:text-green-600 dark:hover:text-green-400">
                        <i class="fas fa-share"></i> <span>8 Shares</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
