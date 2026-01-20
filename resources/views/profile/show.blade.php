@extends('layouts.app')

@section('title', $user->name . "'s Profile")

@section('content')

<div class="container px-4 mx-auto max-w-lg">
    <!-- Profile Header -->
    <div class="py-6 text-center">
        <!-- Avatar -->
        <div class="flex justify-center mb-4">
            @if($user->profile_photo_path)
                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover border-2 border-blue-500">
            @else
                <div class="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center text-white text-2xl font-bold border-2 border-blue-500">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
        </div>

        <!-- User Info -->
        <h1 class="text-xl font-bold mb-1">{{ $user->name }} </h1>
        <p class="text-gray-500 text-sm mb-2" id="followers-count">
            <i class="fas fa-users text-blue-500"></i> {{ $user->followers()->count() }} Followers
        </p>
        <p class="text-gray-500 text-xs mb-4">({{ $user->email }})</p>

        <!-- Contact Icons -->
        <div class="flex justify-center gap-4 mb-6">
            @if($user->phone_number)
                <a href="tel:{{ $user->phone_number }}" title="Call" class="text-blue-500 hover:text-blue-700 text-lg transition">
                    <i class="fas fa-phone"></i>
                </a>
            @endif
            <a href="mailto:{{ $user->email }}" title="Email" class="text-blue-500 hover:text-blue-700 text-lg transition">
                <i class="fas fa-envelope"></i>
            </a>
            @if($user->phone_number)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->phone_number) }}" target="_blank" title="WhatsApp" class="text-green-500 hover:text-green-700 text-lg transition">
                    <i class="fab fa-whatsapp"></i>
                </a>
            @endif
        </div>

        <!-- Edit Profile / Follow Button -->
        @auth
            @if(Auth::id() === $user->id)
                <a href="{{ route('profile.edit') }}" class="block w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-lg transition mb-6 text-center">Edit Profile</a>
            @else
                <button id="follow-button" hx-post="{{ Auth::user()->following->contains($user->id) ? route('profile.unfollow', $user) : route('profile.follow', $user) }}" hx-target="#follow-button" hx-swap="outerHTML" hx-vals='{"_token": "{{ csrf_token() }}"}' class="w-full font-bold py-3 rounded-lg transition mb-6 text-white @if(Auth::user()->following->contains($user->id)) bg-red-500 hover:bg-red-600 @else bg-green-500 hover:bg-green-600 @endif">
                    {{ Auth::user()->following->contains($user->id) ? 'Unfollow' : 'Follow' }}
                </button>
            @endif
        @else
            <a href="{{ route('login') }}" class="block w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-lg transition mb-6 text-center">Follow</a>
        @endauth
    </div>

    <!-- Plant Submissions Section -->
    @if($plantSubmissions && !$plantSubmissions->isEmpty())
    <div class="mt-6">
        <h2 class="text-lg font-bold mb-4">Plant Submissions</h2>
        <div id="plant-submission-list-on-profile" class="grid grid-cols-2 gap-3">
            @include('partials.plant_submissions', ['plantSubmissions' => $plantSubmissions])
        </div>
        @if ($plantSubmissions->hasMorePages())
        <div class="flex justify-center mt-4">
            <button id="load-more-plant-submission-profile" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg">Load More</button>
        </div>
        @endif
    </div>
    @endif

    <!-- Posts Section -->
    @if(!$user->posts->isEmpty())
    <div class="mt-8 mb-6">
        <h2 class="text-lg font-bold mb-4">Posts</h2>
        <div id="post-list-on-profile" class="space-y-4">
            @include('partials.posts', ['posts' => $posts])
        </div>
        @if ($posts->hasMorePages())
        <div class="flex justify-center mt-4">
            <button id="load-more-post-profile" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg">Load More</button>
        </div>
        @endif
    </div>
    @endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    const userId = {{ $user->id }};


    const loadMorePostButton = document.getElementById('load-more-post-profile');
    if (loadMorePostButton) {
        loadMorePostButton.addEventListener('click', function() {
            currentPage++;
            const nextPageUrl = `/discuss/${userId}/load?page=${currentPage}`;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(nextPageUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                const postList = document.getElementById('post-list-on-profile');
                postList.insertAdjacentHTML('beforeend', data.html);
                if (!data.nextPageUrl) {
                    loadMorePostButton.style.display = 'none';
                }
            })
            .catch(error => console.error('Error loading more posts:', error));
        });
    }

    const loadMorePlantButton = document.getElementById('load-more-plant-submission-profile');
    if (loadMorePlantButton) {
        loadMorePlantButton.addEventListener('click', function() {
            currentPage++;
            const nextPageUrl = `/profile/${userId}/plant-submissions/load?page=${currentPage}`;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(nextPageUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                const submissionList = document.getElementById('plant-submission-list-on-profile');
                submissionList.insertAdjacentHTML('beforeend', data.html);
                if (!data.nextPageUrl) {
                    loadMorePlantButton.style.display = 'none';
                }
            })
            .catch(error => console.error('Error loading more plant submissions:', error));
        });
    }
});
</script>
    
@endsection
