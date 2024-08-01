@extends('admin.layout')

@section('content')


    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Settings</h1>
        @if (session('success'))
            <div class="bg-green-500 text-white p-2 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Website Name -->
            <div class="mb-4">
                <label for="website_name" class="block text-lg text-gray-700">Website Name</label>
                <input type="text" name="website_name" id="website_name" class="w-full border-double border-2 border-gray-300 rounded-md" value="{{ $settings->website_name ?? '' }}">
            </div>

            <!-- Web Description -->
            <div class="mb-4">
                <label for="web_description" class="blocktext-lg  text-gray-700">Website Description</label>
                <textarea name="web_description" id="web_description" class="w-full border-double border-2 border-gray-300 rounded-md">{{ $settings->web_description ?? '' }}</textarea>
            </div>

          
            <input type="text" name="currency" id="currency" class="hidden" value="Null">
            

            <!-- Add Logo -->
            <div class="mb-4">
                <label for="logo" class="block text-lg text-gray-700">Add Logo</label>
                <input type="file" name="logo" id="logo" class="w-full border-double border-2 border-gray-300 rounded-md">
                @if ($settings && $settings->logo)
                    <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo" class="w-auto h-20 mt-2">
                @endif
            </div>

            <!-- Banner -->
            <div class="mb-4">
                <label for="banner" class="block text-lg text-gray-700">Banner</label>
                <input type="file" name="banner" id="banner" class="w-full border-double border-2 border-gray-300 rounded-md">
                @if ($settings && $settings->banner)
                    <img src="{{ asset('storage/' . $settings->banner) }}" alt="Banner" class="w-auto h-20 mt-2">
                @endif
            </div>

            <!-- Fav Icon -->
            <div class="mb-4">
                <label for="fav_icon" class="block text-lg text-gray-700">Fav Icon</label>
                <input type="file" name="fav_icon" id="fav_icon" class="w-full border-double border-2 border-gray-300 rounded-md">
                @if ($settings && $settings->fav_icon)
                    <img src="{{ asset('storage/' . $settings->fav_icon) }}" alt="Fav Icon" class="w-auto h-20 mt-2">
                @endif
            </div>            

            <!-- Social Media -->
            <div class="mb-4">
                <label for="social_media" class="block text-lg text-gray-700">Social Media</label>
                <input type="text" name="social_media" id="social_media" class="w-full border-double border-2 border-gray-300 rounded-md" value="{{ $settings->social_media ?? '' }}">
            </div>

            <!-- Contact Us -->
            <div class="mb-4">
                <label for="contact_us" class="block text-lg text-gray-700">Contact Us</label>
                <textarea name="contact_us" id="contact_us" class="w-full border-double border-2 border-gray-300 rounded-md">{{ $settings->contact_us ?? '' }}</textarea>
            </div>

            <!-- About Us -->
            <div class="mb-4">
                <label for="about_us" class="block text-lg text-gray-700">About Us</label>
                <textarea name="about_us" id="about_us" class="w-full border-double border-2 border-gray-300 rounded-md">{{ $settings->about_us ?? '' }}</textarea>
            </div>
            
            <!-- Terms & Conditions -->
            <div class="mb-4">
                <label for="terms_conditions" class="block text-lg text-gray-700">Terms & Conditions</label>
                <textarea name="terms_conditions" id="terms_conditions" class="w-full border-double border-2 border-gray-300 rounded-md">{{ $settings->terms_conditions ?? '' }}</textarea>
            </div>

            <!-- Privacy Policy -->
            <div class="mb-4">
                <label for="privacy_policy" class="block text-lg text-gray-700">Privacy Policy</label>
                <textarea name="privacy_policy" id="privacy_policy" class="w-full border-double border-2 border-gray-300 rounded-md">{{ $settings->privacy_policy ?? '' }}</textarea>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Save</button>
        </form>
    </div>

   
    <script>
    CKEDITOR.replace('terms_conditions', {
        extraPlugins: 'notification',
        // konfigurasi tambahan lainnya
    });
    CKEDITOR.replace('privacy_policy', {
        extraPlugins: 'notification',
        // konfigurasi tambahan lainnya
    });
    CKEDITOR.replace('about_us', {
        extraPlugins: 'notification',
        // konfigurasi tambahan lainnya
    });
    CKEDITOR.replace('contact_us', {
        extraPlugins: 'notification',
        // konfigurasi tambahan lainnya
    });

    </script>
    

@endsection
