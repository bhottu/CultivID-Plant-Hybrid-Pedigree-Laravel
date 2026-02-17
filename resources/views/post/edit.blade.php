@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="container mx-auto mb-8 p-4 max-w-lg">
   
        
            <h1 class="text-sm mb-4 bg-red-100 text-gray-800 font-semibold">Edit Post</h1>
            <form id="editPostForm" action="{{ route('post.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

               <div class="mb-2">
                    <label for="caption" class="sr-only">Caption</label>
                    <textarea 
                        name="caption" 
                        id="caption" 
                        maxlength="180"
                        placeholder="Caption"
                        rows="1"
                        oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"
                        class="w-full border-b border-gray-300 focus:outline-none focus:border-indigo-500 pb-1 resize-none overflow-hidden"
                    >{{ $post->caption }}</textarea>
                </div>



               <div class="mb-2">
                    <label for="image" class="sr-only">Image</label>

                    <input 
                        type="file" 
                        name="image" 
                        id="image" 
                        class="hidden" 
                        accept="image/*"
                    >

                    <label 
                        for="image" 
                        class="inline-block bg-gray-200 hover:bg-gray-300 py-2 px-4 rounded-md cursor-pointer transition"
                    >
                        Change Image
                    </label>

                    <!-- Preview -->
                    <div class="mt-2">
                        <img 
                            id="imagePreview"
                            src="{{ $post->image ? asset('storage/' . $post->image) : '' }}"
                            class="{{ $post->image ? '' : 'hidden' }} w-24 max-h-24 object-cover rounded-md border border-gray-200"
                        >
                    </div>
                </div>

                <button 
                    type="submit" 
                    id="editPostBtn"
                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline flex items-center justify-center gap-2"
                >
                    <span id="editPostText">Save</span>

                    <svg 
                        id="editPostSpinner"
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
    const originalImage = imagePreview.src;

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

            if (!originalImage) {
                imagePreview.classList.add('hidden');
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function () {

        const form = document.getElementById('editPostForm');
        const btn = document.getElementById('editPostBtn');
        const text = document.getElementById('editPostText');
        const spinner = document.getElementById('editPostSpinner');

        if (!form) return;

        form.addEventListener('submit', function () {

            if (btn.disabled) return;

            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');

            text.textContent = 'Saving...';
            spinner.classList.remove('hidden');
        });

    });
</script>
@endsection
