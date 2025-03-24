@props(['items'])

<div class="flex flex-col w-full text-gray-500 font-normal text-sm">
    <div class="grid grid-cols-6 px-2">
        <span class="font-semibold text-xs py-2 col-span-3">Gazetki z produktem</span>
        <span class="font-semibold text-xs py-2 col-span-3">Cena</span>
    </div>

    @foreach($items as $item)

        <div class="grid grid-cols-6 px-2 odd:bg-gray-100 even:bg-white py-2">
            <div class="col-span-3">
                <img class="self-center flex h-6" src="{{ url($item['shop_image']) }}" alt="logo"/>
            </div>
            <div class="col-span-2">
                <span>{{$item['promo_price']}} zł</span>
            </div>
            <div class="col-span-1">
                <a class="pb-2 text-blue-550 text-[13px] font-bold py-1 lg:p-0" href="{{route('subdomain.leaflet',['subdomain'=> $item['shop_slug'], 'id' => $item['leaflet_id']])}}#{{$item['page_number']}}">Zobacz</a>
            </div>
        </div>

    @endforeach

</div>
