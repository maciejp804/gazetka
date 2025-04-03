@props(['item'])
@php

$logo_image = $item->voucherStore->image ? $item->voucherStore->image : 'images/vouchers/default/logo';
$offer_image = $item->image ? $item->image : 'images/vouchers/default/voucher';

@endphp

<div {{ $attributes->merge(['class' => 'border border-dashed border-gray-200 rounded p-2 relative mb-3 sm:mb-0']) }}>
    <div class="flex h-36">
        <a href="{{$item->url}}" class="flex" rel="nofollow">
        <div class="flex h-36 justify-center w-1/2">
            <div class="w-full h-full overflow-hidden rounded">
                <picture>
                    <source srcset="{{ Storage::url($offer_image.'.avif') }}" type="image/avif">
                    <source srcset="{{ Storage::url($offer_image.'.webp') }}" type="image/webp">
                    <img src="{{ Storage::url($offer_image.'.jpg') }}"
                         width="120" height="120"
                         alt="{{$item->voucherStore->name}}">
                </picture>
            </div>
        </div>
        <div class="flex flex-col w-1/2 px-2 gap-y-2">
            <div class="flex justify-center self-center w-full">
                <picture>
                    <source srcset="{{ Storage::url($logo_image.'.avif') }}" type="image/avif">
                    <source srcset="{{ Storage::url($logo_image.'.webp') }}" type="image/webp">
                    <img src="{{ Storage::url($logo_image.'.jpg') }}"
                         class="max-h-11 max-w-full object-scale-down"
                         width="120" height="45"
                         alt="{{$item->voucherStore->name}}">
                </picture>

            </div>

            <h3 class="font-semibold text-xs">
                {{$item->title}}
            </h3>
            <span class="text-xs text-gray-400">{{monthReplace($item->valid_from,'excerpt','d-m',)}} - {{monthReplace($item->valid_to, 'excerpt')}}</span>
        </div>
        </a>
    </div>
    <div class="text-xs text-gray-600 my-2">
        <a rel="nofollow" href="{{$item->url}}">
            <span>{{$item->body}}</span>
        </a>
    </div>
    <div class="flex justify-center text-white rounded-full bg-blue-550 m-5 p-2">
        <a rel="nofollow" href="{{$item->url}}">
            <span class="text-sm">
                @if($item->code)
                    Kod: {{$item->code}}
                @else
                    Nie potrzebujesz kodu
                @endif

            </span>
        </a>
    </div>
    <div class="flex absolute justify-center w-full left-0 gap-3">
        <a href="#" class="border rounded-full w-7 h-7 bg-white flex justify-center -mt-1 group shadow-2xl"><x-header.svg svg="facebook"/></a>
        <a href="#" class="border rounded-full w-7 h-7 bg-white flex justify-center -mt-1 group"><x-header.svg svg="instagram"/></a>
        <a href="#" class="border rounded-full w-7 h-7 bg-white flex justify-center -mt-1 group"><x-header.svg svg="pinterest"/></a>
    </div>
</div>
