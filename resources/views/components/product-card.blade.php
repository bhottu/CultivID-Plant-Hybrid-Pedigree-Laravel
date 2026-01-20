<!-- Product Card Component -->
<!-- Usage: @include('components.product-card', ['product' => $product]) -->

<div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow">
    <!-- Product Image -->
    <div class="aspect-square bg-gray-200 dark:bg-gray-700 overflow-hidden relative group">
        @if($product->image ?? false)
            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-orange-200 to-orange-400">
                <i class="fas fa-shopping-bag text-5xl text-white"></i>
            </div>
        @endif
        
        <!-- Discount Badge -->
        @if($product->discount ?? false)
            <div class="absolute top-2 right-2 px-2 py-1 rounded-full bg-red-500 text-white text-xs font-bold">
                -{{ $product->discount }}%
            </div>
        @endif
        
        <!-- Wishlist Button -->
        <button class="absolute top-2 left-2 p-2 rounded-full bg-white/80 dark:bg-gray-800/80 hover:bg-white dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors backdrop-blur">
            <i class="fas fa-heart"></i>
        </button>
    </div>
    
    <!-- Product Info -->
    <div class="p-4">
        <!-- Seller Info -->
        @if($product->seller ?? false)
            <div class="flex items-center gap-2 mb-2">
                @if($product->seller->profile_photo ?? false)
                    <img src="{{ Storage::url($product->seller->profile_photo) }}" alt="{{ $product->seller->name }}" class="w-6 h-6 rounded-full object-cover">
                @else
                    <div class="w-6 h-6 rounded-full bg-gray-300 dark:bg-gray-600"></div>
                @endif
                <p class="text-xs text-gray-600 dark:text-gray-400">{{ Str::limit($product->seller->name, 20) }}</p>
            </div>
        @endif
        
        <h3 class="font-semibold text-gray-900 dark:text-white text-sm mb-2 line-clamp-2">{{ $product->name }}</h3>
        
        <!-- Category -->
        @if($product->category ?? false)
            <div class="mb-2">
                <span class="inline-block px-2 py-1 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded text-xs font-medium">
                    {{ $product->category->name ?? 'Product' }}
                </span>
            </div>
        @endif
        
        <!-- Description -->
        @if($product->description ?? false)
            <p class="text-xs text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                {{ Str::limit($product->description, 80) }}
            </p>
        @endif
        
        <!-- Rating & Stock -->
        <div class="flex items-center justify-between mb-3 text-xs">
            <div class="flex items-center gap-1">
                <i class="fas fa-star text-yellow-400"></i>
                <span class="text-gray-600 dark:text-gray-400">{{ $product->rating ?? '4.5' }} ({{ $product->reviews_count ?? 0 }})</span>
            </div>
            @if($product->stock ?? false)
                <span class="text-green-600 dark:text-green-400 font-medium">{{ $product->stock }} left</span>
            @else
                <span class="text-red-600 dark:text-red-400 font-medium">Out of stock</span>
            @endif
        </div>
        
        <!-- Price -->
        <div class="mb-3 border-t border-gray-200 dark:border-gray-700 pt-3">
            <div class="flex items-baseline gap-2">
                @if($product->discount ?? false)
                    <span class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ $product->currency ?? '$' }}{{ number_format($product->discounted_price ?? $product->price, 2) }}
                    </span>
                    <span class="text-sm text-gray-500 dark:text-gray-400 line-through">
                        {{ $product->currency ?? '$' }}{{ number_format($product->price, 2) }}
                    </span>
                @else
                    <span class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ $product->currency ?? '$' }}{{ number_format($product->price, 2) }}
                    </span>
                @endif
            </div>
        </div>
        
        <!-- Action Button -->
        <button class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded transition-colors">
            <i class="fas fa-shopping-cart mr-2"></i>
            Add to Cart
        </button>
    </div>
</div>
