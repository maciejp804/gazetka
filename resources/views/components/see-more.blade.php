@props(['mainRoute' => 'main.index', 'category' => ''])

<div {{$attributes->merge(['class' => 'text-center'])}} >
    @if($category !== '')
        <a class="text-blue-550 text-[13px] font-bold py-1 lg:p-0" href="{{route($mainRoute, ['category' => $category])}}">{{ $slot }}</a>
    @else
        <a class="text-blue-550 text-[13px] font-bold py-1 lg:p-0" href="{{route($mainRoute)}}">{{ $slot }}</a>
    @endif
</div>
