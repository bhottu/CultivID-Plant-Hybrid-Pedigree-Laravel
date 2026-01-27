@extends('layouts.app')

@section('content')
<div class="container max-w-lg mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Edit Product</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <a href="{{ route('products.show', $product) }}" class=" text-gray-800 hover:bg-gray-200">View Product</a>
        </div>
    @endif

    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
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
            <input type="file" id="image_path" name="image_path" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2">
            @error('image_path')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
            @if($product->image_path)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="Product Image" class="w-32 h-32 object-cover border border-gray-300 rounded-md">
                </div>
            @endif
        </div>

        <div class="mb-4">
            <label for="video_path" class="block text-sm font-medium text-gray-700">Video</label>
            <input type="file" id="video_path" name="video_path" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2">
            @error('video_path')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
            @if($product->video_path)
                <div class="mt-2">
                    <video src="{{ asset('storage/' . $product->video_path) }}" controls class="w-full border border-gray-300 rounded-md"></video>
                </div>
            @endif
        </div>

        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Update</button>
    </form>
</div>
@endsection
