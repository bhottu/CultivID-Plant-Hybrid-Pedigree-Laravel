

    <div class="container mx-auto max-w-lg px-4 my-4">
        @if(isset($user))
            <h1 class="text-2xl font-bold text-gray-800">
                {{ $user->name }}'s Posts
            </h1>
            <p class="text-sm text-gray-500">
                All posts uploaded by {{ '@' . $user->username }}
            </p>
        @else
            <h1 class="text-2xl font-bold text-gray-800">
                Communitys
            </h1>
            <p class="text-sm text-gray-500">
                Share, Discuss & Grow together.
            </p>
        @endif
    </div>
    
    @if($posts->count())
        @foreach($posts as $post)
        <div class=" mx-auto max-w-lg ">
            <div class="bg-white dark:bg-gray-800 shadow-md mb-3 rounded-lg">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-3 p-4">
                        @if($post->user->profile_photo_path)
                            <a href="{{ route('profile', $post->user->username) }}" hx-get="{{ route('profile', $post->user->username) }}" hx-target="#app-content" hx-push-url="true" class="w-10 h-10 rounded-full hover:opacity-80 transition">
                                <img src="{{ asset('storage/' . $post->user->profile_photo_path) }}" alt="Profile Photo" class="w-10 h-10 rounded-full">
                            </a>
                        @else
                            <a href="{{ route('profile', $post->user->username) }}" hx-get="{{ route('profile', $post->user->username) }}" hx-target="#app-content" hx-push-url="true" class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-sm hover:opacity-80 transition">
                                {{ strtoupper(substr($post->user->name, 0, 1)) }}
                            </a>
                        @endif
                        <div>
                            <a href="{{ route('profile', $post->user->username) }}" hx-get="{{ route('profile', $post->user->username) }}" hx-target="#app-content" hx-push-url="true" class="font-semibold text-gray-900 dark:text-white hover:text-blue-600">
                                {{ $post->user->name }}
                            </a>
                            <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                
                 @if($post->image)
                    <div class="relative">
                           <div class="relative" onclick="openImageModal('{{ Storage::url($post->image) }}')">

                                <img src="{{ Storage::url($post->image) }}" alt="{{ $post->caption }}" class="w-full h-64 object-cover">
                               
                             </div>
                        </div>
                    @endif
                
                <p class="text-gray-700 dark:text-gray-300 text-sm p-4">{{ $post->caption }}</p>
                
                <div class="flex gap-4 text-gray-600 dark:text-gray-400 text-sm p-4">
                    <button onclick="toggleLike({{ $post->id }}, this)" class="flex items-center gap-1 hover:text-red-500 transition like-btn-{{ $post->id }} {{ Auth::check() && $post->likes->contains('user_id', Auth::id()) ? 'text-red-500' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="likes-count-{{ $post->id }}">{{ $post->likes_count ?? 0 }}</span>
                    </button>
                    <a href="{{ route('post.show', $post->id) }}" class="flex items-center gap-1 hover:text-blue-500 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <span>{{ $post->comments_count ?? 0 }}</span>
                    </a>
                </div>
            </div>
            </div>
        @endforeach

        <!-- Load More Sentinel -->
        <div id="load-more" class="py-4">
            <div id="loading-spinner" class="hidden text-center">
                <i class="fas fa-spinner fa-spin text-gray-500"></i> Loading more posts...
            </div>
            <div id="no-more" class="hidden text-center text-gray-500">No more posts</div>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 dark:text-gray-400">No posts available</p>
        </div>
    @endif
</div>

<!-- Image Modal -->
<div id="imageModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-70 flex items-center justify-center p-4">
    <div class="relative max-w-2xl w-full">
        <img id="modalImage" src="" alt="Post" class="w-full rounded-lg">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white bg-black bg-opacity-50 p-2 rounded-full hover:bg-opacity-70">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

<script>
function openImageModal(imageSrc) {
    document.getElementById('imageModal').classList.remove('hidden');
    document.getElementById('modalImage').src = imageSrc;
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Close modal with Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeImageModal();
});

// Close modal when clicking outside image
document.getElementById('imageModal')?.addEventListener('click', (e) => {
    if (e.target.id === 'imageModal') closeImageModal();
});

function toggleLike(postId, button) {
    // Check if user is authenticated
    @if(!auth()->check())
        window.location.href = '{{ route("login") }}';
        return;
    @endif

    fetch(`/post/${postId}/like`, { 
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
        .then(res => {
            console.log('Response status:', res.status);
            return res.json();
        })
        .then(data => {
            console.log('Response data:', data);
            
            if (data.success) {
                const countEl = document.querySelector(`.likes-count-${postId}`);
                if (countEl) {
                    countEl.textContent = data.likes_count;
                }
                
                // Toggle red color for liked state
                if (data.liked) {
                    button.classList.add('text-red-500');
                } else {
                    button.classList.remove('text-red-500');
                }
            } else {
                console.error('Error from server:', data.message);
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            }
        })
        .catch(err => {
            console.error('Fetch error:', err);
            alert('Error liking post. Please try again.');
        });
}

document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    let isLoading = false;
    let hasMorePages = {{ $posts->hasMorePages() ? 'true' : 'false' }};

    const loadMoreElement = document.getElementById('load-more');
    const loadingSpinner = document.getElementById('loading-spinner');
    const noMoreElement = document.getElementById('no-more');

    // Intersection Observer
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && hasMorePages && !isLoading) {
                loadNextPage();
            }
        });
    }, {
        rootMargin: '100px'
    });

    observer.observe(loadMoreElement);

    function loadNextPage() {
        if (isLoading || !hasMorePages) return;

        isLoading = true;
        loadingSpinner.classList.remove('hidden');
        noMoreElement.classList.add('hidden');

        const nextPage = currentPage + 1;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`{{ route('load.more') }}?page=${nextPage}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                // Append new posts
                const postsContainer = document.querySelector('.space-y-4');
                postsContainer.insertAdjacentHTML('beforeend', data.html);
                currentPage = nextPage;
                hasMorePages = data.hasMorePages;
            } else {
                hasMorePages = false;
                noMoreElement.classList.remove('hidden');
            }

            loadingSpinner.classList.add('hidden');
            isLoading = false;
        })
        .catch(error => {
            console.error('Error:', error);
            loadingSpinner.classList.add('hidden');
            isLoading = false;
        });
    }
});
</script>
