@props(['mainRoute' => 'main.index', 'type' => 'a'])

<div {{$attributes->merge(['class' => 'text-center'])}} >
    @if( $type == 'button')
        <button class="text-blue-550 text-[13px] font-bold py-1 lg:p-0">{{ $slot }}</button>
    @else
        <a class="text-blue-550 text-[13px] font-bold py-1 lg:p-0" href="{{route($mainRoute)}}">{{ $slot }}</a>
    @endif

</div>
