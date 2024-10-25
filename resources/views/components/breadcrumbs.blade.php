@props(['$subdomain'])
<section {{$attributes->merge(['class' => 'flex flex-col w-full 1xl:w-265 m-auto'])}}>
    <div class="max-w-5xl ms-2 xs:mx-4 text-xs sm:text-base">
        <div class="flex gap-2 justify-start">
            <a href="{{route('main.index')}}" class="text-sm text-gray-400 hover:text-blue-550">Strona główna</a>
            <div class="bg-blue-550 flex h-1 rounded-full self-center w-1"></div>
            @if(!empty($subdomain))
                <a href="{{route('subdomain.index', ['subdomain' => 'dino'])}}" class="text-sm text-gray-400 hover:text-blue-550">Dino</a>
                <div class="bg-blue-550 flex h-1 rounded-full self-center w-1"></div>
                <span class="text-sm text-gray-400 font-medium">{{$slot}}</span>
            @else
                <span class="text-sm text-gray-400 font-medium">{{$slot}}</span>
            @endif

        </div>
    </div>
</section>

