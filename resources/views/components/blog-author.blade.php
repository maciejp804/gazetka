@props(['size' => 'big'])

@php

if($size == 'small'){
    $spanClass = 'text-xs';
    $imgClass = 'w-6';
} else {
    $spanClass = 'text-sm';
    $imgClass = 'w-8';
}

@endphp

<div {{$attributes->merge(['class' => 'flex gap-x-2'])}}>
    <img class="rounded-full {{$imgClass}}" src="http://165.232.144.14/static/assets/image/pro/dave.png">
    <span class="flex items-center {{$spanClass}}">Jan Kowalski</span>
</div>
