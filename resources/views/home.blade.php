@extends('layouts.app')

@section('title', 'Discuss')

@section('content')

     
        <div id="post-list-profile">
            @include('partials.posts', ['posts' => $posts])
        </div>

        @if ($posts->hasMorePages())
            <div class="flex justify-center mt-4">
                <button id="load-more-postx" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Load More</button>
            </div>
        @endif

        
       
        
@endsection

</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;

    const loadMoreButton = document.getElementById('load-more-postx');

    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', function() {
            currentPage++;
            const nextPageUrl = `/discuss/load?page=${currentPage}`;

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
                const postList = document.getElementById('post-list-profile');

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
        console.error('Element with ID "load-more-post" not found.');
    }
});

</script>