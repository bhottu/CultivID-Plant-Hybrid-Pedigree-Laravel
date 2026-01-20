<!-- Modal / Dialog Component -->
<div id="{{ $id ?? 'modal' }}" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-end lg:items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-t-3xl lg:rounded-lg w-full lg:w-full lg:max-w-md max-h-96 overflow-y-auto">
        <!-- Header -->
        <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                {{ $title ?? 'Modal' }}
            </h2>
            <button onclick="document.getElementById('{{ $id ?? 'modal' }}').classList.add('hidden')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Content -->
        <div class="p-4">
            {{ $slot }}
        </div>
        
        <!-- Footer -->
        @if($footer ?? false)
            <div class="flex gap-2 p-4 border-t border-gray-200 dark:border-gray-700 sticky bottom-0 bg-white dark:bg-gray-800">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
