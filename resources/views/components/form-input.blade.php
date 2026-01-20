<!-- Form Input Component -->
<!-- Usage: @include('components.form-input', ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'placeholder' => 'your@email.com']) -->

<div class="mb-4">
    @if ($label ?? false)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
            {{ $label }}
            @if ($required ?? false)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    @php
        $inputClasses = 'w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-colors';
        
        $error = $errors->get($name) ? true : false;
        if ($error) {
            $inputClasses = str_replace('border-gray-300', 'border-red-500', $inputClasses);
            $inputClasses = str_replace('focus:ring-blue-600', 'focus:ring-red-600', $inputClasses);
        }
    @endphp
    
    @if (($type ?? 'text') === 'textarea')
        <textarea 
            id="{{ $name }}" 
            name="{{ $name }}" 
            class="{{ $inputClasses }}"
            placeholder="{{ $placeholder ?? '' }}"
            rows="{{ $rows ?? 4 }}"
            @if ($required ?? false) required @endif
            {{ $attributes }}
        >{{ old($name, $value ?? '') }}</textarea>
    @elseif (($type ?? 'text') === 'select')
        <select 
            id="{{ $name }}" 
            name="{{ $name }}" 
            class="{{ $inputClasses }}"
            @if ($required ?? false) required @endif
            {{ $attributes }}
        >
            <option value="">{{ $placeholder ?? 'Select...' }}</option>
            @foreach ($options ?? [] as $key => $label)
                <option value="{{ $key }}" @if(old($name, $value ?? '') === (string)$key) selected @endif>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    @else
        <input 
            type="{{ $type ?? 'text' }}" 
            id="{{ $name }}" 
            name="{{ $name }}" 
            class="{{ $inputClasses }}"
            placeholder="{{ $placeholder ?? '' }}"
            value="{{ old($name, $value ?? '') }}"
            @if ($required ?? false) required @endif
            {{ $attributes }}
        >
    @endif
    
    <!-- Error Message -->
    @if ($errors->has($name))
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">
            <i class="fas fa-exclamation-circle mr-1"></i>
            {{ $errors->first($name) }}
        </p>
    @endif
    
    <!-- Help Text -->
    @if ($help ?? false)
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            {{ $help }}
        </p>
    @endif
</div>
