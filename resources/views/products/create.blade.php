@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8 mb-8 p-4 max-w-lg">
    <form id="addProductForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto">
        @if ($errors->any())
            <div class="mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-red-600">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        
        <h1 class="text-sm mb-4 font-semibold bg-red-100 text-gray-800">Add Product</h1>
        @csrf
        <div class="mb-4">
            <label for="image" class="block text-gray-800 font-semibold">Image</label>
            <input 
                type="file" 
                name="image" 
                id="image" 
                accept="image/*"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >

            <!-- Image Preview -->
            <div class="mt-3">
                <img id="imagePreview" class="hidden w-24 max-h-24 object-cover rounded-md border border-gray-200">
            </div>
        </div>

        <div class="mb-4">
            <label for="video" class="block text-gray-800 font-semibold">Video</label>
            <input 
                type="file" 
                name="video" 
                id="video" 
                accept="video/*"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >

            <!-- Video Preview -->
            <div class="mt-3">
                <video 
                    id="videoPreview" 
                    class="hidden w-48 max-h-48 rounded-md border border-gray-200"
                    controls
                ></video>
            </div>
        </div>
        <div class="mb-4">
            <label for="name" class="block text-gray-800 font-semibold">Product Name</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('name') }}">
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-800 font-semibold">Description</label>
            <textarea name="description" id="description" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
        </div>
        <div class="mb-4">
            <label for="price" class="block text-gray-800 font-semibold">Price</label>
            <input type="number" name="price" id="price" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('price') }}">
        </div>
        <div class="mb-4">
            <label for="discount" class="block text-gray-800 font-semibold">Discount (%)</label>
            <input type="number" name="discount" id="discount" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('discount') }}">
        </div>
        <div class="mb-4">
            <label for="category_id" class="block text-gray-800 font-semibold">Category</label>
            <select name="category_id" id="category_id" class="mt-1 text-gray-900  block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        
        <button 
            type="submit" 
            id="addProductBtn"
            class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline flex items-center justify-center gap-2"
        >
            <span id="addProductText">Add Product</span>

            <svg 
                id="addProductSpinner"
                class="hidden animate-spin h-5 w-5 text-white"
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
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');

    const videoInput = document.getElementById('video');
    const videoPreview = document.getElementById('videoPreview');

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
            imagePreview.src = '';
            imagePreview.classList.add('hidden');
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
            videoPreview.src = '';
            videoPreview.classList.add('hidden');
        }
    });

    document.addEventListener('DOMContentLoaded', function () {

        const form = document.getElementById('addProductForm');
        const btn = document.getElementById('addProductBtn');
        const text = document.getElementById('addProductText');
        const spinner = document.getElementById('addProductSpinner');

        if (!form) return;

        form.addEventListener('submit', function () {

            if (btn.disabled) return;

            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');

            text.textContent = 'Adding...';
            spinner.classList.remove('hidden');
        });

    });

</script>

@endsection
