<!-- Form Input Component -->
<div class="mb-4">
    @if($label ?? false)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
            {{ $label }}
            @if($required ?? false)
                <span class="text-red-600 dark:text-red-400">*</span>
            @endif
        </label>
    @endif
    
    @if($type === 'textarea')
        <textarea 
            id="{{ $name }}"
            name="{{ $name }}"
            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed"
            rows="{{ $rows ?? 4 }}"
            placeholder="{{ $placeholder ?? '' }}"
            {{ $required ?? false ? 'required' : '' }}
            {{ $disabled ?? false ? 'disabled' : '' }}
        >{{ $value ?? '' }}</textarea>
    @elseif($type === 'select')
        <select
            id="{{ $name }}"
            name="{{ $name }}"
            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed"
            {{ $required ?? false ? 'required' : '' }}
            {{ $disabled ?? false ? 'disabled' : '' }}
        >
            @if($placeholder ?? false)
                <option value="">{{ $placeholder }}</option>
            @endif
            @if($options ?? false)
                @foreach($options as $option_value => $option_label)
                    <option value="{{ $option_value }}" {{ ($value ?? '') == $option_value ? 'selected' : '' }}>
                        {{ $option_label }}
                    </option>
                @endforeach
            @endif
        </select>
    @elseif($type === 'checkbox')
        <div class="flex items-center gap-3">
            <input 
                type="checkbox"
                id="{{ $name }}"
                name="{{ $name }}"
                value="{{ $value ?? '1' }}"
                class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer"
                {{ ($checked ?? false) ? 'checked' : '' }}
            >
            <label for="{{ $name }}" class="text-gray-700 dark:text-gray-300 cursor-pointer">
                {{ $label }}
            </label>
        </div>
    @elseif($type === 'radio')
        <div class="space-y-3">
            @if($options ?? false)
                @foreach($options as $option_value => $option_label)
                    <div class="flex items-center gap-3">
                        <input 
                            type="radio"
                            id="{{ $name }}-{{ $option_value }}"
                            name="{{ $name }}"
                            value="{{ $option_value }}"
                            class="w-5 h-5 border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer"
                            {{ ($value ?? '') == $option_value ? 'checked' : '' }}
                        >
                        <label for="{{ $name }}-{{ $option_value }}" class="text-gray-700 dark:text-gray-300 cursor-pointer">
                            {{ $option_label }}
                        </label>
                    </div>
                @endforeach
            @endif
        </div>
    @else
        <!-- Text input (default) -->
        <input 
            type="{{ $type ?? 'text' }}"
            id="{{ $name }}"
            name="{{ $name }}"
            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed"
            placeholder="{{ $placeholder ?? '' }}"
            value="{{ $value ?? '' }}"
            {{ $required ?? false ? 'required' : '' }}
            {{ $disabled ?? false ? 'disabled' : '' }}
            {{ $attributes }}
        >
    @endif
    
    <!-- Error message -->
    @if($errors && $errors->has($name))
        <p class="text-red-600 dark:text-red-400 text-sm mt-2">
            {{ $errors->first($name) }}
        </p>
    @elseif($error ?? false)
        <p class="text-red-600 dark:text-red-400 text-sm mt-2">
            {{ $error }}
        </p>
    @endif
    
    <!-- Helper text -->
    @if($help ?? false)
        <p class="text-gray-600 dark:text-gray-400 text-sm mt-2">
            {{ $help }}
        </p>
    @endif
</div>
