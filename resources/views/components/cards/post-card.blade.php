<!-- Reusable Post Card Component -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition">
    
    <!-- Post Header -->
    <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-3">
            <!-- User Avatar -->
            <img src="{{ Storage::url($post->user->profile_photo ?? '') }}" alt="{{ $post->user->name }}" class="w-10 h-10 rounded-full object-cover bg-gray-200 dark:bg-gray-700">
            
            <!-- User Info -->
            <div class="min-w-0">
                <p class="font-semibold text-gray-900 dark:text-white truncate">
                    <a href="{{ route('profile', ['user' => $post->user->id]) }}" class="hover:underline">
                        {{ $post->user->name }}
                    </a>
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $post->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
        
        <!-- Post Menu -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition">
                <i class="fas fa-ellipsis-h text-gray-600 dark:text-gray-400"></i>
            </button>
            
            <div @click.away="open = false" x-show="open" class="absolute right-0 mt-1 w-40 bg-white dark:bg-gray-700 rounded-lg shadow-lg border border-gray-200 dark:border-gray-600 z-10">
                @if(Auth::id() === $post->user->id)
                    <a href="{{ route('posts.edit', $post) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 border-b border-gray-200 dark:border-gray-600">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                    <button onclick="deletePost({{ $post->id }})" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <i class="fas fa-trash mr-2"></i> Delete
                    </button>
                @else
                    <button class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 border-b border-gray-200 dark:border-gray-600">
                        <i class="fas fa-flag mr-2"></i> Report
                    </button>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Post Content -->
    <div class="p-4">
        <p class="text-gray-900 dark:text-white leading-relaxed mb-3">{{ Str::limit($post->content, 280) }}</p>
        
        <!-- Post Images -->
        @if($post->images && count($post->images) > 0)
            <div class="grid gap-2 mb-4 rounded-lg overflow-hidden" style="grid-template-columns: repeat({{ min(count($post->images), 4) }}, minmax(0, 1fr));">
                @foreach($post->images->take(4) as $index => $image)
                    <div class="aspect-square bg-gray-200 dark:bg-gray-700 overflow-hidden cursor-pointer group relative">
                        <img src="{{ Storage::url($image->path) }}" alt="Post image" class="w-full h-full object-cover group-hover:scale-110 transition">
                        
                        @if($index === 3 && count($post->images) > 4)
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                <span class="text-white font-semibold text-lg">+{{ count($post->images) - 4 }}</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    
    <!-- Post Stats -->
    <div class="flex justify-between items-center px-4 py-3 border-t border-gray-200 dark:border-gray-700 text-sm text-gray-600 dark:text-gray-400">
        <span><i class="fas fa-heart mr-1"></i> {{ $post->likes_count ?? 0 }} Likes</span>
        <span><i class="fas fa-comment mr-1"></i> {{ $post->comments_count ?? 0 }} Comments</span>
        <span><i class="fas fa-share mr-1"></i> {{ $post->shares_count ?? 0 }} Shares</span>
    </div>
    
    <!-- Post Actions -->
    <div class="flex gap-1 p-3 border-t border-gray-200 dark:border-gray-700">
        <button onclick="toggleLike({{ $post->id }})" class="flex-1 flex items-center justify-center gap-2 py-2 rounded-lg font-medium transition hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 {{ Auth::check() && Auth::user()->likes()->where('post_id', $post->id)->exists() ? 'text-red-600 dark:text-red-400' : '' }}">
            <i class="fas fa-heart"></i>
            <span class="hidden sm:inline">Like</span>
        </button>
        
        <a href="{{ route('posts.show', $post) }}" class="flex-1 flex items-center justify-center gap-2 py-2 rounded-lg font-medium transition hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
            <i class="fas fa-comment"></i>
            <span class="hidden sm:inline">Comment</span>
        </a>
        
        <button onclick="sharePost({{ $post->id }})" class="flex-1 flex items-center justify-center gap-2 py-2 rounded-lg font-medium transition hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
            <i class="fas fa-share"></i>
            <span class="hidden sm:inline">Share</span>
        </button>
        
        <button onclick="savePost({{ $post->id }})" class="flex-1 flex items-center justify-center gap-2 py-2 rounded-lg font-medium transition hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
            <i class="fas fa-bookmark"></i>
            <span class="hidden sm:inline">Save</span>
        </button>
    </div>
    
</div>

<script>
function toggleLike(postId) {
    if (!{{ Auth::check() ? 'true' : 'false' }}) {
        window.location.href = '{{ route("login") }}';
        return;
    }
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch(`/api/posts/${postId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => location.reload())
    .catch(error => console.error('Error:', error));
}

function sharePost(postId) {
    if (navigator.share) {
        navigator.share({
            title: 'Check out this post',
            url: `{{ url('/') }}/posts/${postId}`
        });
    }
}

function savePost(postId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch(`/api/posts/${postId}/save`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .catch(error => console.error('Error:', error));
}

function deletePost(postId) {
    if (confirm('Are you sure you want to delete this post?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch(`/api/posts/${postId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => location.reload())
        .catch(error => console.error('Error:', error));
    }
}
</script>
