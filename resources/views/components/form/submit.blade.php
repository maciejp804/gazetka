@props(['label' => 'Zapisz'])

<div class="mt-6">
    <button
        type="submit"
        {{ $attributes->merge(['class' => 'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow']) }}
    >
        {{ $label }}
    </button>
</div>
