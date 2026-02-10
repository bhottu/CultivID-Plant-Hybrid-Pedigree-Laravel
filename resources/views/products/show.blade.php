@extends('layouts.app')

@section('title', $product->name)

@php
    $photos = json_decode($product->photos, true);

    if (!empty($photos) && isset($photos[0])) {
        $ogImage = asset('storage/' . $photos[0]);
    } else {
        $imageDecoded = json_decode($product->image_path, true);
        if (is_array($imageDecoded) && isset($imageDecoded[0])) {
            $ogImage = asset('storage/' . $imageDecoded[0]);
        } elseif ($product->image_path) {
            $ogImage = asset('storage/' . $product->image_path);
        } else {
            $ogImage = asset('images/og-default.jpg');
        }
    }
@endphp

@section('og_image', $ogImage)

@section('og_description',
    \Illuminate\Support\Str::limit(
        strip_tags($product->description ?? ''),
        155
    )
)

@section('content')

<div class="container mx-auto max-w-lg text-xs">
    <div class="bg-white overflow-hidden  flex flex-wrap">
        <!-- Kolom Kiri -->
        <div class="w-full p-2">

           <!-- Slider Container -->
            <div class="swiper-container z-1">
                
                <div class="swiper-wrapper">
                    <!-- Slide 1: Image -->
                    @if($product->image_path)
                    <div class="swiper-slide w-full z-0">
                        <img 
                            id="post-image-{{ $product->id }}" 
                            src="{{ asset('storage/' . $product->image_path) }}" 
                            alt="{{ $product->name }}" 
                            class="w-full custom-height object-cover cursor-pointer mb-2 post-image" 
                            onclick="openImagePopup('{{ asset('storage/' . $product->image_path) }}')"
                            data-image-url="{{ asset('storage/' . $product->image_path) }}"
                            data-post-id="{{ $product->id }}">
                    </div>
                    @else
                    <div class="swiper-slide">
                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                            <span>Photos</span>
                        </div>
                    </div>
                    @endif

                    <!-- Slide 2: Video -->
                    @if($product->video_path)
                    <div class="swiper-slide z-0">
                        <video 
                            class="w-full custom-height object-cover cursor-pointer mb-2"
                            controls
                            onclick="openVideoPopup('{{ asset('storage/' . $product->video_path) }}')"
                            data-video-url="{{ asset('storage/' . $product->video_path) }}">
                            <source src="{{ asset('storage/' . $product->video_path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    @else
                    <div class="swiper-slide">
                        <div class="w-full custom-height bg-gray-200 flex items-center justify-center">
                            <span>No video available</span>
                        </div>
                    </div>
                    @endif
                    
                </div>

                

            </div>

            <!-- Initialize Swiper -->
            <script>
                var swiper = new Swiper('.swiper-container', {
                    slidesPerView: 1,
                    spaceBetween: 10,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                });
            </script>

                            <div class="flex dark:text-gray-50 dark:bg-gray-700 mb-2 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 5l7 7-7 7" />
                                </svg>

                                <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Share this product</span>  
                  
                                <span class="text-heading text-xs font-medium px-1.5 py-0.5 text-gray-700 dark:text-gray-400">
                                                    
                                <button type="button"
                                    onclick="sharePost()"
                                    class="w-full text-gray hover:bg-blue-100 border font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline flex items-center justify-center h-full">
                                    
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3.684 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                                    </svg>
                                </button>
                                                        
                                </span>
                            </div>
                            
                                <span class="flex items-center text-gray-700 dark:text-gray-400 dark:bg-gray-700 p-3 gap-2 text-lg font-semibold text-heading rounded-base bg-gray-50 ">{{ $product->name }}</span>

                                <div class="flex items-center p-3 gap-3 text-lg font-semibold text-heading rounded-base bg-gray-50 group dark:text-gray-400 dark:bg-gray-700 " disabled>
                                    <span class="flex-1 min-w-0 text-left text-sm text-gray-700 dark:text-gray-400 ">
                                        <p class=" text-gray-500">
                                            @if($product->discount)
                                            <span class="text-gray-600 dark:text-gray-400 text-sm">{{ $product->user->currency ?? 'Rp' }} {{ number_format($product->discounted_price, 0, ',', '.') }}</span>
                                            <span class="text-red-600 dark:text-gray-400 line-through text-xs">{{ $product->user->currency ?? 'Rp' }}{{ number_format($product->price, 0, ',', '.') }}</span>
                                            
                                            @else
                                                <span class="text-gray-600 dark:text-gray-400 text-xs">{{ $product->user->currency ?? 'Rp' }} {{ number_format($product->price, 0, ',', '.') }}</span>
                                            @endif
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400 text-xs">{{ $product->created_at->diffForHumans() }}</p>
                                    </span> 

                                    <span class="flex-1 min-w-0 text-right text-gray-700">
                                            @if($product->is_sold_out)
                                                <span class="text-red-600 text-xs bg-red-400 py-1 px-1 rounded-md">Sold Out</span>
                                            @else
                                                <span class="text-sky-900 text-xs bg-green-400 py-1 px-1 rounded-md">Available</span>
                                            @endif
                                    </span>

                                        
                                </div>
                           

        <div class="w-full max-w-lg p-4 mt-3 sm:p-6 bg-neutral-primary-soft bg-gray-50 dark:border-red rounded-base dark:text-gray-400 dark:bg-gray-700 ">
            <div class="mb-2">
              
                <p class="text-xs font-semibold mb-2 mt-2">Description</p>
                <p>{{ $product->description }}</p>

                <div class="mt-2">
                    @if ($product->category)
                        Category : <a href="{{ route('category.show', $product->category->slug) }}" class="inline-block bg-blue-200 text-gray-700 px-2 py-1 rounded-md text-xs hover:bg-gray-300">
                            #{{ $product->category->name }}
                        </a>
                    @endif
                </div>
            </div>

            @if (Auth::id() == $product->user_id)
            <div class="border-t border-gray-300">
                <form action="{{ route('products.toggle-soldout', $product) }}" method="POST">
                    @csrf
                    @if (!$product->is_sold_out)
                        <button type="submit" class="px-4 w-full py-2 bg-red-500 text-white rounded hover:bg-red-600">Mark as Soldout</button>
                    @else
                        <button type="submit" class="px-4 w-full py-2 bg-green-500 text-white rounded hover:bg-green-600">Mark as Available</button>
                    @endif
                </form>
                </div>
            @endif

            </div>
       
        <div class="w-full bg-gray-100 border-2 mt-3 border-dashed border-gray-400 rounded-xl p-8 flex flex-col items-center justify-center text-center hover:bg-gray-200 transition-all cursor-pointer">
            <div class="p-3 rounded-full shadow-sm mb-4">
                <i class="fas fa-ad text-2xl text-gray-800"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-700">Place Your Ad Here</h3>
            <p class="text-sm text-gray-500 max-w-xs mt-1">Reach thousands of plant enthusiasts in the Cultiv community.</p>
            <a href="https://wa.me/6288901309732?text=Dear%20support%2C%20we%20would%20like%20to%20apply%20for%20an%20advertisement%20on%20the%20product%20page." class="mt-4 px-6 py-2 bg-blue-600 text-white text-xs font-bold rounded-full hover:bg-blue-700 transition">
                CONTACT US
            </a>
        </div>

            <div class="w-full mt-3 max-w-lg bg-neutral-primary-soft ">
                    @if($product->user)
                        <ul class="my-6 space-y-3">
                            <li>
                                <a href="{{ url('profile/' . $product->user->username) }}" class="flex items-center p-3 gap-3 text-lg font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group dark:text-gray-400 dark:bg-gray-700 ">
                                    @if($product->user->profile_photo_path)
                                        <img src="{{ asset('storage/' . $product->user->profile_photo_path) }}" alt="Profile Photo" class="h-16 w-16 rounded-full">
                                    @else
                                        <img src="/storage/images/default.png" alt="Default Profile Photo" class="h-16 w-16 rounded-full">
                                    @endif

                                    <span class="flex-1 min-w-0 text-left text-gray-700">
                                        <form action="{{ url('profile/' . $product->user->username) }}" hx-get="{{ url('profile/' . $product->user->username) }}" hx-target="#app-content" hx-push-url="true">
                                            <button class="text-gray-700 dark:text-gray-400  py-1  text-sm rounded py-1 mt-2">
                                                {{ $product->user->name ?? 'Unknown' }}
                                            </button>
                                        </form>  
                                        
                                        <div class="flex justify-between min-w-0 text-xs text-gray-600 dark:text-gray-400 ">
                                            <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.24 12.24a6 6 0 00-8.49-8.49L5 10.5V19h8.5z"></path>
                                                </svg>
                                                <span>{{ $product->user->plantSubmissions->count() }} Plants</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                </svg>
                                                <span>{{ $product->user->posts->count() }} Posts</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                </svg>
                                                <span>{{ $product->user->products->count() }} Products</span>
                                            </div>
                                            
                                        </div>
                                    <span class="text-heading text-xs font-medium px-1.5 py-0.5 text-gray-700 dark:text-gray-400 "> 
                                       Member since  <span class="text-xs text-gray-500 ">{{ $product->user->created_at->diffForHumans() }}</span>
                                    </span>
                                        </span> 
                                    
                                </a>
                            </li>
                    @endif
                            <div class="flex items-center ml-4 dark:text-gray-400">
                                @if($product->user->phone_number)
                                    <a href="https://wa.me/{{ $product->user->phone_number }}" class="hover:text-gray-500 dark:hover:text-white dark:text-gray-400">
                                        <button class="fab fa-whatsapp hover:text-green-500 dark:hover:text-white text-gray-400 dark:text-gray-400 text-md text-2xl mr-2"></button>
                                    </a>
                                    <a href="tel:{{ $product->user->phone_number }}" class="hover:text-gray-500 ">
                                        <button class="fas fa-phone-alt hover:text-green-500 dark:hover:text-white text-gray-400 text-md text-2xl mr-2 dark:text-gray-400"></button>
                                    </a>
                                @else
                                    <a href="#" class="hover:text-gray-500">
                                        <button onclick='alert("The seller has not entered a phone number.")' class="fab fa-whatsapp hover:text-green-500 dark:hover:text-white text-gray-400 text-md text-2xl mr-2 dark:text-gray-400"></button>
                                    </a>
                                    <a href="#" class="hover:text-gray-500">
                                        <button onclick='alert("The seller has not entered a phone number.")' class="fas fa-phone-alt hover:text-green-500  dark:hover:text-white text-gray-400 text-md text-2xl mr-2 dark:text-gray-400"></button>
                                    </a>
                                @endif

                                <a href="mailto:{{ $product->user->email }}" class="hover:text-gray-500">
                                    <button class="fas fa-envelope hover:text-green-500 dark:hover:text-white text-md text-gray-400 dark:text-gray-400 text-2xl mr-2"></button>
                                </a>

                            <div class="ml-auto flex items-center">
                                @if(Auth::check() && Auth::id() === $product->user_id)
                                    <a href="{{ route('products.edit', $product->slug) }}" class="hover:text-gray-500">
                                        <button class="fas fa-pencil-alt hover:text-green-500 text-md text-blue-400 text-2xl mr-2"></button>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->slug) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="fas fa-trash hover:text-red-500 text-red-400 text-2xl" type="submit"></button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        
                            
                        </ul>
                    </div>

                    <div class=" py-4">
                        <h3 class="text-lg border-green-200 border-l-4 px-2 border-doubled mb-2 dark:text-gray-400">Location</h3>
                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                            <div id="map" class="h-full w-full z-0"></div>
                        </div>
                    </div>

        </div>

        

        
        </div>
    </div>
</div>

@include('components.ImagePopupProductShow', ['product' => $product])

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([{{ $product->user->latitude }}, {{ $product->user->longitude }}], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker([{{ $product->user->latitude }}, {{ $product->user->longitude }}]).addTo(map);
    marker.bindPopup('<b>{{ $product->user->name }}</b>').openPopup();

     // share mobile native 
        function sharePost() {
            const shareData = {
                title: @json($product->name),
                text: @json(\Illuminate\Support\Str::limit($product->description, 100)),
                url: @json(url()->current())
            };

            if (navigator.share) {
                navigator.share(shareData)
                    .catch(err => console.log('Share cancelled', err));
            } else {
                openShareFallback();
            }
        }
</script>

@endsection
