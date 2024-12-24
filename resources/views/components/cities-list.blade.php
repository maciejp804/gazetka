@props(['items', 'city' => true, 'href' => '#', 'mainRoute' => 'main.index'])
<div class="w-full px-4 ">
    <div class="w-full">
        <ul class="columns-2 text-sm md:columns-3 lg:columns-4">
            @if($city)
                @foreach($items as $item)
                    <li class="py-2 text-gray-800"><a href="{{route('main.index.gps', ['community' => $item->slug])}}">{{$item->name}}</a></li>
                @endforeach
            @else
                @foreach($items as $item)
                    <li class="py-2 text-gray-800"><a href="{{route($mainRoute, ['subdomain' => $item->slug])}}">{{$item->name}}</a></li>
                @endforeach
            @endif

        </ul>
    </div>
</div>


