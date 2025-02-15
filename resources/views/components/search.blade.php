@props(['placeholder' => 'Wyszukaj np. masło, Lidl' , 'border' => false, 'inputId' => 'empty', 'resultId' => 'empty',
'dataSearchType'=>'empty', 'dataContainerId' => null, 'value' => ''])

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
                   placeholder="{{$placeholder}}" class="{{$classes}}" autocomplete="off"
                   id="{{$inputId}}"
                   data-results-box-id="{{$resultId}}"
                   data-search-type="{{$dataSearchType}}"
                   data-container-id="{{$dataContainerId}}"
                   value="{{$value}}"
            >
            <button
                type="button"
                class="clear-button absolute top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 w-5 hidden
                @if($dataSearchType === 'places')
                    right-2
                @else
                    right-12
                @endif
                ">
                <x-header.svg svg="close" size="h-4 w-4" class="fill-gray-400"/>
            </button>
            {{ $slot }}

            <!-- Kontener na wyniki wyszukiwania -->
            <div id="{{$resultId}}" class="search-results hidden absolute top-11 left-0 border-l border-b border-r w-full
            bg-white-50 rounded-b-md max-h-40 overflow-y-auto scrollbar-thin min-h-10 z-40"></div>

        </div>
</div>
