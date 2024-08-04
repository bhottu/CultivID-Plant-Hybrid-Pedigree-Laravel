
@extends('layouts.app')

@section('content')
    <div class="container mx-auto ">
            @if ($post->image)
                <img onclick="openImagePopup('{{ asset('storage/' . $post->image) }}', '{{ $post->id }}')" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->caption }}" class="w-full h-64 object-cover">
            @endif
            @include('components.ImagePopup', ['post' => $post])
        <div class="bg-white rounded-lg overflow-hidden shadow-lg p-4">
            <p class="mt-2">{{ $post->caption }}</p>
            
            <div class="flex mt-4 items-center">
                            @if($post->user->profile_photo_path)
                                <img src="{{ asset('storage/' . $post->user->profile_photo_path) }}" alt="Profile Photo" class="h-10 w-10 rounded-full">
                                
                            @else
                                <img src="/storage/images/default.png" alt="Default Profile Photo" class="h-10 w-10 rounded-full">
                            @endif
                    <div class="ml-2">
                        <span class="font-semibold"><a href="{{ url('profile/' . $post->user->id) }}">
                        {{ $post->user->name }}</a></span>
                        <div class="text-gray-500 text-xs">{{ $post->created_at->format('d M Y') }}</div>
                    </div>
                </div>
        </div>

        <div class="flex justify-between items-center mt-4">
                <div>
                    <p><i class="fas fa-heart"></i> {{ $post->likes->count() }}</p>
                </div>
            <div class="flex items-center space-x-2">
                <form action="{{ route('post.like', ['postId' => $post->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center space-x-1">
                        <i class="fas fa-heart"></i>
                        <span class="ml-1">Like</span>
                    </button>
                </form>
                    @csrf
                <form action="{{ route('post.share', ['post' => $post->id]) }}" method="POST">    
                    @csrf
                    <button type="submit"><i class="fas fa-share-alt"></i> Share</button>
                </form>
            </div>
        </div>

             <form action="{{ route('post.comment', ['post' => $post->id]) }}" method="POST" class="mt-4">
                @csrf
                <div class="flex items-center border border-gray-300 rounded-md p-2">
                    <textarea name="content" cols="30" rows="1" class="w-full resize-none focus:outline-none"></textarea>
                    <button type="submit" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded focus:outline-none focus:shadow-outline">Kirim</button>
                </div>
             </form>

             @if($post->comments->count() > 0)
                <div class="mt-4">
                    <h4 class="font-semibold">Comments:</h4>
                    @foreach($post->comments as $comment)
                        <div class="border-t border-gray-200 mt-2 pt-2">
                            <p>{{ $comment->content }}</p>
                            <p class="text-sm text-gray-600">By {{ $comment->user->name }} on {{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
             @endif
    </div>

</div>
@endsection
