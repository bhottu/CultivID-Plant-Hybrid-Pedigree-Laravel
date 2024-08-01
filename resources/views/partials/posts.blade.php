<!-- partials/posts.blade.php -->
@foreach($posts as $post)
    <div class="max-w-md mt-4 mx-auto bg-gray shadow-md rounded-md overflow-hidden">
        <div class="bg-white p-4 shadow-md mb-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    @if($post->user->profile_photo_path)
                        <img src="{{ asset('storage/' . $post->user->profile_photo_path) }}" alt="Profile Photo" class="h-10 w-10 rounded-full">
                    @else
                        <img src="/storage/images/default.png" alt="Default Profile Photo" class="h-10 w-10 rounded-full">
                    @endif
                    <div class="ml-2">
                        <span class="font-semibold">
                            <a href="{{ url('profile/' . $post->user->id) }}">
                              {{ $post->user->name }}
                            </a>
                        </span>
                        <div class="text-gray-500 text-xs">{{ $post->created_at->format('d M Y') }}</div>
                    </div>
                </div>

                @if(Auth::id() === $post->user_id)
                <div class="relative" x-data="{ isOpen: false }">
                    <button @click="isOpen = !isOpen" class="focus:outline-none">
                        <i class="fas fa-ellipsis-h text-gray-400 text-sm"></i>
                    </button>
                    <div x-show="isOpen" @click.away="isOpen = false" class="absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-md shadow-md py-1">
                        <a href="{{ route('post.edit', $post) }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Edit</a>
                        <form action="{{ route('post.destroy', $post) }}" method="POST" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="isOpen = false;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
            <h3 class="text-sm m-4 mb-3">{{ $post->caption }}</h3>
            @if($post->image)
                 <img 
                    id="post-image-{{ $post->id }}" 
                    src="{{ asset('storage/' . $post->image) }}" 
                    alt="Post Image" 
                    class="object-cover w-full h-full cursor-pointer post-image"
                    data-image-url="{{ asset('storage/' . $post->image) }}"
                    data-post-id="{{ $post->id }}">           
                @endif
            @include('components.ImagePopup', ['post' => $post])
            <div class="flex justify-between items-center mt-4">
                <div>
                    <p><i class="fas fa-heart text-red-700"></i> {{ $post->likes->count() }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <form action="{{ route('post.like', ['postId' => $post->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center space-x-1 hover:text-red-700 text-gray-700">
                            <i class="fas fa-heart"></i>
                            <span class="ml-1">Like</span>
                        </button>
                    </form>
                    <form action="{{ route('post.share', ['post' => $post->id]) }}" class="space-x-1 hover:text-blue-700 text-gray-700" method="POST">
                        @csrf
                        <button type="submit"><i class="fas fa-share-alt"></i> Share</button>
                    </form>
                </div>
            </div>
            
            <form action="{{ route('post.comment', ['post' => $post->id]) }}" method="POST" class="mt-4">
                @csrf
                <div class="flex items-center border border-gray-300 rounded-md p-2">
                    <textarea name="content" cols="30" rows="1" class="w-full resize-none focus:outline-none"></textarea>
                    <button type="submit" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-4 rounded focus:outline-none focus:shadow-outline"><i class="fas fa-paper-plane"></i></button>
                </div>
            </form>
            @if($post->comments->count() > 0)
                <div class="mt-4">
                    <h4 class="font-semibold">Comments:</h4>
                    @foreach($post->comments->take(3) as $comment)
                        <div class="border-t border-gray-200 mt-2 pt-2">
                            <p>{{ $comment->content }}</p>
                            <p class="text-sm text-gray-600">By {{ $comment->user->name }} on {{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                    <div class="mt-4">
                        <a href="{{ route('post.show', $post->id) }}" class="text-blue-500 hover:underline">View all comments</a>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endforeach
