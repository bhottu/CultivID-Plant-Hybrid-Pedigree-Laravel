<!-- Empty State Component -->
<div class="flex flex-col items-center justify-center py-16 px-4">
    <!-- Icon -->
    <div class="text-6xl mb-4 text-gray-300 dark:text-gray-600">
        <i class="fas fa-{{ $icon ?? 'inbox' }}"></i>
    </div>
    
    <!-- Title -->
    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 text-center">
        {{ $title ?? 'Nothing here yet' }}
    </h3>
    
    <!-- Description -->
    @if($description ?? false)
        <p class="text-gray-600 dark:text-gray-400 text-center max-w-sm mb-6">
            {{ $description }}
        </p>
    @endif
    
    <!-- Action Button -->
    @if($button_text ?? false)
        <a href="{{ $button_url ?? '#' }}" class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
            {{ $button_text }}
        </a>
    @endif
</div>
