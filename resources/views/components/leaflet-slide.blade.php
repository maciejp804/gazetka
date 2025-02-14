@props(['item', 'ok' => false, 'shop', 'logo', 'id', 'page' => 1, 'image_path','webp_path', 'avif_path', 'valid_to', 'valid_from', 'name', 'slug'])
@php

    $toEnd = validationDate($valid_to, $valid_from, $valid_to);

@endphp

@php
    use Illuminate\Support\Facades\Storage;
@endphp
{{--@dd($item)--}}
<div {{$attributes->merge(['class' => 'border border-gray-200 rounded p-2 mb-5'])}}>
    <div class="relative bg-white flex items-center justify-center group overflow-hidden">
        @if($toEnd['new'] === true)
            <span class="absolute top-[6%] -right-14 w-40 rotate-45 flex justify-center items-center h-6 bg-green-600 text-sm text-white text-center z-20">Nowość</span>
        @endif
        <div class="w-full">
            <a href="{{route('subdomain.leaflet', ['subdomain' => $slug,'id' =>$id])}}#{{$page}}">
                <picture>
                    <source srcset="{{ Storage::url($avif_path) }}" type="image/avif">
                    <source srcset="{{ Storage::url($webp_path) }}" type="image/webp">
                    <img class="rounded object-cover object-top w-full h-40 2xs:h-52 1xs:h-40 xs:h-44 sm:h-60 md:h-56 2lg:h-60"
                         src="{{ Storage::url($image_path) }}"
                         width="1920" height="1080"
                         alt="pro-img5">
                </picture>

            </a>
        </div>
        <a href="{{route('subdomain.leaflet', ['subdomain' => $slug, 'id' =>$id])}}#{{$page}}" class="hidden invisible absolute w-full h-full rounded justify-center 2xs:flex group-hover:bg-black group-hover:bg-opacity-50 group-hover:visible duration-300 ease-in">
            <div  class="hidden text-white group-hover:flex self-center justify-center font-bold text-xs w-24 h-8 bg-blue-550 rounded duration-300">
                <span class="flex self-center">Zobacz więcej</span>
            </div>
        </a>
    </div>
    <div class="py-2 text-center hover:bg-white hover:opacity-20">
        <a href="{{route('subdomain.leaflet', ['subdomain' => $slug, 'id' =>$id])}}#{{$page}}">
            <img class="max-w-8 block m-auto" src="{{$logo}}" alt="pro-img1">
            <h3 class="text-white text-xs font-bold p-1 rounded my-1 truncate {{$toEnd['classes']}}">{{$toEnd['end']}}</h3>
            <div class="flex justify-center font-light mb-1 text-xs">
                <span class="truncate">GAZETKA {{strtoupper($name)}}</span>
            </div>
        </a>
    </div>
    <div class="flex absolute justify-center w-full left-0 gap-3 z-20">
        <a href="#" class="border rounded-full w-7 h-7 bg-white flex justify-center -mt-1 group shadow-2xl"><x-header.svg svg="facebook"/></a>
        <a href="#" class="border rounded-full w-7 h-7 bg-white flex justify-center -mt-1 group"><x-header.svg svg="instagram"/></a>
        <a href="#" class="border rounded-full w-7 h-7 bg-white flex justify-center -mt-1 group"><x-header.svg svg="pinterest"/></a>
    </div>
</div>
