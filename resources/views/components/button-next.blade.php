@props(['size' => '5', 'colour' => 'blue-550'])
<div {{$attributes->merge(['class' => 'absolute hidden lg:flex top-[29%] right-1 w-8 h-8 z-20 cursor-pointer bg-gray-100 border border-gray-200 rounded-full justify-center hover:bg-gray-200 shadow-lg'])}}>
    <div class="flex self-center justify-center w-6 h-6 rounded-full">
        <x-header.svg svg="chevron-right" :size="$size" :colour="$colour"/>
    </div>
</div>

