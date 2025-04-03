@props(['label', 'name', 'checked' => false])

<div class="mb-4 flex items-center">
    <input
        type="checkbox"
        name="{{ $name }}"
        id="{{ $name }}"
        value="1"
        {{ old($name, $checked) ? 'checked' : '' }}
        {{ $attributes->merge(['class' => 'mr-2']) }}
    >
    <label for="{{ $name }}" class="text-sm text-gray-700">{{ $label }}</label>
</div>
