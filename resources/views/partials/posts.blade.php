@foreach($posts as $post)
    {{-- Container utama --}}
    <div class="flex items-center bg-white p-2 border-b border-gray-100 hover:bg-gray-50 transition-all w-full text-left">
        
        <div class="flex-shrink-0 mr-4">
            {{-- W-14 H-14 memastikan kotak sempurna (56px) --}}
            <div class="flex-shrink-0 mr-4" style="width: 56px; height: 56px;">
                <div class="relative rounded-lg overflow-hidden border border-gray-200 shadow-sm bg-gray-100" 
                    style="width: 100%; height: 100%;">
                    
                    @if($post->image)
                        <img onclick="openImageModal('{{ Storage::url($post->image) }}')" 
                            src="{{ Storage::url($post->image) }}" 
                            alt="Post Image" 
                            {{-- Style ini memaksa gambar tetap kotak tanpa peduli class lain --}}
                            style="width: 100% !important; height: 100% !important; object-fit: cover !important; display: block !important;">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-[9px] text-gray-400">
                            Text
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex-grow min-w-0 text-left">
            <a href="{{ route('post.show', $post->id) }}" class="block">
                <h4 class="text-sm text-gray-700 truncate leading-tight mb-1">
                    {{ \Illuminate\Support\Str::limit($post->caption, 30) }}
                </h4>
            </a>
            
            <div class="flex items-center gap-3 text-[10px] text-gray-500 italic">
                <span class="flex items-center gap-1">
                    <i class="far fa-clock"></i>
                    {{ $post->created_at->diffForHumans() }}
                </span>
                <span class="flex items-center gap-1">
                    <i class="far fa-comment"></i>
                    {{ $post->comments->count() }}
                </span>
                <button onclick="toggleLike({{ $post->id }}, this)" 
                        class="flex items-center gap-1 hover:text-red-500 transition {{ Auth::check() && Auth::user()->likes()->where('post_id', $post->id)->exists() ? 'text-red-500' : '' }}">
                    <i class="fas fa-heart"></i>
                    <span class="likes-count-{{ $post->id }} text-[10px]">{{ $post->likes->count() }}</span>
                </button>
            </div>
        </div>

        <div class="flex-shrink-0 ml-auto pl-2">
            <i class="fas fa-chevron-right text-gray-200 text-[10px]"></i>
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
