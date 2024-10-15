@props(['ref' => '#'])

<li {{ $attributes->merge(['class' => 'text-sm text-gray-500']) }}><a href="{{ $ref }}">{{ $slot }}</a></li>
