<div class="w-full max-w-2xl mx-auto p-4 space-y-4">
    @if($products->count())
        @foreach($products as $product)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr($product->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $product->user->name ?? 'Unknown' }}</p>
                            <p class="text-xs text-gray-500">{{ $product->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                
                @if($product->image)
                    <div class="mb-3 rounded-lg overflow-hidden">
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full object-cover max-h-80">
                    </div>
                @endif
                
                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">{{ $product->name }}</h3>
                <p class="text-gray-700 dark:text-gray-300 text-sm mb-3">{{ Str::limit($product->description, 150) }}</p>
                
                <div class="flex gap-4 text-gray-600 dark:text-gray-400 text-sm">
                    <button class="flex items-center gap-1 hover:text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span>Like</span>
                    </button>
                    <button class="flex items-center gap-1 hover:text-blue-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <span>Comment</span>
                    </button>
                </div>
            </div>
        @endforeach

        {{ $products->links() }}
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 dark:text-gray-400">No products available</p>
        </div>
    @endif
</div>
