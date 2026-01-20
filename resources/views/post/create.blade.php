@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8 mb-8 p-4 bg-gray-100 rounded shadow max-w-lg border border-gray-300">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Add to Community</h1>
    <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data" class="max-w-lg mx-auto">
        @csrf
        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
            <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <small class="text-gray-500">Only 1 photo allowed.</small>
        </div>
        <div class="mb-4">
            <label for="caption" class="block text-sm font-medium text-gray-700">Caption</label>
            <textarea name="caption" id="caption" maxlength="180" rows="3" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm resize-none"></textarea>
            <small class="text-gray-500">Maximum 180 characters.</small>
        </div>
       
        
        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Post</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.js"></script>
<script>
document.getElementById('image').addEventListener('change', async function(event) {
    const file = event.target.files[0];
    if (file) {
        try {
            const compressedFile = await imageCompression(file, {
                maxSizeMB: 1, // Maximum size in MB
                maxWidthOrHeight: 1920, // Maximum width or height
                useWebWorker: true
            });
            // Replace the file with compressed one
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(compressedFile);
            event.target.files = dataTransfer.files;
        } catch (error) {
            console.error('Error compressing image:', error);
        }
    }
});
</script>
@endsection
