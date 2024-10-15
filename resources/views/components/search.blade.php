@props(['placeholder' => 'Wyszukaj np. masło, Lidl' , 'border' => false])

@php
    $classes = 'w-full bg-white-50 rounded-3xl text-sm placeholder-gray-400';
        if ($border)
            $classes .= ' border border-gray-200';
        else
            $classes .= ' border-none pl-11'
@endphp

<div {{$attributes->merge(['class' => 'w-full h-12'])}}>
        <div class="flex w-full relative h-full">
            <input type="text" name="search" placeholder="{{$placeholder}}" class="{{$classes}}">
            {{ $slot }}
        </div>
</div>
