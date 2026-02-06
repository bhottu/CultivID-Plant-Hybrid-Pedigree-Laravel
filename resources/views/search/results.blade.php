@extends('layouts.app')

@section('content')
<div class="container mx-auto my-8 px-4 text-xs max-w-lg">
    <h1 class="text-xl mb-6 border-b pb-2">Search Results for: "{{ $query }}"</h1>

    {{-- PLANTS SECTION --}}
    <div class="mb-8">
        <h2 class="text-lg mb-4 text-gray-700">Plants found</h2>
        <div class="space-y-3"> {{-- Menggunakan space-y untuk jarak antar list --}}
            @forelse ($plantSubmissions as $submission)
                <div onclick="window.location='{{ route('plant-submissions.show', $submission) }}';" class="bg-white block rounded-lg shadow-sm border p-1 flex gap-4 items-center">
                    {{-- Thumbnail Kecil --}}
                    @php
                        $images = $submission->image ? json_decode($submission->image, true) : [];
                    @endphp
                    <div class="flex-shrink-0">
                        <a href="{{ route('plant-submissions.show', $submission) }}">
                            @if (!empty($images[0]))
                                <img src="{{ asset('storage/' . ltrim($images[0], '/')) }}" class="w-16 h-16 object-cover xs:p-2 rounded-md">
                            @else
                                <div class="w-16 h-16 rounded-md bg-gray-100 flex items-center justify-center text-xs text-gray-400 border border-dashed">No Image</div>
                            @endif
                        </a>
                    </div>
                    {{-- Info --}}
                    <div class="flex-grow">
                        {{-- Tampilkan nomor sertifikat jika ada --}}
                        @if($submission->certificate_number)
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-mono">
                                <i class="fas fa-certificate mr-1"></i>{{ $submission->certificate_number }} 
                            </span>  <span class="text-xs bg-red-100 text-green-700 px-2 py-0.5 rounded-full font-mono">Registered</span><br>
                        @endif
                        <a href="{{ route('plant-submissions.show', $submission) }}" class="text-gray-600 mt-3 font-semibold hover:underline text-sm italic">
                            {{ $submission->plant_id }}
                        </a>
                        <div class="flex gap-3 text-xxxs text-gray-500">
                            <span><i class="fas fa-venus text-red-500 mr-1"></i>{{ $submission->induk_betina ?? '-' }}</span> x
                            <span><i class="fas fa-mars text-blue-500 mr-1"></i>{{ $submission->induk_jantan ?? '-' }}</span>
                        </div>
                    </div>
                     <i class="fas fa-chevron-right text-gray-300 ml-3 p-2"></i>
                </div>
            @empty
                <p class="text-gray-500 italic">No plant / Hybrid found.</p>
            @endforelse
        </div>
    </div>

    {{-- PRODUCTS SECTION --}}
    <div class="mb-8">
        <h2 class="text-lg mb-4 text-gray-700">Products found</h2>
        <div class="space-y-3 text-xs">
            @forelse ($products as $product)
                <div class="bg-white rounded-lg shadow-sm border p-1 flex gap-4 items-center">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" class="w-16 h-16 object-cover rounded-md flex-shrink-0">
                    @endif
                    <div class="flex-grow">
                        <a href="{{ route('products.show', $product) }}" class="font-semibold text-gray-800 hover:text-blue-600 block">
                            {{ $product->name }}
                        </a>
                        <p class="text-gray-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    
                </div>
            @empty
                <p class="text-gray-500 italic">No products found.</p>
            @endforelse
        </div>
    </div>

    {{-- COMMUNITY POSTS SECTION --}}
    <div class="mb-8">
        <h2 class="text-lg mb-4 text-gray-700">Community Posts</h2>
        <div class="space-y-3">
            @forelse ($posts as $post)
                <a href="{{ route('post.show', $post->id) }}" class="bg-white rounded-lg shadow-sm border flex justify-between items-center hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3">
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="w-10 h-10 object-cover rounded">
                        @endif
                        <div class="flex flex-col leading-tight">
                            <span class="text-gray-700 truncate max-w-[200px]">{{ Str::words($post->caption, 5, '...') }}</span>
                            <span class="text-gray-700 truncate max-w-[200px] italic">by {{ $post->user->name }}</span>
                        </div>
                    </div>
                    
                </a>
            @empty
                <p class="text-gray-500 italic">No discuss found.</p>
            @endforelse
        </div>
    </div>

    {{-- USERS SECTION --}}
    <div class="mb-8">
        <h2 class="text-lg mb-4 text-gray-700">Users</h2>
        <div class="space-y-3">
            @forelse ($users as $user)
            
                <div onclick="window.location='{{ route('profile', $user->username) }}';" class="bg-white rounded-lg shadow-sm border flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : '/storage/images/default.png' }}" 
                             class="w-10 h-10 rounded-lg object-cover border">
                        <div>
                            <a href="{{ route('profile', $user->username) }}" class="font-bold text-gray-800 hover:underline">{{ $user->name }}</a>
                            <p class="text-gray-500 text-[10px]">{{ $user->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('profile', $user->username) }}" class="text-blue-500 text-[10px] p-2">Visit</a>
                </div>
            @empty
                <p class="text-gray-500 italic">No users found.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection