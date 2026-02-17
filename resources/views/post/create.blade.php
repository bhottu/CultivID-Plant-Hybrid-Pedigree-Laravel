@extends('layouts.app')

@section('content')
<div class="container mx-auto mb-8 p-4 max-w-lg">
    <h1 class="text-sm mb-4 bg-red-100 text-gray-800 font-semibold">Add to Community</h1>
    
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="createPostForm" action="{{ route('post.store') }}" method="post" enctype="multipart/form-data" class="max-w-lg mx-auto">
        @csrf
        
        <div class="mb-4">
            <label for="caption" class="block text-sm font-medium text-gray-700">Caption</label>
            <textarea 
            name="caption" 
            id="caption" 
            maxlength="180" 
            rows="1" 
            oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"
            class="w-full border-b border-gray-300 focus:outline-none focus:border-indigo-500 pb-1 resize-none overflow-hidden"></textarea>
            <small class="text-gray-500">Maximum 180 characters.</small>
        </div>
       
        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
            
            <input 
                type="file" 
                name="image" 
                id="image" 
                accept="image/*"
                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >

            <small class="text-gray-500">Only 1 photo allowed.</small>

            <!-- Preview -->
            <div class="mt-3">
                <img id="imagePreview" class="hidden w-24 max-h-24 object-cover rounded-md border border-gray-200" />
            </div>
        </div>
        
        <button 
            type="submit" 
            id="createPostBtn"
            class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline flex items-center justify-center gap-2"
        >
            <span id="createPostText">Post</span>

            <svg 
                id="createPostSpinner"
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

 const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');

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

    document.addEventListener('DOMContentLoaded', function () {

        const form = document.getElementById('createPostForm');
        const btn = document.getElementById('createPostBtn');
        const text = document.getElementById('createPostText');
        const spinner = document.getElementById('createPostSpinner');

        if (!form) return;

        form.addEventListener('submit', function () {

            if (btn.disabled) return;

            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');

            text.textContent = 'Posting...';
            spinner.classList.remove('hidden');
        });

    });
</script>
@endsection
