@props(['item', 'categoryRoute'])
<div class="swiper-slide group">
    <div class="flex flex-col gap-y-2 text-center aspect-square justify-center w-full rounded-full border border-gray-200  ">
        <div class="aspect-square rounded-full flex justify-center group-hover:bg-blue-550 group-hover:bg-opacity-50">
            <a class="self-center w-full" href="{{route($categoryRoute, ['category' => $item->slug])}}">
                <img class="w-3/4 rounded-full m-auto" src="{{ $item->logo ? asset($item->logo) : asset('assets/images/categories/default.webp') }}" alt="pro-img1">
            </a>
        </div>
    </div>
    <div class="text-center">
        <h3 class="text-gray-800 text-xs">
            <a href="{{route($categoryRoute, ['category' => $item->slug])}}" class="font-semibold group-hover:font-bold">{{ $item->name }}</a>
        </h3>
    </div>
</div>
