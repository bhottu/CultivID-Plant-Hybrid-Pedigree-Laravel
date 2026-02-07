@extends('layouts.app')

@section('title', $user->name . "'s Profile")

@section('content')

<div class="container px-4 mx-auto max-w-lg text-xs">
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
        

        
        <div class="w-full max-w-lg p-4 sm:p-6 bg-neutral-primary-soft border border-default rounded-base shadow-xs">
           
            <ul class="my-6 space-y-3">
                <li>
                    <a href="{{ route('wallet.index') }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 12v6a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h11l5 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 12h.01" />
                        </svg>

                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Wallet</span>  
                        <span class="text-heading text-xs font-medium px-1.5 py-0.5 text-gray-700 dark:text-gray-400">Rp {{ number_format($user->balance, 0, ',', '.') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile.edit') }}" class="flex dark:text-gray-400 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50  group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 3.487a2.1 2.1 0 013.003 3.003L7.5 18.855 3 21l2.145-4.5L16.862 3.487z" />
                        </svg>
                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Edit profile</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="w-full max-w-lg p-4 mt-3 sm:p-6 bg-neutral-primary-soft border border-default rounded-base shadow-xs">
            <ul class="my-6 space-y-3">
                <li>
                    <a href="{{ route('plant-submissions.index') }}" class="flex dark:text-gray-400 dark:bg-gray-700 items-center p-2 text-sm gap-2 font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 20V10m0 0c-3 0-6-2-6-5 3 0 6 2 6 5zm0 0c3 0 6-2 6-5-3 0-6 2-6 5z" />
                        </svg>

                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">My submissions</span>
                    </a>
                </li>
                @if(isset($user))
                 <li>
                    <a href="{{ route('posts.by.username', $user->username) }}" class="flex dark:text-gray-400 dark:bg-gray-700 items-center p-2 text-sm gap-3 font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-6 h-6 text-gray-700 dark:text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 4h6m-6 4h6m-6 4h6M5 20h14a1 1 0 001-1V7l-5-5H6a1 1 0 00-1 1v16a1 1 0 001 1z" />
                        </svg>

                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">My posts</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('products.by.username', $user->username) }}" class="flex dark:text-gray-400 dark:bg-gray-700 items-center p-2 text-sm gap-3 font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group">
                        <svg class="w-6 h-6 text-gray-700 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">My products</span>
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
                    <a href="{{ route('admin.settings.contact') }}" class="flex dark:text-gray-400 dark:bg-gray-700 items-center p-2 text-sm gap-3 font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>

                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Contact Us</span>
                        
                    </a>
                </li>

                 <li>
                    <a href="{{ route('admin.settings.about') }}" class="flex dark:text-gray-400 dark:bg-gray-700 items-center p-2 text-sm gap-3 font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-6 h-6 text-gray-700 dark:text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11v5"/>
                        <circle cx="12" cy="8" r="1"/>
                        </svg>

                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">About Us</span>
                        
                    </a>
                </li>

            </ul>
        </div>

        <div class="w-full max-w-lg p-4 mt-3 sm:p-6 bg-neutral-primary-soft border border-default rounded-base shadow-xs">
            <ul class="my-6 space-y-3">
                <li>
                    <div class="flex dark:text-gray-400 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50  hover:bg-green-50  group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                        </svg>

                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Dark mode</span>
                        <span class="text-heading text-xs font-medium px-1.5 py-0.5"> 
                            <button id="dark-mode-toggle" class="text-gray-700 dark:text-gray-400 text-sm">
                            <i class="fas fa-toggle-on"></i>
                            </button>
                    </span>
                    </div>
                </li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                            class="group flex w-full items-center gap-3 rounded-base p-2
                            text-sm font-semibold
                            bg-red-100 hover:bg-red-50
                            transition-colors rounded-full">

                            <!-- Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 shrink-0 text-gray-700"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8">
                            <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h1a3 3 0 013 3v1" />
                            </svg>

                            <!-- Text -->
                            <span class="flex-1 text-left whitespace-nowrap text-gray-700">
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

    <div class="mt-6 px-2">
    <div class="flex border-b border-gray-200">
        <button onclick="switchTab(event, 'tab-plants')" class="tab-btn active-tab px-4 py-2 font-bold text-sm text-blue-600 border-b-2 border-blue-600 transition">
            Plants
        </button>
        <button onclick="switchTab(event, 'tab-posts')" class="tab-btn px-4 py-2 font-medium text-sm text-gray-500 hover:text-blue-600 transition">
            Posts
        </button>
        <button onclick="switchTab(event, 'tab-products')" class="tab-btn px-4 py-2 font-medium text-sm text-gray-500 hover:text-blue-600 transition">
            Products
        </button>
    </div>
</div>

<div id="tab-container" class="mt-4">
    
    <div id="tab-plants" class="tab-content">
        @if($plantSubmissions && !$plantSubmissions->isEmpty())
            <div id="plant-submission-list-on-profile" class="flex flex-col gap-1 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                @include('partials.plant_submissions', ['plantSubmissions' => $plantSubmissions])
            </div>
            @if ($plantSubmissions->hasMorePages())
            <div class="flex justify-center mt-4 pb-6">
                <button id="load-more-plant-submission-profile" class="bg-gray-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg text-xs">
                    Load More Plants
                </button>
            </div>
            @endif
        @else
            <p class="text-center text-gray-400 py-10 text-xs">No plant submissions yet.</p>
        @endif
    </div>

    <div id="tab-posts" class="tab-content hidden">
        @if(!$user->posts->isEmpty())
            <div id="post-list-on-profile" class="flex flex-col bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                @include('partials.posts', ['posts' => $posts])
            </div>
            @if ($posts->hasMorePages())
            <div class="flex justify-center mt-4 pb-6">
                <button id="load-more-post-profile" class="bg-gray-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg text-xs">Load More Posts</button>
            </div>
            @endif
        @else
            <p class="text-center text-gray-400 py-10 text-xs">No posts yet.</p>
        @endif
    </div>

    <div id="tab-products" class="tab-content hidden">
        @if(!$user->products->isEmpty())
            <div id="product-list-on-profile" class="grid grid-cols-2 gap-3 px-1">
                @include('partials.products', ['products' => $products])
            </div>
            @if ($products->hasMorePages())
            <div class="flex justify-center mt-6 pb-10">
                <button id="load-more-product-profile" class="bg-gray-800 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg text-xs transition">
                    Load More Products
                </button>
            </div>
            @endif
        @else
            <p class="text-center text-gray-400 py-10 text-xs">No products yet.</p>
        @endif
    </div>
</div>
        
        @endif
    @endauth


    </div>

    
<script>
function switchTab(event, tabId) {
    // 1. Sembunyikan semua konten tab
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(content => content.classList.add('hidden'));

    // 2. Hapus status aktif dari semua tombol tab
    const buttons = document.querySelectorAll('.tab-btn');
    buttons.forEach(btn => {
        btn.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600', 'font-bold');
        btn.classList.add('text-gray-500', 'font-medium');
    });

    // 3. Tampilkan tab yang dipilih
    document.getElementById(tabId).classList.remove('hidden');

    // 4. Set tombol yang diklik menjadi aktif
    event.currentTarget.classList.add('text-blue-600', 'border-b-2', 'border-blue-600', 'font-bold');
    event.currentTarget.classList.remove('text-gray-500', 'font-medium');
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gunakan variabel terpisah untuk setiap fitur
    let postPage = 1;
    let plantPage = 1;
    const userId = "{{ $user->username }}";
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // 1. Logic untuk Load More Posts
    const loadMorePostButton = document.getElementById('load-more-post-profile');
    if (loadMorePostButton) {
        loadMorePostButton.addEventListener('click', function() {
            postPage++; // Gunakan postPage
            const nextPageUrl = `/discuss/${userId}/load?page=${postPage}`;

            fetch(nextPageUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                const postList = document.getElementById('post-list-on-profile');
                // Pastikan data.html tidak undefined
                if (data.html) {
                    postList.insertAdjacentHTML('beforeend', data.html);
                }
                
                // Cek ketersediaan halaman berikutnya dari response controller
                if (!data.hasMorePages) { 
                    loadMorePostButton.parentElement.remove(); // Hapus container tombol
                }
            })
            .catch(error => console.error('Error loading more posts:', error));
        });
    }

    // 2. Logic untuk Load More Plant Submissions
    const loadMorePlantButton = document.getElementById('load-more-plant-submission-profile');
    if (loadMorePlantButton) {
        loadMorePlantButton.addEventListener('click', function() {
            plantPage++; // Gunakan plantPage
            const nextPageUrl = `/profile/${userId}/plant-submissions/load?page=${plantPage}`;

            fetch(nextPageUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                const submissionList = document.getElementById('plant-submission-list-on-profile');
                
                if (data.html) {
                    submissionList.insertAdjacentHTML('beforeend', data.html);
                }

                // Jika controller mengirim nextPageUrl null atau false
                if (!data.hasMorePages) {
                    loadMorePlantButton.parentElement.remove();
                }
            })
            .catch(error => console.error('Error loading more plant submissions:', error));
        });
    }
});


document.addEventListener('DOMContentLoaded', function() {
    const username = "{{ $user->username }}";
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Helper Function untuk Fetch
    function setupLoadMore(buttonId, listId, urlBase, currentPage) {
        const btn = document.getElementById(buttonId);
        const list = document.getElementById(listId);
        let page = currentPage;

        if (btn) {
            btn.addEventListener('click', function() {
                page++;
                console.log(`Loading ${urlBase} page: ${page}`);

                fetch(`${urlBase}?page=${page}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.html && data.html.trim() !== "") {
                        list.insertAdjacentHTML('beforeend', data.html);
                    }
                    if (!data.hasMorePages) {
                        btn.parentElement.remove();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    page--;
                });
            });
        }
    }

    // Eksekusi untuk masing-masing bagian
    setupLoadMore('load-more-post-profile', 'post-list-on-profile', `/discuss/${username}/load`, 1);
    setupLoadMore('load-more-plant-submission-profile', 'plant-submission-list-on-profile', `/profile/${username}/plant-submissions/load`, 1);
    setupLoadMore('load-more-product-profile', 'product-list-on-profile', `/profile/${username}/products/load`, 1);
});

</script>


    
@endsection
