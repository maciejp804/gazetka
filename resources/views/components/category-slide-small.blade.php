@props(['item', 'categoryRoute', 'category'])

{{--@dd(request()->is('produkty/'.$category->slug.'/'.$item->slug))--}}
<div class="swiper-slide group ">
    <div class="flex flex-col gap-y-2 text-center aspect-square justify-center w-full rounded-full border border-gray-200
    @if(request()->is('produkty/'.$category->slug.'/'.$item->slug))
        bg-blue-550
    @endif
    ">
        <div class="aspect-square rounded-full flex justify-center group-hover:bg-blue-550 group-hover:bg-opacity-50">
            @if(request()->is('produkty/'.$category->slug.'/'.$item->slug))
                <span class="self-center w-full">
                    <img class="w-3/4 rounded-full m-auto" src="{{ $item->logo ? asset($item->logo) : asset('assets/images/categories/default.webp') }}" alt="pro-img1">
                </span>
            @else
                <a class="self-center w-full" href="{{route($categoryRoute, ['category' => $category->slug, 'subcategory' => $item->slug])}}">
                    <img class="w-3/4 rounded-full m-auto" src="{{ $item->logo ? asset($item->logo) : asset('assets/images/categories/default.webp') }}" alt="pro-img1">
                </a>
            @endif

        </div>
    </div>
    <div class="text-center">
        <h3 class="text-gray-800 text-xs">
            <a href="{{route($categoryRoute, ['category' => $category->slug, 'subcategory' => $item->slug])}}" class="font-semibold
             @if(!request()->is('produkty/'.$category->slug.'/'.$item->slug))
                        group-hover:font-bold
                        @endif
            ">{{ $item->name }}</a>
        </h3>
    </div>
</div>
