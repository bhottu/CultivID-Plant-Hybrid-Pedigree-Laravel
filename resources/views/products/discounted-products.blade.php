@extends('layouts.app')

@section('content')
<div class="container px-4 mx-auto my-8">
    <h1 class="text-2xl font-bold mb-6">Discounted Products</h1>
    <div id="discounted-product-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach ($discountedProducts as $product)
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
                    <div class="flex items-center mb-2">
                   
                        @if($product->discount)
                            <span class="text-red-600 line-through mr-2">{{ $product->user->currency ?? 'Rp' }} {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-gray-600">{{ $product->user->currency ?? 'Rp' }} {{ number_format($product->discounted_price, 0, ',', '.') }}</span>
                        @else
                            <span class="text-gray-600">{{ $product->user->currency ?? 'Rp' }} {{ number_format($product->price, 0, ',', '.') }}</span>
                        @endif
                   
                    </div>

                    <div class="flex items-center">
                        <a href="{{ url('profile/' . $product->user->id) }}">
                        @if($product->user->profile_photo_path)
                            <img src="{{ asset('storage/' . $product->user->profile_photo_path) }}" alt="Profile Photo" class="h-10 w-10 rounded-full">
                        @else
                            <img src="/storage/images/default.png" alt="Default Profile Photo" class="h-10 w-10 rounded-full">
                        @endif

                        </a>
                        <div class="ml-2">
                            <span class="font-semibold"><a href="{{ url('profile/' . $product->user->id) }}" class="hover:text-gray-500">
                            {{ $product->user->name ?? 'Unknown' }}</a></span>
                            <div class="text-gray-500 text-xs">{{ $product->created_at->format('d M Y') }}</div>
                        </div>
                    </div>

                    <p class="text-gray-800">{{ Str::limit($product->description, 50, '...') }} <span class="inline-block bg-blue-200 text-blue-800 rounded-300 px-3 py-1 text-xs font-semibold mr-2">
                        <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:underline">Read more</a></p>
                    </span>

                    @if ($product->category)
                    <a href="{{ route('category.show', $product->category->slug) }}" class="inline-block bg-blue-200 text-gray-700 px-3 py-1 rounded-full text-sm hover:bg-gray-300">
                        #{{ $product->category->name }}
                    </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

@if ($discountedProducts->hasMorePages())
    <div class="flex justify-center mt-4">
        <button id="load-more-discounted" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" data-next-page="{{ $discountedProducts->currentPage() + 1 }}">
            Load More
        </button>
    </div>
@endif

@endsection


