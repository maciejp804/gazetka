@props([
    'label',
    'name',
    'value' => '',
    'required' => false,
    'maxlength' => 500, // domyślna maksymalna liczba znaków
])

<div class="mb-4" x-data="{ content: '{{ old($name, $value) }}' }">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}
    </label>

    <textarea
        rows="8"
        name="{{ $name }}"
        id="{{ $name }}"
        x-model="content"
        class="w-full border border-gray-300 rounded px-3 py-2 resize-none focus:outline-none focus:ring focus:border-blue-300"
        @if($required) required @endif
    >{{ old($name, $value) }}</textarea>

    <div class="text-sm text-right text-gray-500 mt-1 h-7">
        <span x-text="content.length + ' / {{$maxlength}} znaków'"></span>
    </div>
</div>

