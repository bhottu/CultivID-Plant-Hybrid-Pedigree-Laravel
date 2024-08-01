@extends('layouts.app')

@section('title', $user->name . "'s Profile")

@section('content')

<div class="container mx-auto">
    <div class="m-4 mx-auto rounded-md overflow-hidden">
        <h2 class="text-xl font-semibold">{{ $user->name }}'s Profile</h2>
    </div>
    <div class="bg-blue-100 shadow-md border-dashed border-2 border-sky-500 rounded p-4 mt-4 flex ">
        @if($user->profile_photo_path)
            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}'s Profile Photo" class="h-52 w-52 border-double border-2 border-sky-500 rounded-full">
        @else
            <img src="/storage/images/default.png" alt="{{ $user->name }}'s Profile Photo" class="h-auto w-32 rounded">
        @endif

        <div class="flex ml-4 flex-grow">
                <!-- Kontainer untuk detail profil -->
            <div class="flex-1 pr-4">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-900 font-semibold text-3xl">{{ $user->name }}</span>
                        
                    </div>

                    <div class="text-gray-500 text-sm mb-2">{{ $user->email }}</div>
                    <div class="text-gray-500 text-sm mb-2">{{ $user->phone_number }}</div>
                    <div class="text-sm flex items-center space-x-2 mb-2">
                        @if($user->phone_number)
                            <a href="https://wa.me/{{ $user->phone_number }}" class="hover:text-gray-500">
                                <button class="fab fa-whatsapp hover:text-green-500 text-blue-900 text-2xl"></button>
                            </a>
                            <a href="tel:{{ $user->phone_number }}" class="hover:text-gray-500">
                                <button class="fas fa-phone-alt hover:text-green-500 text-blue-900 text-2xl"></button>
                            </a>
                        @else
                            <a href="#" class="hover:text-gray-500">
                                <button onclick='alert("The seller has not entered a phone number.")' class="fab fa-whatsapp hover:text-green-500 text-blue-900 text-2xl"></button>
                            </a>
                            <a href="#" class="hover:text-gray-500">
                                <button onclick='alert("The seller has not entered a phone number.")' class="fas fa-phone-alt hover:text-green-500 text-blue-900 text-2xl"></button>
                            </a>
                        @endif
                        <a href="mailto:{{ $user->email }}" class="hover:text-gray-500">
                            <button class="fas fa-envelope hover:text-green-500 text-blue-900 text-2xl"></button>
                        </a>
                    </div>
                    <div class="text-gray-500 text-sm mb-2" id="followers-count">{{ $user->followers()->count() }} Followers</div>
                    <div class="text-gray-500 text-sm">
                        @auth
                            @if(Auth::id() !== $user->id)
                                @if(Auth::user()->following->contains($user->id))
                                    <form action="{{ route('profile.unfollow', $user->id) }}" method="POST">
                                        @csrf
                                        <button id="follow-button" type="submit" class="bg-red-500 hover:bg-red-200 hover:text-red-900 text-white px-2 py-1 rounded">Unfollow</button>
                                    </form>
                                @else
                                    <form action="{{ route('profile.follow', $user->id) }}" method="POST">
                                        @csrf
                                        <button id="follow-button" type="submit" class="bg-blue-500 hover:bg-blue-200 hover:text-blue-900 text-white px-2 py-1 rounded">Follow</button>
                                    </form>
                                @endif
                            @endif
                        @else
                            <p class="text-gray-700">
                                <a class="hover:text-blue-500 text-blue-900" href="{{ route('login') }}">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-200 hover:text-blue-900 text-white px-2 py-1 rounded">Follow</button>
                                </a> 
                                Login to follow this user
                            </p>
                        @endauth
                    </div>
            </div>

                <!-- Kontainer untuk peta -->
                <div class="w-48 h-48 ">
                    <div id="map" class="rounded" style="height: 100%; width: 100%;"></div>
                    <div class="text-gray-500 text-sm text-center">Member since {{ $user->created_at->format('F Y') }}</div>
                </div>
            


        </div>
    </div>
</div>


<div class="container mx-auto flex flex-wrap">
    
    <div class="w-full md:w-2/3 border mt-4 p-4">
        <div class="m-4 mx-auto rounded-md overflow-hidden">
            <h2 class="text-xl font-semibold">{{ $user->name }}'s Products</h2>
        </div>
        
        @if ($products->isEmpty())
            <p>No product yet, <a href="{{ route('products.create') }}" class="text-red-500 rounded bg-blue-200 hover:bg-gray-200">Send now</a></p>
        @else
            <div id="product-list-profile" class=" grid grid-cols-1 md:grid-cols-2 gap-4">
                @include('partials.products', ['products' => $products])
            </div>
            @if ($products->hasMorePages())
                <div class="text-center mt-4">
                    <button id="load-more-products" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Load More
                    </button>
                </div>
            @endif
        @endif
    </div>
    
    <!-- Profil pengguna lainnya dan pos -->
    <div class="w-full md:w-1/3 mt-4 border p-4">
        
        <div class="max-w-md m-4 mt-4 mx-auto rounded-md overflow-hidden">
            <h2 class="text-xl font-semibold">{{ $user->name }}'s Posts</h2>
        </div>
        @if ($user->posts->isEmpty())
            <p>No discussion yet.</p>
        @else
        <div id="post-list-on-profile" class="mb-4">
            @include('partials.posts', ['posts' => $posts])
        </div>
            @if ($posts->hasMorePages())
            <div class="flex justify-center mt-4">
                <button id="load-more-post-profile" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Load More</button>
            </div>
            @endif
            
        @endif
    </div>
       
    
</div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    const userId = {{ $user->id }};

    document.querySelector('#load-more-products').addEventListener('click', function() {
        currentPage++;
        const nextPageUrl = `/profile/${userId}/products?page=${currentPage}`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(nextPageUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const productList = document.getElementById('product-list-profile');
            
            productList.insertAdjacentHTML('beforeend', data.html);

            if (!data.nextPageUrl) {
                document.querySelector('#load-more-products').style.display = 'none';
            }
        })
        .catch(error => console.error('Error loading more products:', error));
    });
});

</script>

<!-- Load more post on profile -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    const userId = {{ $user->id }}; // Pastikan ini ada di blade template yang tepat

    const loadMoreButton = document.getElementById('load-more-post-profile');

    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', function() {
            currentPage++;
            const nextPageUrl = `/discuss/${userId}/load?page=${currentPage}`;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(nextPageUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                const postList = document.getElementById('post-list-on-profile');

                // Append new posts to the post list
                postList.insertAdjacentHTML('beforeend', data.html);

                // Hide load more button if no more pages
                if (!data.nextPageUrl) {
                    loadMoreButton.style.display = 'none';
                }
            })
            .catch(error => console.error('Error loading more posts:', error));
        });
    } else {
        console.error('Element with ID "load-more-post-profile" not found.');
    }
});
</script>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const followButton = document.getElementById('follow-button');
    followButton.addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah form dikirim secara default

        const action = followButton.getAttribute('data-action');
        const userId = {{ $user->id }};
        const url = action === 'follow' ? `/profile/${userId}/follow` : `/profile/${userId}/unfollow`;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            const followersCount = document.getElementById('followers-count');
            followersCount.textContent = `${data.followers_count} Followers`;

            if (data.status === 'followed') {
                followButton.textContent = 'Unfollow';
                followButton.classList.remove('bg-blue-500');
                followButton.classList.add('bg-red-500');
                followButton.setAttribute('data-action', 'unfollow');
            } else {
                followButton.textContent = 'Follow';
                followButton.classList.remove('bg-red-500');
                followButton.classList.add('bg-blue-500');
                followButton.setAttribute('data-action', 'follow');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
</script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([{{ $user->latitude }}, {{ $user->longitude }}], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: ''
        }).addTo(map);

        var marker = L.marker([{{ $user->latitude }}, {{ $user->longitude }}]).addTo(map);
        marker.bindPopup('<b>{{ $user->name }}</b>').openPopup();
    </script>
    
@endsection
