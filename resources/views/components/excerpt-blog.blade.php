@props(['excerpt'])

<div {{ $attributes->merge(['class' => 'mx-2 xs:mx-4']) }} >
    <p class="leading-7">{{$excerpt}}</p>
</div>
