@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Tambah Tanaman Baru</h1>

    <form action="{{ route('plants.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 border-2 border-gray-300 p-6 rounded-lg shadow-sm">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="common_name" class="block text-sm font-medium text-gray-700">Nama Umum</label>
                <input type="text" id="common_name" name="common_name" value="{{ old('common_name') }}" 
                    class="mt-1 block w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                @error('common_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label for="genus" class="block text-sm font-medium text-gray-700">Genus</label>
                <input type="text" id="genus" name="genus" value="{{ old('genus') }}" 
                    class="mt-1 block w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                @error('genus') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="family" class="block text-sm font-medium text-gray-700">Keluarga</label>
                <input type="text" id="family" name="family" value="{{ old('family') }}" 
                    class="mt-1 block w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                @error('family') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="origin" class="block text-sm font-medium text-gray-700">Asal</label>
                <input type="text" id="origin" name="origin" value="{{ old('origin') }}" 
                    class="mt-1 block w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                @error('origin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="breeder" class="block text-sm font-medium text-gray-700">Breeder</label>
                <input type="text" id="breeder" name="breeder" value="{{ old('breeder') }}" 
                    class="mt-1 block w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                @error('breeder') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="female_parents_id" class="block text-sm font-medium text-gray-700">Female Parent</label>
                <select id="female_parents_id" name="female_parents_id" 
                    class="mt-1 block w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="" disabled selected>Pilih Female Parent</option>
                    @foreach ($plants as $plant)
                        <option value="{{ $plant->id }}" {{ old('female_parents_id') == $plant->id ? 'selected' : '' }}>
                            {{ $plant->common_name }}
                        </option>
                    @endforeach
                </select>
                @error('female_parents_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="male_parents_id" class="block text-sm font-medium text-gray-700">Male Parent</label>
                <select id="male_parents_id" name="male_parents_id" 
                    class="mt-1 block w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="" disabled selected>Pilih Male Parent</option>
                    @foreach ($plants as $plant)
                        <option value="{{ $plant->id }}" {{ old('male_parents_id') == $plant->id ? 'selected' : '' }}>
                            {{ $plant->common_name }}
                        </option>
                    @endforeach
                </select>
                @error('male_parents_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea id="description" name="description" rows="4" 
                class="mt-1 block w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>{{ old('description') }}</textarea>
            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="photos" class="block text-sm font-medium text-gray-700">Foto</label>
            <input type="file" id="photos" name="photos[]" multiple 
                class="mt-1 block w-full px-4 py-2 border-2 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
            @error('photos') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-md hover:bg-blue-600 transition duration-200">Simpan Tanaman</button>
        </div>
    </form>
</div>
@endsection
