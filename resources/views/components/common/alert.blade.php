<!-- Error Alert Component -->
<div class="bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-lg p-4 mb-4">
    <div class="flex items-start gap-3">
        <!-- Icon -->
        <div class="flex-shrink-0 mt-0.5">
            <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-xl"></i>
        </div>
        
        <!-- Content -->
        <div class="flex-1">
            <h3 class="font-semibold text-red-900 dark:text-red-300 mb-1">
                {{ $title ?? 'Error' }}
            </h3>
            <p class="text-red-800 dark:text-red-200 text-sm">
                {{ $message ?? 'Something went wrong' }}
            </p>
        </div>
        
        <!-- Close Button -->
        @if($dismissible ?? true)
            <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">
                <i class="fas fa-times"></i>
            </button>
        @endif
    </div>
</div>

<!-- Success Alert Component -->
@if($type === 'success')
<div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg p-4 mb-4">
    <div class="flex items-start gap-3">
        <div class="flex-shrink-0 mt-0.5">
            <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
        </div>
        <div class="flex-1">
            <h3 class="font-semibold text-green-900 dark:text-green-300 mb-1">
                {{ $title ?? 'Success' }}
            </h3>
            <p class="text-green-800 dark:text-green-200 text-sm">
                {{ $message ?? 'Operation completed' }}
            </p>
        </div>
        @if($dismissible ?? true)
            <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300">
                <i class="fas fa-times"></i>
            </button>
        @endif
    </div>
</div>
@endif

<!-- Warning Alert Component -->
@if($type === 'warning')
<div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4 mb-4">
    <div class="flex items-start gap-3">
        <div class="flex-shrink-0 mt-0.5">
            <i class="fas fa-exclamation-triangle text-yellow-600 dark:text-yellow-400 text-xl"></i>
        </div>
        <div class="flex-1">
            <h3 class="font-semibold text-yellow-900 dark:text-yellow-300 mb-1">
                {{ $title ?? 'Warning' }}
            </h3>
            <p class="text-yellow-800 dark:text-yellow-200 text-sm">
                {{ $message ?? 'Please be careful' }}
            </p>
        </div>
        @if($dismissible ?? true)
            <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300">
                <i class="fas fa-times"></i>
            </button>
        @endif
    </div>
</div>
@endif
