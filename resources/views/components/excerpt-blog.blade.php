@props(['excerpt'])

<div {{ $attributes->merge(['class' => 'mx-2 xs:mx-4']) }} >
    {!! $excerpt !!}
</div>
