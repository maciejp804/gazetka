@props(['averageRating', 'ratingCount', 'model' => ''])
@php

switch ($model)
{
    case 'Product':
    case 'Place':
        $divClasses = 'flex flex-row justify-center stars cursor-pointer text-gray-400';
        $spanClasses = 'text-center text-gray-600 text-sm';
    break;

    default:
        $divClasses = 'flex flex-row justify-left stars cursor-pointer text-gray-400';
        $spanClasses = 'text-left text-gray-600 text-sm';
    break;
}

@endphp
<div {{$attributes->merge(['class' => 'flex gap-2'])}}>
    <div class="{{$divClasses}}" id="star-rating">
        @for($i=1; $i<=5; $i++)
            <span data-rating="{{$i}}" class="text-2xl">☆</span>
        @endfor
    </div>
    <span id="rating-info" class="{{$spanClasses}}">{{number_format($averageRating, 2, '.','')}}/5 - {{$ratingCount}} (głosów)</span>
</div>
