@props(['seeMoreStatus' => true, 'mainRoute' => 'main.index', 'category' => ''])

@php

    $classes = 'hidden';
    if ($seeMoreStatus === true){
        $classes .= ' lg:mt-0 lg:flex lg:self-center';
    }


 @endphp

    <div {{ $attributes->merge(['class' => 'w-full justify-between px-4 mb-5']) }}>
        <h2 class="text-xl/[24px] text-center font-semibold w-75 xs:w-80 m-auto flex flex-col justify-center lg:flex-row lg:m-0 lg:w-8/12">
            {!! $slot !!}
            <x-blue-border/>
        </h2>
            <x-see-more :main-route="$mainRoute" :category="$category" class="{{ $classes }}">Zobacz wszystkie</x-see-more>
    </div>

