<div class="w-full max-w-2xl mx-auto p-4 space-y-6">
    <!-- Search Query Display -->
    <div class="text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Search Results for "{{ $query }}"</h2>
        <p class="text-gray-600 dark:text-gray-400">Found {{ $products->total() + $users->total() + $posts->total() }} results</p>
    </div>

    <!-- Users Section -->
    @if($users->count())
        <div class="space-y-3">
            <h3 class="font-bold text-lg text-gray-900 dark:text-white">People</h3>
            <div class="space-y-2">
                @foreach($users as $user)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-3 flex items-center justify-between">
                        <a href="{{ route('profile', $user->id) }}" hx-get="{{ route('profile', $user->id) }}" hx-target="#app-content" hx-push-url="true" class="flex items-center gap-3 flex-1 hover:opacity-80 transition">
                            <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </div>
                        </a>
                        <button class="py-1 px-3 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded transition">
                            Follow
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Posts Section -->
    @if($posts->count())
        <div class="space-y-3">
            <h3 class="font-bold text-lg text-gray-900 dark:text-white">Posts</h3>
            <div class="space-y-3">
                @foreach($posts as $post)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-xs">
                                {{ strtoupper(substr($post->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $post->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @if($post->image)
                            <div class="mb-3 rounded-lg overflow-hidden">
                                <img src="{{ Storage::url($post->image) }}" alt="Post" class="w-full object-cover max-h-60">
                            </div>
                        @endif
                        <p class="text-gray-700 dark:text-gray-300 text-sm">{{ Str::limit($post->caption, 150) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Products Section -->
    @if($products->count())
        <div class="space-y-3">
            <h3 class="font-bold text-lg text-gray-900 dark:text-white">Products</h3>
            <div class="grid grid-cols-2 gap-3">
                @foreach($products as $product)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-32 object-cover">
                        @endif
                        <div class="p-3">
                            <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ Str::limit($product->name, 20) }}</h4>
                            <p class="text-green-600 font-bold text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- No Results -->
    @if(!$users->count() && !$posts->count() && !$products->count())
        <div class="text-center py-12">
            <p class="text-gray-500 dark:text-gray-400 text-lg">No results found for "{{ $query }}"</p>
        </div>
    @endif
</div>
