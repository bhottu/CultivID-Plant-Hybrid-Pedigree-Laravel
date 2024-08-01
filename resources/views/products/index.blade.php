@extends('layouts.app')

@section('content')

<section class="w-full">
    @if (isset($settings) && $settings->banner)
        <div class="w-full h-[520px] bg-cover bg-no-repeat bg-center flex flex-col justify-center items-center" style="background-image: url('{{ Storage::url($settings->banner) }}')">
    @endif

        <div>
            <h1 class="text-white text-center xl:text-5xl lg:text-4xl md:text-3xl sm:text-2xl xs:text-xl font-semibold bg-gray-800 p-2 bg-opacity-40 rounded-sm">Open a Store, Find Buyers, Create Opportunities!</h1>
        </div>
        <div class="w-full mx-auto">
            <form action="{{ route('search') }}" method="GET" class="flex items-center">
                <div class="xl:w-1/2 lg:w-[60%] md:w-[70%] sm:w-[70%] xs:w-[90%] mx-auto flex gap-2 md:mt-6 xs:mt-4 mx-4">
                <input type="text" name="query" class="order-solid border-2 border-white-500 form-input w-full rounded-l-md px-4 py-2" placeholder="Search..." required>
                <button type="submit" class="border-solid border-2 border-white-500 bg-blue-1000 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded-r-md">Search</button> </div>
            </form>

    <!-- Categories Section -->
    <div class="mb-6 mt-4">
        <h2 class="text-2xl flex justify-center text-white font-bold rounded-sm p-2">Categories</h2>
        <div class="flex justify-center flex-wrap mt-4 gap-4">
            @foreach($categories as $category)
            <a href="{{ route('category.show', $category->slug) }}" 
            class="text-white hover:bg-blue-200 hover:text-gray-800 text-center xl:text-2xl lg:text-xl md:text-lg sm:text-base xs:text-sm font-semibold bg-gray-800 p-2 bg-opacity-40 rounded-sm">
                <h2 class="text-sm font-semibold">{{ $category->name }}</h2>
            </a>
            @endforeach


        </div>
        <div class="flex justify-center flex-wrap mt-4 gap-4">
             <a href="{{ route('categories.all') }}" class="text-gray-800 hover:bg-blue-200 hover:text-gray-800 text-center 
                                xl:text-2xl lg:text-xl md:text-lg sm:text-base xs:text-sm font-semibold 
                                bg-blue-100 p-2 bg-opacity-40 rounded-sm">
                <h2 class="text-sm font-semibold">View All Categories</h2>
            </a>
        </div>
    </div>
        </div>
    </div>
</section>



<div class="container mx-auto my-8">

<!-- Thanks to Mereani Waqa for this section -->
<section id="works" class="mt-4 relative border-l-4 border-double border-sky-500 bg-sky-100 py-10 sm:py-16 lg:py-5">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-4xl text-gray-600 font-semibold mx-auto md:text-4xl lg:text-4xl">How does it work?</h2>
        </div>
        <div class="relative mt-12 lg:mt-5">
            <div class="absolute inset-x-0 hidden xl:px-44 top-2 md:block md:px-20 lg:px-28">     
            <svg width="875" height="48" viewBox="0 0 875 48" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M2 29C20.2154 33.6961 38.9915 35.1324 57.6111 37.5555C80.2065 40.496 102.791 43.3231 125.556 44.5555C163.184 46.5927 201.26 45 238.944 45C312.75 45 385.368 30.7371 458.278 20.6666C495.231 15.5627 532.399 11.6429 569.278 6.11109C589.515 3.07551 609.767 2.09927 630.222 1.99998C655.606 1.87676 681.208 1.11809 706.556 2.44442C739.552 4.17096 772.539 6.75565 805.222 11.5C828 14.8064 850.34 20.2233 873 24" stroke="#0ea5e9" stroke-width="3" stroke-linecap="round" stroke-dasharray="1 12"/>
</svg>

            </div>
            <div class="relative grid grid-cols-1 text-center gap-y-12 md:grid-cols-3 gap-x-12">
                <div>
                    <div
                        class="flex items-center justify-center w-16 h-16 mx-auto bg-blue-100  border-2 border-gray-400 rounded-full shadow">
                        <span class="text-xl font-semibold text-gray-400">1</span>
                    </div>
                    <h3 class="mt-2 text-xl  text-gray-600  font-semibold leading-tight md:mt-2">Search for Products</h3>
                    <p class="mt-4 text-base text-gray-400 md:text-lg">
                    Browse and find desired products
                    </p>
                </div>
                <div>
                    <div
                        class="flex items-center justify-center w-16 h-16 mx-auto bg-blue-100 border-2 border-gray-400 rounded-full shadow">
                        <span class="text-xl font-semibold text-gray-400">2</span>
                    </div>
                    <h3 class="mt-2 text-xl text-gray-600 font-semibold leading-tight md:mt-2">Contact the Seller</h3>
                    <p class="mt-4 text-base text-gray-400 md:text-lg">
                    Reach out, negotiate, discuss details.
                    </p>
                </div>
                <div>
                    <div
                        class="flex items-center justify-center w-16 h-16 mx-auto bg-blue-100 border-2 border-gray-400 rounded-full shadow">
                        <span class="text-xl font-semibold text-gray-400">3</span>
                    </div>
                    <h3 class="mt-2 text-xl text-gray-600 font-semibold leading-tight md:mt-2">Complete the Transaction</h3>
                    <p class="mt-4 text-base text-gray-400 md:text-lg">
                    Finalize purchase using secure payment.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute inset-0 m-auto max-w-xs h-[357px] blur-[118px] sm:max-w-md md:max-w-lg"
        style="background:radial-gradient(1.89deg, rgba(34, 78, 95, 0.4) -1000%, rgba(191, 227, 205, 0.26) 1500.74%, rgba(34, 140, 165, 0.41) 56.49%, rgba(28, 47, 99, 0.11) 1150.91%)">
    </div>
</section>

    <!-- Recently Products Section -->
<div class="flex justify-between items-center mt-4 mb-6">
    <h1 class="text-2xl font-bold border-l-4 border-double border-sky-500 pl-4">Recently Products</h1>
    <a href="{{ route('all.products') }}" id="view-more" class="bg-white hover:bg-blue-100 text-gray-500 font-bold py-2 px-4 rounded border border-gray-500 focus:outline-none focus:shadow-outline">View All</a>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
    @if ($products->isEmpty())
        <p>No products yet. <a href="{{ route('products.create') }}" class="text-red-500 rounded bg-blue-200 hover:bg-gray-200 py-1 px-2">Add a Product</a></p>
    @else
        @foreach ($products as $product)
            <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                @if ($product->image_path)
                    <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:underline">
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                    </a>
                @endif
                <div class="p-4">
                    <a href="{{ route('products.show', $product) }}" class="text-blue-900 hover:text-gray-500">
                        <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                    </a>
                    <div class="flex items-center mt-2">
                        @if ($product->discount)
                            <span class="text-red-600 line-through mr-2">{{ $product->user->currency ?? 'Rp' }} {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-gray-600">{{ $product->user->currency ?? 'Rp' }} {{ number_format($product->discounted_price, 0, ',', '.') }}</span>
                        @else
                            <span class="text-gray-600">{{ $product->user->currency ?? 'Rp' }} {{ number_format($product->price, 0, ',', '.') }}</span>
                        @endif
                    </div>
                    <div class="flex items-center mt-2">
                        <a href="{{ url('profile/' . $product->user->id) }}">
                            @if ($product->user && $product->user->profile_photo_path)
                                <img src="{{ asset('storage/' . $product->user->profile_photo_path) }}" alt="Profile Photo" class="h-10 w-10 rounded-full">
                            @else
                                <img src="/storage/images/default.png" alt="Default Profile Photo" class="h-10 w-10 rounded-full">
                            @endif
                        </a>
                        <div class="ml-2">
                            <span class="font-semibold">
                                <a href="{{ url('profile/' . $product->user->id) }}" class="hover:text-gray-500">{{ $product->user->name ?? 'Unknown' }}</a>
                            </span>
                            <div class="text-gray-500 text-xs">{{ $product->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                    <p class="text-gray-800 mt-2">{{ Str::limit($product->description, 50) }}</p>
                    @if ($product->category)
                        <a href="{{ route('category.show', $product->category->slug) }}" class="inline-block bg-blue-200 text-gray-700 px-3 py-1 rounded-full text-xs hover:bg-gray-300">
                            #{{ $product->category->name }}
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>


    
    <!-- Discounted Section -->
<div class="mb-6 mt-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold border-l-4 border-double border-sky-500 pl-4">Discounted Products</h1>
        <a href="{{ route('discounted.products') }}" id="view-more" class="bg-white hover:bg-blue-100 text-gray-500 font-bold py-2 px-4 rounded border border-gray-500 focus:outline-none focus:shadow-outline">View All</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
        @if ($discountedProducts->isEmpty())
            <p>No discounted products yet. <a href="{{ route('products.create') }}" class="text-red-500 rounded bg-blue-200 hover:bg-gray-200 py-1 px-2">Add a Product</a></p>
        @else
            @foreach ($discountedProducts as $product)
                <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                    @if ($product->image_path)
                        <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:underline">
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                        </a>
                    @endif
                    <div class="p-4">
                        <a href="{{ route('products.show', $product) }}" class="text-blue-900 hover:text-gray-500">
                            <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                        </a>
                        <div class="flex items-center mt-2">
                            <span class="text-red-600 line-through mr-2">{{ $product->user->currency ?? 'Rp' }} {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-gray-600">{{ $product->user->currency ?? 'Rp' }} {{ number_format($product->discounted_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center mt-2">
                            <a href="{{ url('profile/' . $product->user->id) }}">
                                @if ($product->user && $product->user->profile_photo_path)
                                    <img src="{{ asset('storage/' . $product->user->profile_photo_path) }}" alt="Profile Photo" class="h-10 w-10 rounded-full">
                                @else
                                    <img src="/storage/images/default.png" alt="Default Profile Photo" class="h-10 w-10 rounded-full">
                                @endif
                            </a>
                            <div class="ml-2">
                                <span class="font-semibold">
                                    <a href="{{ url('profile/' . $product->user->id) }}" class="hover:text-gray-500">{{ $product->user->name ?? 'Unknown' }}</a>
                                </span>
                                <div class="text-gray-500 text-xs">{{ $product->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                        <p class="text-gray-800 mt-2">{{ Str::limit($product->description, 50) }}</p>
                        @if ($product->category)
                            <a href="{{ route('category.show', $product->category->slug) }}" class="inline-block bg-blue-200 text-gray-700 px-3 py-1 rounded-full text-xs hover:bg-gray-300">
                                #{{ $product->category->name }}
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>


 <!-- Posts Section -->
<div class="mb-6 w-auto mt-4">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold border-l-4 border-double border-sky-500 pl-4">Discuss</h1>
        <a href="{{ route('index.sosmed') }}" id="view-more" class="bg-white hover:bg-blue-100 text-gray-500 font-bold py-2 px-4 rounded border border-gray-500 focus:outline-none focus:shadow-outline">View All</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mt-4">
        @if ($posts->isEmpty())
            <p>No posts yet.</p>
        @else
            @foreach($posts as $post)
                <div class="bg-white rounded-lg overflow-hidden shadow-lg relative flex flex-col">
                    <div class="p-4 flex-grow flex flex-col">
                        <div class="flex items-center">
                        <a href="{{ isset($post->user) ? url('profile/' . $post->user->id) : '#' }}">

                        @if($post->user && $post->user->profile_photo_path)
                            <img src="{{ asset('storage/' . $post->user->profile_photo_path) }}" alt="Profile Photo" class="h-10 w-10 rounded-full">
                        @else
                            <img src="/storage/images/default.png" alt="Default Profile Photo" class="h-10 w-10 rounded-full">
                        @endif

                            </a>
                            <div class="ml-2">
                                <span class="font-semibold">
                                @if($post->user)
                                    <a href="{{ url('profile/' . $post->user->id) }}" class="hover:text-gray-500">{{ $post->user->name }}</a>
                                @endif

                                </span>
                                <div class="text-gray-500 text-xs">{{ $post->created_at->format('d M Y') }}</div>
                            </div>
                        </div>

                        @if(Auth::id() === $post->user_id)
                            <div class="absolute top-0 right-0 mt-2 mr-2">
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
                            </div>
                        @endif

                        <p class="text-gray-800 mt-2" id="caption_{{ $post->id }}">
                            {!! Str::limit($post->caption, 100, '<span id="dots_'.$post->id.'">... </span><span id="more_'.$post->id.'" style="display: none;">'.substr($post->caption, 100).'</span>
                                <a href="'.route('post.show', $post->id).'" class="hover:text-blue-500 inline-block bg-blue-200 text-blue-800 rounded-full px-3 py-1 text-xs font-semibold mr-2" id="moreLink_'.$post->id.'"> More</a>') !!}
                        </p>
                        @if($post->image)
                            <div class="w-full h-full overflow-hidden aspect-w-16 aspect-h-9">
                            <img 
                                id="post-image-{{ $post->id }}" 
                                src="{{ asset('storage/' . $post->image) }}" 
                                alt="Post Image" 
                                class="object-cover w-full h-full cursor-pointer post-image"
                                data-image-url="{{ asset('storage/' . $post->image) }}"
                                data-post-id="{{ $post->id }}">
                            </div>
                        @endif
                        @include('components.ImagePopup', ['post' => $post])
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>



</div>
@endsection
