<!-- Button Component -->
<button
    type="{{ $type ?? 'button' }}"
    class="px-6 py-3 rounded-lg font-medium transition inline-flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed
    {{ match($variant ?? 'primary') {
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 dark:hover:bg-blue-500',
        'secondary' => 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600',
        'success' => 'bg-green-600 text-white hover:bg-green-700 dark:hover:bg-green-500',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 dark:hover:bg-red-500',
        'warning' => 'bg-yellow-600 text-white hover:bg-yellow-700 dark:hover:bg-yellow-500',
        'outline' => 'border-2 border-blue-600 text-blue-600 hover:bg-blue-50 dark:hover:bg-gray-800',
        'ghost' => 'text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-gray-800',
        default => 'bg-blue-600 text-white hover:bg-blue-700',
    } }}
    {{ match($size ?? 'md') {
        'sm' => 'px-3 py-1.5 text-sm',
        'lg' => 'px-8 py-4 text-lg',
        'xl' => 'px-10 py-5 text-xl',
        'full' => 'w-full',
        default => 'px-6 py-3',
    } }}"
    {{ $disabled ?? false ? 'disabled' : '' }}
    @if($onclick ?? false) onclick="{{ $onclick }}" @endif
>
    @if($icon ?? false)
        <i class="fas fa-{{ $icon }}"></i>
    @endif
    {{ $slot }}
</button>
