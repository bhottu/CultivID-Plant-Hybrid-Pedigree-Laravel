<!-- Button Component -->
<!-- Usage: @include('components.button', ['text' => 'Click Me', 'type' => 'primary', 'href' => '#', 'icon' => 'heart']) -->
<!-- Available types: primary, secondary, danger, ghost, outline -->

@php
$baseClasses = 'inline-flex items-center justify-center gap-2 px-4 py-3 rounded-lg font-medium transition-colors text-sm whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-900';

$typeClasses = match($type ?? 'primary') {
    'primary' => 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500',
    'secondary' => 'bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white focus:ring-gray-500',
    'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
    'ghost' => 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 focus:ring-gray-500',
    'outline' => 'border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 focus:ring-gray-500',
    default => 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500',
};

$sizeClasses = match($size ?? 'md') {
    'sm' => 'px-3 py-2 text-xs',
    'lg' => 'px-6 py-4 text-base',
    'xl' => 'px-8 py-4 text-lg',
    default => 'px-4 py-3 text-sm',
};

$finalClasses = "{$baseClasses} {$typeClasses} {$sizeClasses}";

if ($icon ?? false) {
    $icon = $icon ?? '';
    $iconHtml = "<i class='fas fa-{$icon}'></i>";
} else {
    $iconHtml = '';
}
@endphp

@if ($href ?? false)
    <a href="{{ $href }}" class="{{ $finalClasses }}" {{ $attributes }}>
        {!! $iconHtml !!}
        <span>{{ $text ?? 'Button' }}</span>
    </a>
@else
    <button type="{{ $buttonType ?? 'button' }}" class="{{ $finalClasses }}" {{ $attributes }}>
        {!! $iconHtml !!}
        <span>{{ $text ?? 'Button' }}</span>
    </button>
@endif
