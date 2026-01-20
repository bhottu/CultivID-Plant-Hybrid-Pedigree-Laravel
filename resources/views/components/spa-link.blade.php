<!-- SPA Link Component (Drop-in replacement for <a> tags) -->
<!-- Usage: @include('components.spa-link', ['href' => route('home'), 'text' => 'Home']) -->
<!-- Or with slot: @include('components.spa-link', ['href' => route('home')]) Icon Home @endinclude -->

@php
    $href = $href ?? '#';
    $classes = $classes ?? 'text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300';
    $class = ($class ?? '') . ' ' . $classes;
@endphp

<a href="{{ $href }}" 
   class="{{ trim($class) }}"
   @click="spa.navigate('{{ $href }}')"
   {{ $attributes }}>
    {{ $slot ?? ($text ?? '') }}
</a>
