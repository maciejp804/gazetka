@props(['valid_to', 'valid_from', 'product_image', 'product_slug', 'product_name', 'promo_price', 'shop_image', 'page_number', 'shop_slug', 'leaflet_id', 'url'])
@php
    $toEnd = validationDate($valid_to, $valid_from);
@endphp

<div {{ $attributes->merge(['class' => 'swiper-slide relative w-36 2xs:w-42 1xs:w-48 xs:w-52 sm:w-48 md:w-58 lg:w-44 2lg:w-50 xl:w-48']) }}>
    <div class="flex flex-col gap-y-2 text-center aspect-square justify-center w-full rounded border border-gray-200 p-2 relative ">
        <div class="rounded flex justify-center relative group">
            <div class="self-center w-full">
                <picture>
                    <source srcset="{{ Storage::url($product_image.'.avif') }}" type="image/avif">
                    <source srcset="{{ Storage::url($product_image.'.webp') }}" type="image/webp">
                    <img class="w-full rounded h-20 2xs:h-32 object-cover"
                         src="{{ Storage::url($product_image.'.jpg') }}"
                         width="300" height="300"
                         alt="{{$product_name}}" loading="lazy">
                </picture>
            </div>
{{--            <x-heart-button class="border" iClass="text-gray-300 self-center hover:text-orange-500 transition duration-300 ease-in"/>--}}
            <a href="{{route('subdomain.leaflet', ['subdomain'=> $shop_slug, 'id' => $leaflet_id ])}}#{{$page_number}}" class="opacity-0 absolute top-0 left-0 right-0 bottom-0 flex justify-center bg-blue-550 rounded border border-blue-550 transition duration-500 hover:opacity-100">
                <div class="flex flex-col justify-center gap-y-6">
                    <div class="flex justify-center aspect-square self-center w-10 h-10 bg-blue-400 rounded-full text-white hover:text-blue-550 transition duration-500 ease-in">
                        <i class="fa fa-solid fa-search self-center"></i>
                    </div>
                    <span class="text-white text-sm">{{ $product_name }}</span>
                </div>
{{--                <!--{% check_like item request as liked %}-->--}}
{{--                            <x-heart-button class="border" iClass="text-blue-550 self-center hover:text-orange-500 transition duration-300 ease-in"/>--}}
            </a>
            <div class="absolute top-[4%] left-[4%]">
                <img class="flex self-end max-w-8" src="{{$shop_image}}" alt="">
            </div>

        </div>
        <a href="{{route('subdomain.leaflet', ['subdomain'=> $shop_slug, 'id' => $leaflet_id ])}}#{{$page_number}}" >
            <div class="flex">
                <span class="flex justify-center text-white text-xs font-bold p-1 rounded w-full {{$toEnd['classes']}}">{{ $toEnd['end'] }}</span>
            </div>
            <div class="flex justify-start min-h-12">
                <div class="flex w-1/2 self-center text-blue-550 font-semibold text-base 2xs:text-xl">
                    @if($promo_price != 0.00)
                        <span class="old-price">{{ $promo_price }} zł</span>
                    @endif
                </div>
            </div>
        </a>
        <div class="absolute bottom-[4%] right-[4%] group">
            @if(isset($url) && $url != NULL && ((str_contains($url, 'https:')) || (str_contains($url, 'https:'))))
                <x-header.link href="{{$url}}" svg='basket' size-li="w-10 h-10" />
            @endif
        </div>
    </div>
    <div class="flex justify-center min-h-12">
        <h3 class="text-gray-800 text-sm self-center my-0.5 line-clamp-2 text-center">
            {{ $product_name }}
        </h3>
    </div>


</div>
