@props(['label', 'name', 'options' => [], 'selected' => null])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300']) }}
    >
        <option value="0" >Brak</option>
        @foreach($options as $value => $label)
            <option value="{{ $value }}" @selected(old($name, $selected) == $value)>{{ $label }}</option>
        @endforeach
    </select>
</div>
