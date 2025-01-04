@props(['items', 'city' => true, 'href' => '#', 'mainRoute' => 'main.index.gps', 'shop' => ''])
<div class="w-full px-4 ">
    <div class="w-full">
        <ul class="columns-2 text-sm md:columns-3 lg:columns-4">
            @if($city)
                @foreach($items as $item)
                    @if($shop == '')
                        <li class="py-2 text-gray-800"><a href="{{route($mainRoute, ['community' => $item->slug])}}">{{$item->name}}</a></li>
                    @else
                        <li class="py-2 text-gray-800"><a href="{{route($mainRoute, ['community' => $item->slug, 'subdomain' => $shop->slug])}}">{{$item->name}}</a></li>
                    @endif

                @endforeach
            @else
                @foreach($items as $item)
                    <li class="py-2 text-gray-800"><a href="{{route($mainRoute, ['subdomain' => $item->slug])}}">{{$item->name}}</a></li>
                @endforeach
            @endif

        </ul>
    </div>
</div>


