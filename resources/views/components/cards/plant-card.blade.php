<!-- Reusable Plant Card Component -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition">
    
    <!-- Plant Image -->
    <div class="relative aspect-square bg-gray-200 dark:bg-gray-700 overflow-hidden group">
        @if($plant->featured_image)
            <img src="{{ Storage::url($plant->featured_image) }}" alt="{{ $plant->common_name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900 dark:to-green-800">
                <i class="fas fa-leaf text-4xl text-green-600 dark:text-green-400 opacity-50"></i>
            </div>
        @endif
        
        <!-- Overlay Actions -->
        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100">
            <a href="{{ route('plants.show', $plant) }}" class="p-3 bg-white rounded-full text-gray-900 hover:bg-blue-600 hover:text-white transition">
                <i class="fas fa-eye"></i>
            </a>
            <button onclick="favoriteClick(event, {{ $plant->id }})" class="p-3 bg-white rounded-full text-gray-900 hover:bg-red-600 hover:text-white transition">
                <i class="fas fa-heart"></i>
            </button>
        </div>
        
        <!-- Badge -->
        @if($plant->status === 'verified')
            <div class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold flex items-center gap-1">
                <i class="fas fa-check"></i> Verified
            </div>
        @elseif($plant->status === 'pending')
            <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                Pending
            </div>
        @endif
    </div>
    
    <!-- Plant Info -->
    <div class="p-4">
        <!-- Plant Name -->
        <a href="{{ route('plants.show', $plant) }}" class="block mb-2">
            <h3 class="font-bold text-gray-900 dark:text-white truncate hover:text-blue-600 dark:hover:text-blue-400">
                {{ $plant->common_name ?? 'Unknown Plant' }}
            </h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 italic truncate">
                {{ $plant->scientific_name }}
            </p>
        </a>
        
        <!-- Category -->
        @if($plant->category)
            <span class="inline-block text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300 px-2 py-1 rounded-full mb-3">
                {{ $plant->category->name }}
            </span>
        @endif
        
        <!-- Description -->
        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-3">
            {{ $plant->description }}
        </p>
        
        <!-- Stats -->
        <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
            <span><i class="fas fa-heart mr-1 text-red-500"></i> {{ $plant->favorites_count ?? 0 }}</span>
            <span><i class="fas fa-eye mr-1 text-blue-500"></i> {{ $plant->views_count ?? 0 }}</span>
            <span><i class="fas fa-comment mr-1 text-green-500"></i> {{ $plant->comments_count ?? 0 }}</span>
        </div>
        
        <!-- Location -->
        @if($plant->location)
            <p class="text-xs text-gray-600 dark:text-gray-400 mb-3">
                <i class="fas fa-map-pin mr-1"></i> {{ $plant->location }}
            </p>
        @endif
        
        <!-- Action Buttons -->
        <div class="flex gap-2">
            <a href="{{ route('plants.show', $plant) }}" class="flex-1 px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition text-center">
                View
            </a>
            @if(Auth::check())
                <button onclick="favoriteClick(event, {{ $plant->id }})" class="flex-1 px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white text-sm font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    <i class="fas fa-heart"></i>
                </button>
            @endif
        </div>
    </div>
</div>

<script>
function favoriteClick(event, plantId) {
    event.preventDefault();
    
    if (!{{ Auth::check() ? 'true' : 'false' }}) {
        window.location.href = '{{ route("login") }}';
        return;
    }
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch(`/api/plants/${plantId}/favorite`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
