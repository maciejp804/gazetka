@props(['seeMoreStatus' => true, 'link' => '#'])

@php

    $classes = 'hidden';
    if ($seeMoreStatus === true){
        $classes .= ' lg:mt-0 lg:flex lg:self-center';
    }
 @endphp

<div {{ $attributes->merge(['class' => 'w-full justify-between px-4']) }}>
    <h2 class="py-2 text-xl/[24px] text-center font-semibold w-75 xs:w-80 m-auto flex flex-col justify-center lg:flex-row lg:m-0 lg:w-8/12">
        {!! $slot !!}
        <x-blue-border/>
    </h2>
    <x-see-more :link="$link" class="{{ $classes }}">Zobacz wszystkie</x-see-more>
</div>
