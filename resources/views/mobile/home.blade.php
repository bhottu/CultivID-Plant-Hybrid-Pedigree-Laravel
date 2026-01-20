@extends('layouts.mobile')

@section('header')
@include('components.header')
@endsection

@section('content')
<div class="p-4 space-y-4">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Home</h1>
        <p class="text-gray-600 dark:text-gray-400">Welcome back</p>
    </div>
    
    <!-- Posts Feed -->
    @if($posts ?? false)
        <div id="posts-container" class="space-y-4">
            @foreach($posts as $post)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border border-gray-200 dark:border-gray-700">
                <!-- Post Header -->
                <div class="flex items-center gap-3 mb-3">
                    @if($post->user->profile_photo)
                        <img src="{{ Storage::url($post->user->profile_photo) }}" alt="{{ $post->user->name }}" class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gray-300 dark:bg-gray-600"></div>
                    @endif
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $post->user->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                
                <!-- Post Content -->
                <p class="text-gray-700 dark:text-gray-300 mb-3">{{ Str::limit($post->content, 200) }}</p>
                
                <!-- Post Image -->
                @if($post->images && count($post->images) > 0)
                <div class="mb-3 rounded-lg overflow-hidden bg-gray-200 dark:bg-gray-700 h-48">
                    <img src="{{ Storage::url($post->images[0]->path) }}" alt="Post image" class="w-full h-full object-cover">
                </div>
                @endif
                
                <!-- Post Actions -->
                <div class="flex justify-around text-sm text-gray-600 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700 pt-3 mt-3">
                    <button class="flex items-center gap-2 hover:text-red-600 dark:hover:text-red-400">
                        <i class="fas fa-heart"></i>
                        <span>Like</span>
                    </button>
                    <a href="{{ route('posts.show', $post) }}" class="flex items-center gap-2 hover:text-blue-600 dark:hover:text-blue-400">
                        <i class="fas fa-comment"></i>
                        <span>Comment</span>
                    </a>
                    <button class="flex items-center gap-2 hover:text-green-600 dark:hover:text-green-400">
                        <i class="fas fa-share"></i>
                        <span>Share</span>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center h-96 text-center">
            <i class="fas fa-inbox text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No posts yet</h2>
            <p class="text-gray-600 dark:text-gray-400">Follow users to see their posts</p>
        </div>
    @endif
</div>
@endsection
