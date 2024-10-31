@props(['size' => '5', 'colour' => 'blue-550'])
<div {{$attributes->merge(['class' => 'hidden lg:flex top-[29%] left-1 w-8 h-8 z-10 cursor-pointer bg-gray-100 border border-gray-200 rounded-full absolute flex justify-center shadow-xl hover:bg-gray-200'])}}>
    <div class="flex">
        <x-header.svg svg="chevron-left" :size="$size" :colour="$colour"/>
    </div>
</div>
