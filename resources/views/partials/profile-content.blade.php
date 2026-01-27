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

        @auth
    {{-- JIKA PROFIL SENDIRI --}}
    @if(auth()->id() === $user->id)
        <div class="w-full px-4 mb-6">
            <table class="w-full border-collapse">
                <tr>
                    <td class="w-4/5">
                        <a href="{{ route('profile.edit') }}"
                           class="block w-full bg-blue-500 hover:bg-blue-600
                                  text-white font-bold py-3
                                  rounded-l-lg transition text-center">
                            Edit Profile 
                        </a>
                    </td>

                    <td class="w-1/5">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full h-full bg-red-500 hover:bg-red-600
                                           text-white py-3
                                           rounded-r-lg transition">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            </button>
                        </form>
                        
                    </td>
                    
                </tr>
            </table>
        </div>

        
        <div class="w-full max-w-lg p-4 sm:p-6 bg-neutral-primary-soft border border-default rounded-base shadow-xs">
            <h5 class="mb-2 text-base md:text-xl font-semibold text-heading">Connect wallet</h5>
            <p class="text-body">Connect with one of our available wallet providers or create a new one.</p>
            <ul class="my-6 space-y-3">
                <li>
                    <a href="#" class="flex items-center p-3 gap-3 text-lg font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 12v6a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h11l5 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 12h.01" />
                        </svg>

                        <span class="flex-1 text-left whitespace-nowrap">Wallet</span>
                        <span class="text-heading text-xs font-medium px-1.5 py-0.5">Rp {{ $user->balance }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile.edit') }}" class="flex items-center p-3 gap-3 text-lg font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 3.487a2.1 2.1 0 013.003 3.003L7.5 18.855 3 21l2.145-4.5L16.862 3.487z" />
                        </svg>
                        <span class="flex-1 text-left whitespace-nowrap">Edit profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('plant-submissions.index') }}" class="flex items-center p-3 text-lg gap-3 font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 20V10m0 0c-3 0-6-2-6-5 3 0 6 2 6 5zm0 0c3 0 6-2 6-5-3 0-6 2-6 5z" />
                        </svg>

                        <span class="flex-1 text-left whitespace-nowrap">My submissions</span>
                    </a>
                </li>
                @if(isset($user))
                <li>
                    <a href="{{ route('products.by.username', $user->username) }}" class="flex items-center p-3 text-lg gap-3 font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="flex-1 text-left whitespace-nowrap">My products</span>
                    </a>
                </li>
                @endif
                

            </ul>
                <div>
        
            </div>
        </div>

        <div class="w-full max-w-lg p-4 mt-3 sm:p-6 bg-neutral-primary-soft border border-default rounded-base shadow-xs">
            <ul class="my-6 space-y-3">
                <li>
                    <a href="#" class="flex items-center p-3 gap-3 text-lg font-semibold text-heading rounded-base bg-gray-50  hover:bg-green-50  group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                        </svg>

                        <span class="flex-1 text-left whitespace-nowrap">Dark mode</span>
                        <span class="text-heading text-xs font-medium px-1.5 py-0.5"> 
                            <button id="dark-mode-toggle" class="text-gray-700 text-lg">
                            <i class="fas fa-toggle-on"></i>
                            </button>
                    </span>
                    </a>
                </li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                            class="group flex w-full items-center gap-3 rounded-base p-3
                            text-lg font-semibold
                            bg-red-100 hover:bg-red-50
                            transition-colors rounded-full">

                            <!-- Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 shrink-0"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8">
                            <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h1a3 3 0 013 3v1" />
                            </svg>

                            <!-- Text -->
                            <span class="flex-1 text-left whitespace-nowrap">
                                Logout
                            </span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>


    {{-- JIKA PROFIL USER LAIN --}}
    @else
        <div class="w-full px-4 mb-6">

            {{-- CONTAINER TOMBOL (WAJIB untuk HTMX swap) --}}
            <div id="follow-button">
                @if(auth()->user()->isFollowing($user))
                    <button
                        hx-post="{{ route('profile.unfollow', $user) }}"
                        hx-target="#follow-button"
                        hx-swap="outerHTML"
                        hx-vals='{"_token":"{{ csrf_token() }}"}'
                        class="w-full font-bold py-3 rounded-lg transition
                               text-white bg-red-500 hover:bg-red-600">
                        Unfollow
                    </button>
                @else
                    <button
                        hx-post="{{ route('profile.follow', $user) }}"
                        hx-target="#follow-button"
                        hx-swap="outerHTML"
                        hx-vals='{"_token":"{{ csrf_token() }}"}'
                        class="w-full font-bold py-3 rounded-lg transition
                               text-white bg-green-500 hover:bg-green-600">
                        Follow
                    </button>
                @endif
            </div>

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
    
    @endif
@endauth


    </div>

    

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

<script>
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        const body = document.body;
        const isDarkMode = localStorage.getItem('darkMode') === 'true';
        if (isDarkMode) {
            body.classList.add('dark');
            if (darkModeToggle) darkModeToggle.innerHTML = '<i class="fas fa-toggle-off"></i>';
        } else {
            if (darkModeToggle) darkModeToggle.innerHTML = '<i class="fas fa-toggle-on"></i>';
        }
        if (darkModeToggle) {
            darkModeToggle.addEventListener('click', () => {
                const isDark = body.classList.toggle('dark');
                localStorage.setItem('darkMode', isDark);
                darkModeToggle.innerHTML = isDark ? '<i class="fas fa-toggle-off"></i>' : '<i class="fas fa-toggle-on"></i>';
            });
        }
    </script>
    
@endsection
