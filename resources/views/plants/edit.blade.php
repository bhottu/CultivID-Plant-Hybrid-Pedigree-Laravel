@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Edit Tanaman: {{ $plant->common_name }}</h1>

    <form action="{{ route('plants.update', $plant->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Same input fields as the create form, but pre-filled with plant data -->
            <div>
                <label for="common_name" class="block text-sm font-medium text-gray-700">Nama Umum</label>
                <input type="text" id="common_name" name="common_name" value="{{ old('common_name', $plant->common_name) }}" class="mt-1 block w-full px-4 py-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                @error('common_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Other input fields similar to create -->
        </div>

        <!-- Add photo section -->
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-md hover:bg-blue-600 transition duration-200">Perbarui Tanaman</button>
        </div>
    </form>
</div>
@endsection
