<x-layout>
    <x-slot:place>
        {{ $place }}
    </x-slot:place>
    <x-slot:page_title>
        {{  $page_title }}
    </x-slot:page_title>
    <x-slot:meta_description>
        {{  $meta_description }}
    </x-slot:meta_description>

    <x-ad-1 class="my-5"/>
    <div class="flex">

        {{-- Reklama pionowa po lewej stronie --}}
        <x-ad-3-vertical site="justify-end"/>

        <x-div-1060>

            <x-section class="flex h-full">
                <x-places-map :items="$voivodeships" :markers="$places" :mainDomain="$mainDomain" :latitude="$latitude" :longitude="$longitude"/>
            </x-section>

            <x-section class="bg-gray-200 rounded py-4">
                <x-h2-title
                    see-more-status="false"
                    class="flex"
                    main-route="main.index">
                    Gazetki promocyjne w największych polskich miastach
                </x-h2-title>

                <x-cities-list
                    main-route="main.index"
                    :items="$places"
                />
            </x-section>

        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
        <x-ad-3-vertical site="justify-start"/>

    </div>

    <x-section class="flex-col mx-4 xl:m-auto">
        <div class="bg-gray-200 rounded py-4 mb-5 sm:py-20 ">
            <x-about class="1xl:w-265 lg:m-auto"/>
        </div>
        <x-descripton :items="$descriptions"/>
        <x-faq/>
    </x-section>

</x-layout>