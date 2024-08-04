require('./bootstrap');
document.addEventListener('DOMContentLoaded', function() {
    const commentForm = document.getElementById('comment-form');
    if (commentForm) {
        commentForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            console.log('Form submitted');

            const content = document.getElementById('comment-content').value;
            const postId = "{{ $post->id }}"; 
            const tokenElement = document.querySelector('meta[name="csrf-token"]');
            if (tokenElement) {
                const token = tokenElement.getAttribute('content');
                console.log('CSRF Token:', token);

                try {
                    const response = await fetch(`/post/${post}/comment`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({ content: content })
                    });

                    console.log('Response status:', response.status);

                    if (response.ok) {
                        const newComment = await response.json();
                        console.log('New comment:', newComment);
                    } else {
                        console.log('Failed to submit comment');
                    }
                } catch (error) {
                    console.log('Error:', error);
                }
            } else {
                console.log('CSRF token element not found');
            }
        });
    } else {
        console.log('Comment form element not found');
    }
});

function addCommentToSection(comment) {
    const commentsSection = document.getElementById('comments-section');
    console.log('Adding comment to section:', comment);
    const commentElement = document.createElement('div');
    commentElement.classList.add('border-t', 'border-gray-200', 'mt-2', 'pt-2');
    commentElement.innerHTML = `
        <p>${comment.content}</p>
        <p class="text-sm text-gray-600">By ${comment.user.name} on ${comment.created_at}</p>
    `;
    commentsSection.appendChild(commentElement);
}

async function fetchComments(postId) {
    const response = await fetch(`/comments/${postId}`);
    const comments = await response.json();
    const commentsSection = document.getElementById('comments-section');
    commentsSection.innerHTML = '';

    comments.forEach(comment => {
        addCommentToSection(comment);
    });
}

// popup open - close
function openImagePopup(imageUrl, postId) {
    document.getElementById('image-popup').classList.remove('hidden');
    document.getElementById('image-popup-img').src = imageUrl;
    fetchComments(postId); 
}

function closeImagePopup() {
    document.getElementById('image-popup').classList.add('hidden');
    document.getElementById('image-popup-img').src = '';
    document.getElementById('comments-section').innerHTML = '';
}

document.addEventListener('DOMContentLoaded', function() {
    var postImages = document.querySelectorAll('.post-image');
    
    postImages.forEach(function(postImage) {
        postImage.addEventListener('click', function() {
            var imageUrl = postImage.getAttribute('data-image-url');
            var postId = postImage.getAttribute('data-post-id');
            
            openImagePopup(imageUrl, postId);
        });
    });

    var closeButton = document.getElementById('close-popup-button');
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            closeImagePopup();
        });
    }
});

// Load more products for all products page
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;

    document.getElementById('load-more').addEventListener('click', function() {
        currentPage++;
        const nextPageUrl = `/load-more-products?page=${currentPage}`; 

        fetch(nextPageUrl)
            .then(response => response.json())
            .then(data => {
                const productList = document.getElementById('product-list');
                
                productList.insertAdjacentHTML('beforeend', data.html);

                if (!data.nextPageUrl) {
                    document.getElementById('load-more').style.display = 'none';
                }
            })
            .catch(error => console.error('Error loading more products:', error));
    });
});

// Load more products for category page
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;

    const loadMoreButton = document.getElementById('load-more-category');
    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', function() {
            currentPage++;
            const categorySlug = loadMoreButton.getAttribute('data-category-slug');
            const nextPageUrl = `/categories/${categorySlug}/load-more-products?page=${currentPage}`;

            fetch(nextPageUrl)
                .then(response => response.json())
                .then(data => {
                    const productList = document.getElementById('product-list');
                    
                    productList.insertAdjacentHTML('beforeend', data.html);

                    if (!data.nextPageUrl) {
                        loadMoreButton.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error loading more products:', error));
        });
    }
});

// Load more products for discounted page
document.addEventListener('DOMContentLoaded', function() {
    let currentDiscountPage = 1;

    const loadMoreButtonDiscounted = document.getElementById('load-more-discounted');
    if (loadMoreButtonDiscounted) {
        loadMoreButtonDiscounted.addEventListener('click', function() {
            currentDiscountPage++;
            const nextPageUrl = `/discounted-products/load-more?page=${currentDiscountPage}`;

            fetch(nextPageUrl)
                .then(response => response.json())
                .then(data => {
                    const discountedProductList = document.getElementById('discounted-product-list');
                    
                    if (data.html) {
                        discountedProductList.insertAdjacentHTML('beforeend', data.html);
                    } else {
                        loadMoreButtonDiscounted.style.display = 'none';
                    }

                    if (!data.nextPageUrl) {
                        loadMoreButtonDiscounted.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error loading more discounted products:', error));
        });
    }
});


// Preview img
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('image-preview');
        output.innerHTML = '<img src="' + reader.result + '" class="w-12 h-auto rounded-md" alt="Preview">';
    };
    reader.readAsDataURL(event.target.files[0]);
}

