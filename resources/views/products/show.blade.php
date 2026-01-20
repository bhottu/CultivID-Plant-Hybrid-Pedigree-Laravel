@extends('layouts.app')

@section('title', $product->name)

@section('content')

<div class="container px-4 mx-auto  my-4">
    <div class="bg-white border border-gray-300 rounded-lg overflow-hidden shadow-lg flex flex-wrap">
        <!-- Kolom Kiri -->
        <div class="w-full md:w-2/3 p-4">

           <!-- Slider Container -->
            <div class="swiper-container z-1">
                
                <div class="swiper-wrapper">
                    <!-- Slide 1: Image -->
                    @if($product->image_path)
                    <div class="swiper-slide">
                        <img 
                            id="post-image-{{ $product->id }}" 
                            src="{{ asset('storage/' . $product->image_path) }}" 
                            alt="{{ $product->name }}" 
                            class="w-full custom-height object-cover cursor-pointer mb-4 post-image" 
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
                            class="w-full custom-height object-cover cursor-pointer mb-4"
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

            <div class="border-t border-gray-300 p-4 py-4 mb-4">
                <h3 class="text-lg font-semibold mb-2">Description</h3>
                <p>{{ $product->description }}</p>

                <div class="border-t border-gray-300 py-4 mt-4">
                    @if ($product->category)
                        Category : <a href="{{ route('category.show', $product->category->slug) }}" class="inline-block bg-blue-200 text-gray-700 px-3 py-1 rounded-full text-sm hover:bg-gray-300">
                            #{{ $product->category->name }}
                        </a>
                    @endif
                </div>
            </div>

       
        </div>

        <!-- Kolom Kanan -->
        <div class="w-full z-10 bg-white md:w-1/3 p-4 border-t md:border-t-0 md:border-l border-gray-300">
            <div class="mb-4 flex items-center">
                <div class="w-full md:w-auto">
                    <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                    
                    @if($product->discount)
                        <span class="text-red-600 line-through mr-2">{{ $product->user->currency ?? 'Rp' }}{{ number_format($product->price, 0, ',', '.') }}</span>
                        <span class="text-gray-600 text-xl">{{ $product->user->currency ?? 'Rp' }} {{ number_format($product->discounted_price, 0, ',', '.') }}</span>
                    @else
                        <span class="text-gray-600 text-xl">{{ $product->user->currency ?? 'Rp' }} {{ number_format($product->price, 0, ',', '.') }}</span>
                    @endif
                    
                    <p class="text-gray-600 mb-2 ">{{ $product->created_at->diffForHumans() }}</p>
                    <p class="mb-2 text-gray-500">
                    @if($product->is_sold_out)
                        <span class="text-red-600">Sold Out</span>
                    @else
                        <span class="text-sky-900">Available</span>
                    @endif
                    </p>
                </div>
            </div>

            <div class="mb-4 flex items-center">
                @if($product->user->phone_number)
                    <a href="https://wa.me/{{ $product->user->phone_number }}" class="hover:text-gray-500">
                        <button class="fab fa-whatsapp hover:text-green-500 dark:text-white text-blue-900 text-2xl mr-2"></button>
                    </a>
                    <a href="tel:{{ $product->user->phone_number }}" class="hover:text-gray-500">
                        <button class="fas fa-phone-alt hover:text-green-500 dark:text-white text-blue-900 text-2xl mr-2"></button>
                    </a>
                @else
                    <a href="#" class="hover:text-gray-500">
                        <button onclick='alert("The seller has not entered a phone number.")' class="fab fa-whatsapp hover:text-green-500 dark:text-white text-blue-900 text-2xl mr-2"></button>
                    </a>
                    <a href="#" class="hover:text-gray-500">
                        <button onclick='alert("The seller has not entered a phone number.")' class="fas fa-phone-alt hover:text-green-500 dark:text-white text-blue-900 text-2xl mr-2"></button>
                    </a>
                @endif

                <a href="mailto:{{ $product->user->email }}" class="hover:text-gray-500">
                    <button class="fas fa-envelope hover:text-green-500 text-blue-900 dark:text-white text-2xl mr-2"></button>
                </a>

                <div class="ml-auto flex items-center">
                    @if(Auth::check() && Auth::id() === $product->user_id)
                        <a href="{{ route('products.edit', $product) }}" class="hover:text-gray-500">
                            <button class="fas fa-pencil-alt hover:text-green-500 text-blue-900 text-2xl mr-2"></button>
                        </a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="fas fa-trash hover:text-red-500 text-blue-900 text-2xl" type="submit"></button>
                        </form>
                    @endif
                </div>
            </div>
            
            @if (Auth::id() == $product->user_id)
            <div class="border-t border-gray-300 py-4">
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
            
            <div class="border-t border-gray-300 py-4 mb-4">
                <h3 class="text-lg font-semibold mb-2">Seller</h3>
                <div class="flex items-center">
                    <div class="bg-gray-200 h-16 w-16 rounded-full flex items-center justify-center mr-4">
                        @if($product->user->profile_photo_path)
                            <img src="{{ asset('storage/' . $product->user->profile_photo_path) }}" alt="Profile Photo" class="h-16 w-16 rounded-full">
                        @else
                            <img src="/storage/images/default.png" alt="Default Profile Photo" class="h-16 w-16 rounded-full">
                        @endif
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold"> {{ $product->user->name ?? 'Unknown' }} </h4>
                        <div class="flex items-center">
                            <form action="{{ url('profile/' . $product->user->id) }}">
                                <button class="bg-blue-200 text-gray-700 px-3 py-1 rounded-sm text-sm hover:bg-gray-300 rounded px-2 py-1 mt-2">
                                    <i class="fas fa-store"></i> Profil
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-300 py-4">
                <h3 class="text-lg font-semibold mb-2">Location</h3>
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                    <div id="map" class="h-full w-full z-0"></div>
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
</script>

@endsection
