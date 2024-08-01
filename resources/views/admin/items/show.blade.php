@extends('admin.layout')

@section('content')
    <div class="container mx-auto px-4">
        
        <h1 class="text-3xl font-semibold mt-4 mb-4 text-gray-700">{{ $product->name }}</h1>

        <div class="flex items-center mb-4">
            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" onclick="openImagePopup('{{ asset('storage/' . $product->image_path) }}')" class="w-32 h-32 object-cover rounded-lg shadow-md">
            <div class="ml-4">
                
                <div class="mt-2">
                    <h2 class="text-lg font-semibold text-gray-700">{{ $product->user->currency ?? 'Rp' }} {{ number_format($product->price, 0, ',', '.') }}</h2>
                    @if ($product->discount > 0)
                        <h2 class="text-lg font-semibold text-gray-600">Diskon: {{ $product->discount }}%</h2>
                        <h2 class="text-lg font-semibold text-red-400">Discounted: Rp {{ number_format($product->price * (100 - $product->discount) / 100, 0, ',', '.') }}</h2>
                    @endif
                </div>
                <h2 class="text-sm font-italic text-gray-500">#{{ $product->category->name }}</h2>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2 text-gray-700">Description:</h2>
            <p class="text-gray-700">{{ $product->description }}</p>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2 text-gray-700">Video:</h2>
            @if ($product->video_path)
                <video controls class="w-32 h-32">
                    <source src="{{ asset('storage/' . $product->video_path) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @else
                <p class="text-gray-700">No video for this item.</p>
            @endif
        </div>


    </div>

    <!-- ImagePopup.blade.php -->
<div id="image-popup" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-75">
    <div class="relative max-w-screen-lg mx-auto flex h-full">
        <!-- Bagian Gambar di Kiri -->
        <div class="relative bg-black h-full flex items-center justify-center">
            <img id="image-popup-img" src="" alt="Post Image" class="max-h-full max-w-full object-contain rounded-lg">
            <div class="absolute top-0 right-0 p-4">
                <button class="text-white hover:text-gray-300" onclick="closeImagePopup()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>  
    </div>
</div>
<!-- End Popup -->

@endsection
