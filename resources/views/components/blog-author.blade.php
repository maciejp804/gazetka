@props(['size' => 'big', 'author' => ''])

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
    <img class="rounded-full {{$imgClass}}" src="{{ Storage::url($author->profile->image) }}"  alt="Autor artykułu"/>
    <span class="flex items-center {{$spanClass}}">{{$author->name}}</span>
</div>
