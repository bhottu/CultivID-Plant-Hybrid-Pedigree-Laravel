@extends('layouts.app')

@section('content')
<div class="container max-w-lg mx-auto p-6">
    <h2 class="text-sm mb-4 font-semibold bg-red-100 text-gray-800">Edit Product</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <a href="{{ route('products.show', $product) }}" class=" text-gray-800 hover:bg-gray-200">View Product</a>
        </div>
    @endif

    <form id="updateProductForm" action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2" required>
            @error('name')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2" required>{{ old('description', $product->description) }}</textarea>
            @error('description')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
            <input type="number" id="price" name="price" value="{{ number_format(old('price', $product->price), 0, '', '') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2" required>
            @error('price')
                <span class="text-red-600 text-sm">{{ $message }}</span> 
            @enderror
        </div>

        <div class="mb-4">
            <label for="discount" class="block text-sm font-medium text-gray-700">Discount (%)</label>
            <input type="number" id="discount" name="discount" value="{{ number_format(old('discount', $product->discount), 0, '', '') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2">
            @error('discount')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
            <select id="category_id" name="category_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == old('category_id', $product->category_id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="image_path" class="block text-sm font-medium text-gray-700">Image</label>

            <input 
                type="file" 
                id="image_path" 
                name="image_path" 
                accept="image/*"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2"
            >

            @error('image_path')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror

            <div class="mt-2">
                <img 
                    id="imagePreview"
                    src="{{ $product->image_path ? asset('storage/' . $product->image_path) : '' }}"
                    class="{{ $product->image_path ? '' : 'hidden' }} w-24 h-24 object-cover border border-gray-300 rounded-md"
                >
            </div>
        </div>

        <div class="mb-4">
            <label for="video_path" class="block text-sm font-medium text-gray-700">Video</label>

            <input 
                type="file" 
                id="video_path" 
                name="video_path"
                accept="video/*"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2"
            >

            @error('video_path')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror

            <div class="mt-2">
                <video 
                    id="videoPreview"
                    src="{{ $product->video_path ? asset('storage/' . $product->video_path) : '' }}"
                    class="{{ $product->video_path ? '' : 'hidden' }} w-48 max-h-48 object-cover border border-gray-300 rounded-md"
                    controls
                ></video>
            </div>
        </div>


        <button 
            type="submit" 
            id="updateProductBtn"
            class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 flex items-center justify-center gap-2"
        >
            <span id="updateProductText">Update</span>

            <svg 
                id="updateProductSpinner"
                class="hidden animate-spin h-4 w-4 text-white"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
            >
                <circle class="opacity-25" cx="12" cy="12" r="10"
                    stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
        </button>

    </form>
</div>

<script>
    const imageInput = document.getElementById('image_path');
    const imagePreview = document.getElementById('imagePreview');
    const originalImage = imagePreview.src;

    const videoInput = document.getElementById('video_path');
    const videoPreview = document.getElementById('videoPreview');
    const originalVideo = videoPreview.src;

    // Image Preview
    imageInput.addEventListener('change', function () {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = originalImage;
            if (!originalImage) imagePreview.classList.add('hidden');
        }
    });

    // Video Preview
    videoInput.addEventListener('change', function () {
        const file = this.files[0];

        if (file) {
            const url = URL.createObjectURL(file);
            videoPreview.src = url;
            videoPreview.classList.remove('hidden');
        } else {
            videoPreview.src = originalVideo;
            if (!originalVideo) videoPreview.classList.add('hidden');
        }
    });

    document.addEventListener('DOMContentLoaded', function () {

        const form = document.getElementById('updateProductForm');
        const btn = document.getElementById('updateProductBtn');
        const text = document.getElementById('updateProductText');
        const spinner = document.getElementById('updateProductSpinner');

        if (!form) return;

        form.addEventListener('submit', function () {

            if (btn.disabled) return;

            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');

            text.textContent = 'Updating...';
            spinner.classList.remove('hidden');
        });

    });
</script>

@endsection
