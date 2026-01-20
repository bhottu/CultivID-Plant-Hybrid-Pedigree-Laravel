<!-- Loading Spinner Component -->
<div class="flex items-center justify-center" style="height: {{ $height ?? '400px' }};">
    <div class="flex flex-col items-center gap-4">
        <!-- Spinner -->
        <div class="relative w-12 h-12">
            <div class="absolute inset-0 border-4 border-gray-200 dark:border-gray-700 rounded-full"></div>
            <div class="absolute inset-0 border-4 border-transparent border-t-blue-600 dark:border-t-blue-400 rounded-full animate-spin"></div>
        </div>
        
        <!-- Loading Text -->
        @if($text ?? false)
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                {{ $text }}
            </p>
        @endif
    </div>
</div>

<style>
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
</style>
