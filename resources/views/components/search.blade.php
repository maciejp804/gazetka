@props(['placeholder' => 'Wyszukaj np. masło, Lidl' , 'border' => false, 'inputId' => 'empty', 'resultId' => 'empty', 'dataSearchType'=>'empty'])

@php
    $classes = 'search-input w-full bg-white-50 rounded-3xl text-sm placeholder-gray-400 focus:outline-none focus:ring-0';
        if ($border) {
          $classes .= ' border border-gray-200 focus:border-gray-200';
        } else {
            $classes .= ' border-none pl-11';
        }


@endphp

<div {{$attributes->merge(['class' => 'w-full h-12'])}}>
        <div class="flex w-full relative h-full">
            <input type="text"
                   id="{{$inputId}}" placeholder="{{$placeholder}}" class="{{$classes}}" autocomplete="off"
                   data-results-box-id="{{$resultId}}"
                    data-search-type="{{$dataSearchType}}"
            >
            {{ $slot }}

            <!-- Kontener na wyniki wyszukiwania -->
            <div id="{{$resultId}}" class="search-results hidden absolute top-11 left-0 border-l border-b border-r w-full
            bg-white-50 rounded-b-md max-h-40 overflow-y-auto scrollbar-thin"></div>

        </div>
</div>
