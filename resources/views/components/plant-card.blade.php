<!-- Plant Card Component -->
<!-- Usage: @include('components.plant-card', ['plant' => $plant]) -->

<div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow">
    <!-- Plant Image -->
    <div class="aspect-square bg-gray-200 dark:bg-gray-700 overflow-hidden relative group">
        @if($plant->image ?? false)
            <img src="{{ Storage::url($plant->image) }}" alt="{{ $plant->common_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-green-200 to-green-400">
                <i class="fas fa-leaf text-5xl text-white"></i>
            </div>
        @endif
        
        <!-- Difficulty Badge -->
        @if($plant->difficulty ?? false)
            <div class="absolute top-2 right-2 px-2 py-1 rounded-full text-white text-xs font-medium {{ $plant->difficulty === 'easy' ? 'bg-green-500' : ($plant->difficulty === 'medium' ? 'bg-yellow-500' : 'bg-red-500') }}">
                {{ ucfirst($plant->difficulty) }}
            </div>
        @endif
        
        <!-- Like Button -->
        <button class="absolute top-2 left-2 p-2 rounded-full bg-white/80 dark:bg-gray-800/80 hover:bg-white dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors backdrop-blur">
            <i class="fas fa-heart"></i>
        </button>
    </div>
    
    <!-- Plant Info -->
    <div class="p-4">
        <h3 class="font-semibold text-gray-900 dark:text-white text-sm mb-1">{{ $plant->common_name ?? 'Unknown Plant' }}</h3>
        <p class="text-xs text-gray-600 dark:text-gray-400 mb-3 italic">{{ $plant->scientific_name ?? '' }}</p>
        
        <!-- Plant Details -->
        @if($plant->category ?? false)
            <div class="mb-3 flex flex-wrap gap-2">
                <span class="inline-block px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded text-xs font-medium">
                    {{ $plant->category->name ?? 'Plant' }}
                </span>
                @if($plant->water_level ?? false)
                    <span class="inline-block px-2 py-1 bg-cyan-100 dark:bg-cyan-900 text-cyan-700 dark:text-cyan-300 rounded text-xs font-medium">
                        <i class="fas fa-droplet mr-1"></i> {{ ucfirst($plant->water_level) }}
                    </span>
                @endif
            </div>
        @endif
        
        <!-- Description -->
        @if($plant->description ?? false)
            <p class="text-xs text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                {{ Str::limit($plant->description, 100) }}
            </p>
        @endif
        
        <!-- Stats -->
        <div class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-400 mb-3 border-t border-gray-200 dark:border-gray-700 pt-3">
            <span><i class="fas fa-heart text-red-500 mr-1"></i> {{ $plant->likes_count ?? 0 }}</span>
            <span><i class="fas fa-comment text-blue-500 mr-1"></i> {{ $plant->comments_count ?? 0 }}</span>
            <span><i class="fas fa-share text-green-500 mr-1"></i> {{ $plant->shares_count ?? 0 }}</span>
        </div>
        
        <!-- Action Buttons -->
        <div class="grid grid-cols-2 gap-2">
            <a href="{{ route('plants.show', $plant) ?? '#' }}" class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded transition-colors text-center">
                View
            </a>
            <button class="px-3 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-900 dark:text-white text-xs font-medium rounded transition-colors">
                <i class="fas fa-bookmark"></i>
            </button>
        </div>
    </div>
</div>
