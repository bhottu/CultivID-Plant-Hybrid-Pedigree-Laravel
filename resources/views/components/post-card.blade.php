<!-- Post Card Component -->
<!-- Usage: @include('components.post-card', ['post' => $post]) -->

<div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
    <!-- Post Header -->
    <div class="p-4 flex items-center justify-between border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-3">
            @if($post->user->profile_photo ?? false)
                <img src="{{ Storage::url($post->user->profile_photo) }}" alt="{{ $post->user->name }}" class="w-10 h-10 rounded-full object-cover">
            @else
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm">
                    {{ substr($post->user->name, 0, 1) }}
                </div>
            @endif
            <div>
                <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $post->user->name }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
            </div>
        </div>
        <button class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full text-gray-600 dark:text-gray-400">
            <i class="fas fa-ellipsis-h"></i>
        </button>
    </div>
    
    <!-- Post Content -->
    <div class="p-4">
        <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
            {{ Str::limit($post->content ?? '', 200) }}
        </p>
        
        <!-- Post Image(s) -->
        @if($post->images && count($post->images) > 0)
            @if(count($post->images) == 1)
                <div class="mt-3 rounded-lg overflow-hidden bg-gray-200 dark:bg-gray-700">
                    <img src="{{ Storage::url($post->images[0]->path) }}" alt="Post image" class="w-full h-auto">
                </div>
            @else
                <div class="mt-3 grid grid-cols-2 gap-1">
                    @foreach($post->images->take(4) as $index => $image)
                        @if($index == 3 && count($post->images) > 4)
                            <div class="relative overflow-hidden rounded-lg bg-gray-200 dark:bg-gray-700">
                                <img src="{{ Storage::url($image->path) }}" alt="Post image" class="w-full h-32 object-cover opacity-50">
                                <div class="absolute inset-0 flex items-center justify-center text-white font-bold text-2xl">
                                    +{{ count($post->images) - 3 }}
                                </div>
                            </div>
                        @else
                            <div class="overflow-hidden rounded-lg bg-gray-200 dark:bg-gray-700">
                                <img src="{{ Storage::url($image->path) }}" alt="Post image" class="w-full h-32 object-cover">
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        @endif
    </div>
    
    <!-- Post Stats -->
    <div class="px-4 py-2 flex items-center justify-between text-xs text-gray-600 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700">
        <span>{{ $post->likes_count ?? 0 }} Likes</span>
        <span>{{ $post->comments_count ?? 0 }} Comments</span>
        <span>{{ $post->shares_count ?? 0 }} Shares</span>
    </div>
    
    <!-- Post Actions -->
    <div class="px-2 py-2 flex justify-around border-t border-gray-200 dark:border-gray-700">
        <button class="flex-1 flex items-center justify-center gap-2 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded transition-colors">
            <i class="fas fa-heart"></i>
            <span>Like</span>
        </button>
        <a href="{{ route('posts.show', $post) ?? '#' }}" class="flex-1 flex items-center justify-center gap-2 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded transition-colors">
            <i class="fas fa-comment"></i>
            <span>Comment</span>
        </a>
        <button class="flex-1 flex items-center justify-center gap-2 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 rounded transition-colors">
            <i class="fas fa-share"></i>
            <span>Share</span>
        </button>
    </div>
</div>
