@props(['ref' => '#'])

<li {{ $attributes->merge(['class' => 'flex w-20']) }}><a href="{{ $ref }}">{{ $slot }}</a></li>
