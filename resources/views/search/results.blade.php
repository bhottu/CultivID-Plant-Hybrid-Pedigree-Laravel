<!-- resources/views/search/results.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto my-8">
    <h1 class="text-2xl font-bold mb-6">Search Results for: "{{ $query }}"</h1>

    <div class="mb-8">
        <h2 class="text-xl font-semibold">Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @forelse ($products as $product)
                <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                    @if($product->image_path)
                    <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:underline">
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                    </a>
                    @endif

                    <div class="p-4">
                    <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:text-gray-500">
                        <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                    </a>
                    <p class="text-gray-600 mb-2">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        <p class="text-gray-800">{{ Str::limit($product->description, 50, '...') }}</p>
                    </div>
                </div>
            @empty
                <p>No products found.</p>
            @endforelse
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-xl font-semibold">Users</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @forelse ($users as $user)
                <div class="bg-white rounded-lg overflow-hidden shadow-lg p-4">
                    <a href="{{ route('profile', $user->id) }}" class="text-blue-500 hover:underline">
                        @if($user->profile_photo_path)
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover">
                        @else
                            <img src="/storage/images/default.png" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover">
                        @endif
                        <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                    </a>
                    <p class="text-gray-600">{{ $user->email }}</p>
                </div>
            @empty
                <p>No users found.</p>
            @endforelse
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-xl font-semibold">Discuss</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @forelse ($posts as $post)
                <div class="bg-white rounded-lg overflow-hidden shadow-lg p-4">
                    <a href="{{ route('post.show', $post->id) }}" class="text-blue-500 hover:underline">
                        <h2 class="text-xl font-semibold">{{ $post->caption }}</h2>
                    </a>
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->caption }}" class="w-full h-64 object-cover">
                    @endif
                </div>
            @empty
                <p>No discuss found.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
