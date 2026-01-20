@foreach($posts as $post)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
        <div class="flex justify-between items-start mb-3">
            <div class="flex items-center gap-3">
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
                    <div class="mb-3 rounded-lg overflow-hidden cursor-pointer" onclick="openImageModal('{{ Storage::url($post->image) }}')">
                        <img src="{{ Storage::url($post->image) }}" alt="Post" class="w-full object-cover max-h-80 hover:opacity-90 transition">
                    </div>
                @endif
                
                <p class="text-gray-700 dark:text-gray-300 text-sm mb-3">{{ $post->caption }}</p>
        
            <div class="flex gap-4 text-gray-600 dark:text-gray-400 text-sm">
                <button onclick="toggleLike({{ $post->id }}, this)" class="flex items-center gap-1 hover:text-red-500 transition like-btn-{{ $post->id }} {{ Auth::check() && Auth::user()->likes()->where('post_id', $post->id)->exists() ? 'text-red-500' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span class="likes-count-{{ $post->id }}">{{ $post->likes->count() }}</span>
                </button>
                <!-- <button onclick="toggleShare({{ $post->id }}, this)" class="flex items-center gap-1 hover:text-blue-500 transition share-btn-{{ $post->id }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                    </svg>
                    <span class="shares-count-{{ $post->id }}">{{ $post->shares->count() }}</span>
                </button> -->
                <a href="{{ route('post.show', $post->id) }}" class="flex items-center gap-1 hover:text-blue-500 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <span>{{ $post->comments->count() }}</span>
                </a>
            </div>
            
            
    </div>
@endforeach

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

function toggleShare(postId, button) {
    // Check if user is authenticated
    @if(!auth()->check())
        window.location.href = '{{ route("login") }}';
        return;
    @endif

    fetch(`/post/${postId}/share`, { 
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
                const countEl = document.querySelector(`.shares-count-${postId}`);
                if (countEl) {
                    countEl.textContent = data.shares_count;
                }
                
                // Optionally, change color or something for shared state
                button.classList.add('text-blue-500');
                setTimeout(() => button.classList.remove('text-blue-500'), 1000);
            } else {
                console.error('Error from server:', data.message);
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            }
        })
        .catch(err => {
            console.error('Fetch error:', err);
            alert('Error sharing post. Please try again.');
        });
}
</script>
