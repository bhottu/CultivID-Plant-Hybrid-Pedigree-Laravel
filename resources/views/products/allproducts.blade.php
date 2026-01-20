@extends('layouts.app')

@section('content')

<div class="container mx-auto max-w-lg px-4 my-4">
        <h1 class="text-2xl font-bold text-gray-800">Market</h1>
        <p class="text-sm text-gray-500">No fee & free to submit.</p>
</div>

<div class="container mx-auto max-w-lg px-4 my-4">
    
    <div id="product-list" class="grid grid-cols-1 gap-4 mt-4">
        @foreach ($products as $product)
            <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                    @if ($product->image_path)
                    <div class="relative">
                            <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:underline">
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                                @if ($product->is_sold_out)
                                    <span class="absolute bottom-0 right-0 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-tl">
                                        Sold Out
                                    </span>
                                @else
                                    <span class="absolute bottom-0 right-0 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-tl">
                                        Available
                                    </span>
                                @endif
                            </a>
                        </div>
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
                            <span class="font-semibold"><a href="{{ url('profile/' . $product->user->username) }}" class="hover:text-gray-500">
                            {{ $product->user->name ?? 'Unknown' }}</a></span>
                            <div class="text-gray-500 text-xs">{{ $product->created_at->diffForHumans() }}</div>
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

@if ($products->hasMorePages())
    <!-- Load More Sentinel -->
    <div id="load-more" class="mt-4 text-center">
        <div id="loading-spinner" class="hidden">
            <i class="fas fa-spinner fa-spin text-gray-500"></i> Loading more products...
        </div>
        <div id="no-more" class="hidden text-gray-500">No more products</div>
    </div>
@endif

<div id="product-template" class="hidden">
    <div class="bg-white rounded-lg overflow-hidden shadow-lg product-item">
        <a href="#" class="product-link text-blue-500 hover:underline">
            <img src="" alt="" class="product-image w-full h-64 object-cover">
        </a>
        <div class="p-4">
            <a href="#" class="product-link text-blue-500 hover:text-gray-500">
                <h2 class="product-name text-xl font-semibold"></h2>
            </a>
            <p class="product-price text-gray-600 mb-2"></p>
            <div class="flex items-center">
                <a href="#" class="profile-link">
                    <img src="" alt="Profile Photo" class="profile-photo h-10 w-10 rounded-full">
                </a>
                <div class="ml-2">
                    <span class="product-owner font-semibold">
                        <a href="#" class="profile-link hover:text-gray-500"></a>
                    </span>
                    <div class="product-date text-gray-500 text-xs"></div>
                </div>
            </div>
            <p class="product-description text-gray-800">
                <span class="inline-block bg-blue-200 text-blue-800 rounded-300 px-3 py-1 text-xs font-semibold mr-2">
                    <a href="#" class="read-more text-blue-500 hover:underline">Read more</a>
                </span>
            </p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    let isLoading = false;
    let hasMorePages = {{ $products->hasMorePages() ? 'true' : 'false' }};

    const loadMoreElement = document.getElementById('load-more');
    const loadingSpinner = document.getElementById('loading-spinner');
    const noMoreElement = document.getElementById('no-more');

    if (loadMoreElement) {
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
    }

    function loadNextPage() {
        if (isLoading || !hasMorePages) return;

        isLoading = true;
        loadingSpinner.classList.remove('hidden');
        noMoreElement.classList.add('hidden');

        const nextPage = currentPage + 1;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`{{ route('load-more-products') }}?page=${nextPage}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                // Append new products
                const productList = document.getElementById('product-list');
                productList.insertAdjacentHTML('beforeend', data.html);
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
@endsection
