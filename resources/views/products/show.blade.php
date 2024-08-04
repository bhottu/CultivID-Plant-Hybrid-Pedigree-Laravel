@extends('layouts.app')

@section('title', $product->name)

@section('content')

<div class="container px-4 mx-auto my-4">
    <div class="bg-white border border-gray-300 rounded-lg overflow-hidden shadow-lg flex flex-wrap">
        <!-- Kolom Kiri -->
        <div class="w-full md:w-2/3 p-4">
            @if($product->image_path)
                <img 
                id="post-image-{{ $product->id }}" 
                src="{{ asset('storage/' . $product->image_path) }}" 
                alt="{{ $product->name }}" 
                class="w-full h-82 object-cover cursor-pointer mb-4 post-image" 
                onclick="openImagePopup('{{ asset('storage/' . $product->image_path) }}')"
                data-image-url="{{ asset('storage/' . $product->image_path) }}"
                data-post-id="{{ $product->id }}">
            @else
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center mb-4">
                    <span>Photos</span>
                </div>
            @endif

            <div class="border-t border-gray-300 p-4 py-4 mb-4">
                <h3 class="text-lg font-semibold mb-2">Description</h3>
                <p>{{ $product->description }}</p>

                @if ($product->category)
                    <a href="{{ route('category.show', $product->category->slug) }}" class="inline-block bg-blue-200 text-gray-700 px-3 mt-4 py-1 rounded-full text-sm hover:bg-gray-300">
                        #{{ $product->category->name }}
                    </a>
                @endif
            </div>

            @if($product->video_path)
                <div class="border-t border-gray-300 p-4 py-4 mb-4">
                    <h3 class="text-lg font-semibold mb-2">Video</h3>
                    <video class="w-full md:w-3/4 lg:w-1/2" controls>
                        <source src="{{ asset('storage/' . $product->video_path) }}" type="video/mp4">
                        Browser Anda tidak mendukung tag video.
                    </video>
                </div>
            @endif
        </div>

        <!-- Kolom Kanan -->
        <div class="w-full md:w-1/3 p-4 border-t md:border-t-0 md:border-l border-gray-300">
            <div class="mb-4 flex items-center">
                <div class="w-full md:w-auto">
                    <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                    
                    @if($product->discount)
                        <span class="text-red-600 line-through mr-2">{{ $product->user->currency ?? 'Rp' }}{{ number_format($product->price, 0, ',', '.') }}</span>
                        <span class="text-gray-600 text-xl">{{ $product->user->currency ?? 'Rp' }} {{ number_format($product->discounted_price, 0, ',', '.') }}</span>
                    @else
                        <span class="text-gray-600 text-xl">{{ $product->user->currency ?? 'Rp' }} {{ number_format($product->price, 0, ',', '.') }}</span>
                    @endif
                    
                    <p class="text-gray-600 mb-2">{{ \Carbon\Carbon::parse($product->created_at)->format('d F, Y') }}</p>
                    <p class="text-gray-600 mb-2">Indonesia</p>
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
                    <div id="map" style="height: 100%; width: 100%;"></div>
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
