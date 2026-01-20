<!-- Product Card Component -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition">
    
    <!-- Product Image -->
    <div class="relative aspect-square bg-gray-200 dark:bg-gray-700 overflow-hidden group">
        @if($product->featured_image)
            <img src="{{ Storage::url($product->featured_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900">
                <i class="fas fa-shopping-bag text-4xl text-gray-400 opacity-50"></i>
            </div>
        @endif
        
        <!-- Sale Badge -->
        @if($product->discount_percentage)
            <div class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                -{{ $product->discount_percentage }}%
            </div>
        @endif
        
        <!-- Overlay Actions -->
        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
            <a href="{{ route('products.show', $product) }}" class="p-3 bg-white rounded-full text-gray-900 hover:bg-blue-600 hover:text-white transition">
                <i class="fas fa-eye"></i>
            </a>
        </div>
        
        <!-- Seller Badge -->
        <div class="absolute bottom-2 right-2 bg-blue-600 text-white px-2 py-1 rounded text-xs font-semibold">
            {{ $product->seller->name ?? 'Seller' }}
        </div>
    </div>
    
    <!-- Product Info -->
    <div class="p-4">
        <!-- Product Name -->
        <a href="{{ route('products.show', $product) }}" class="block mb-2">
            <h3 class="font-bold text-gray-900 dark:text-white truncate hover:text-blue-600 dark:hover:text-blue-400">
                {{ $product->name }}
            </h3>
        </a>
        
        <!-- Category -->
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
            {{ $product->category->name ?? 'Uncategorized' }}
        </p>
        
        <!-- Price -->
        <div class="mb-3 pb-3 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-baseline gap-2">
                <span class="text-lg font-bold text-gray-900 dark:text-white">
                    ${{ $product->price }}
                </span>
                @if($product->original_price)
                    <span class="text-sm line-through text-gray-500">
                        ${{ $product->original_price }}
                    </span>
                @endif
            </div>
        </div>
        
        <!-- Rating -->
        <div class="flex items-center gap-2 mb-4">
            <div class="flex gap-1">
                @for($i = 0; $i < 5; $i++)
                    <i class="fas fa-star text-yellow-400 text-xs {{ $i < ($product->average_rating ?? 0) ? '' : 'opacity-30' }}"></i>
                @endfor
            </div>
            <span class="text-xs text-gray-600 dark:text-gray-400">
                ({{ $product->reviews_count ?? 0 }})
            </span>
        </div>
        
        <!-- Stock Status -->
        <div class="mb-4">
            @if($product->in_stock)
                <span class="text-xs bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 px-2 py-1 rounded">
                    In Stock
                </span>
            @else
                <span class="text-xs bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300 px-2 py-1 rounded">
                    Out of Stock
                </span>
            @endif
        </div>
        
        <!-- Action Buttons -->
        <div class="flex gap-2">
            <a href="{{ route('products.show', $product) }}" class="flex-1 px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition text-center">
                View
            </a>
            <button onclick="addToCart({{ $product->id }})" {{ !$product->in_stock ? 'disabled' : '' }} class="flex-1 px-3 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="fas fa-shopping-cart"></i>
            </button>
        </div>
    </div>
</div>

<script>
function addToCart(productId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch(`/api/cart/add`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Added to cart!');
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
