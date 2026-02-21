
@extends('layouts.app')

@section('title', $post->caption)

@php
    $photos = json_decode($post->image, true);

    if (!empty($photos) && isset($photos[0])) {
        $ogImage = asset('storage/' . $photos[0]);
    } else {
        $imageDecoded = json_decode($post->image, true);
        if (is_array($imageDecoded) && isset($imageDecoded[0])) {
            $ogImage = asset('storage/' . $imageDecoded[0]);
        } elseif ($post->image) {
            $ogImage = asset('storage/' . $post->image);
        } else {
            $ogImage = asset('images/og-default.jpg');
        }
    }
@endphp

@section('og_image', $ogImage)

@section('og_description',
    \Illuminate\Support\Str::limit(
        strip_tags($post->caption ?? ''),
        155
    )
)

@section('content')


    <div class="container mx-auto max-w-lg p-4">
            @if ($post->image)
                <img onclick="showImageModal('{{ asset('storage/' . $post->image) }}')" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->caption }}" class="w-full rounded h-64 object-cover cursor-pointer">
            @endif
        <div class="bg-white rounded-lg overflow-hidden shadow-lg p-4">
            <p class="mt-2">{{ $post->caption }}</p>
            
            <div class="flex mt-4 items-center">
                            @if($post->user->profile_photo_path)
                                <img src="{{ asset('storage/' . $post->user->profile_photo_path) }}" alt="Profile Photo" class="h-10 w-10 rounded-full">
                                
                            @else
                                <img src="/storage/images/default.png" alt="Default Profile Photo" class="h-10 w-10 rounded-full">
                            @endif
                    <div class="ml-2">
                        <span class="font-semibold"><a href="{{ route('profile', $post->user->username) }}">
                        {{ $post->user->name }}</a></span>
                        <div class="text-gray-500 text-xs">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                </div>
        </div>

        <div class="flex mt-4 w-full">
            <button onclick="toggleLike({{ $post->id }}, this)" 
                class="flex-1 border hover:bg-blue-100 text-gray hover:text-blue font-bold py-2 px-4 rounded-l-lg focus:outline-none focus:shadow-outline flex items-center justify-center h-full like-btn-{{ $post->id }} {{ Auth::check() && $post->likes->contains('user_id', Auth::id()) ? 'text-red-500' : '' }}">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                <span class="likes-count-{{ $post->id }}">{{ $post->likes->count() }} </span>
            </button>

            <div class="flex-1">
                <button type="button"
                    onclick="sharePost()"
                    class="w-full text-gray hover:bg-blue-100 border font-bold py-2 px-4 rounded-r-lg focus:outline-none focus:shadow-outline flex items-center justify-center h-full">
                    
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3.684 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                    </svg>
                </button>
            </div>

            {{-- tombol share ke profil
            <form action="{{ route('post.share', ['post' => $post->id]) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit"
                    class="w-full text-gray hover:bg-blue-100 border font-bold py-2 px-4 rounded-r-lg focus:outline-none focus:shadow-outline flex items-center justify-center h-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                    </svg>
                    
                </button>
            </form>
            --}}
        </div>


             <div class="mt-4">
                <div class="flex items-center border border-gray-300 rounded-md">
                    <textarea id="commentContent" cols="30" rows="1" placeholder="Tulis komentar..." class="w-full p-2 resize-none focus:outline-none"></textarea>
                    <button onclick="submitComment({{ $post->id }})" class="ml-2 hover:bg-blue-100 border text-gray font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline flex items-center">
                        <svg class="w-5 h-5" style="transform: rotate(90deg);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </div>
             </div>

             <div id="commentsContainer" class="mt-4">
                @if($post->comments->count() > 0)
                    <h4 class="font-semibold mb-3">Comments:</h4>
                    @foreach($post->comments as $comment)
                        <div class="border-t border-gray-200 mt-2 pt-2">
                            <p>{{ $comment->content }}</p>
                            <p class="text-sm text-gray-600"><a href="{{ route('profile', $comment->user->username) }}" class="font-bold hover:text-blue-600">{{ $comment->user->name }}</a> - <span class="text-xs">{{ $comment->created_at->diffForHumans() }}</span></p>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500 text-sm">No comments yet</p>
                @endif
             </div>
    </div>

    <!-- Modal Popout Foto Post -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">
        <div class="relative">
            <button onclick="closeImageModal()" class="absolute -top-6 -right-6 md:top-0 md:right-0 bg-gray-800 text-white rounded-full p-2 hover:bg-red-600 shadow-lg z-50" style="right: -2rem; top: -2rem;">
                <i class="fas fa-times"></i>
            </button>
            <img id="modalImage" src="" class="max-w-xs md:max-w-lg max-h-[80vh] rounded shadow-lg border-4 border-white" alt="Zoom Foto Post">
        </div>
    </div>
    
    <script>
        function showImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
        }
        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.getElementById('modalImage').src = '';
        }
        document.addEventListener('keydown', function(e) {
            if(e.key === 'Escape') closeImageModal();
        });

        // Toggle Like Function (AJAX)
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
                            countEl.textContent = data.likes_count ;
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

        // Submit Comment Function (AJAX)
        function submitComment(postId) {
            // Check if user is authenticated
            @if(!auth()->check())
                window.location.href = '{{ route("login") }}';
                return;
            @endif

            const textarea = document.getElementById('commentContent');
            const content = textarea.value.trim();

            if (!content) {
                alert('Please write a comment');
                return;
            }

            fetch(`/post/${postId}/comment`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ content: content })
            })
                .then(res => {
                    console.log('Comment response status:', res.status);
                    return res.json();
                })
                .then(data => {
                    console.log('Comment response data:', data);
                    
                    if (data.success) {
                        // Clear textarea
                        textarea.value = '';

                        // Add new comment to DOM
                        const commentsContainer = document.getElementById('commentsContainer');
                        
                        // Check if there's a "no comments" message
                        const noCommentsMsg = commentsContainer.querySelector('.text-gray-500');
                        if (noCommentsMsg) {
                            noCommentsMsg.remove();
                            // Add "Comments:" header
                            const header = document.createElement('h4');
                            header.className = 'font-semibold mb-3';
                            header.textContent = 'Comments:';
                            commentsContainer.appendChild(header);
                        }

                        // Create new comment element
                        const newCommentDiv = document.createElement('div');
                        newCommentDiv.className = 'border-t border-gray-200 mt-2 pt-2';
                        newCommentDiv.innerHTML = `
                            <p>${data.comment.content}</p>
                            <p class="text-sm text-gray-600"><a href="/profile/${data.comment.user_username}" class="font-bold hover:text-blue-600">${data.comment.user_name}</a> <span class="text-xs">on just now</span></p>
                        `;
                        
                        // Insert new comment right after header (at top)
                        const header = commentsContainer.querySelector('h4.font-semibold');
                        if (header && header.nextElementSibling) {
                            commentsContainer.insertBefore(newCommentDiv, header.nextElementSibling);
                        } else if (header) {
                            commentsContainer.appendChild(newCommentDiv);
                        } else {
                            commentsContainer.prepend(newCommentDiv);
                        }
                    } else {
                        console.error('Error from server:', data.message);
                        alert('Error: ' + data.message);
                    }
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                    alert('Error posting comment. Please try again.');
                });
        }

        // share mobile native 
        // function sharePost() {
        //    const shareData = {
        //        title: @json($post->caption),
        //        text: @json(\Illuminate\Support\Str::limit($post->caption, 100)),
        //        url: @json(url()->current())
        //    };

        //    if (navigator.share) {
        //        navigator.share(shareData)
        //            .catch(err => console.log('Share cancelled', err));
        //    } else {
        //        openShareFallback();
        //    }
        // }

        function sharePost() {
            const caption = @json($post->caption ?? '');

            const shareData = {
                title: caption && caption.trim() !== '' 
                    ? caption 
                    : 'Check out this post on CultivID 🌱',
                url: @json(url()->current())
            };

            if (caption && caption.trim() !== '') {
                shareData.text = caption.length > 100
                    ? caption.substring(0, 100) + '...'
                    : caption;
            }

            if (navigator.share) {
                navigator.share(shareData)
                    .catch(err => console.log('Share cancelled', err));
            } else {
                openShareFallback();
            }
        }


    </script>

</div>
@endsection
