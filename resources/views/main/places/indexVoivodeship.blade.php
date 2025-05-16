<x-layout :main_domain>
    <x-slot:place>
        {{ $place }}
    </x-slot:place>
    <x-slot:meta_title>
        {{  $meta_title }}
    </x-slot:meta_title>
    <x-slot:meta_description>
        {{  $meta_description }}
    </x-slot:meta_description>


    <x-breadcrumbs class="mt-3" :breadcrumbs="$breadcrumbs"/>
{{--    <x-ad-1 class="my-5"/>--}}
    <div class="flex flex-col px-2 xs:px-4">

            <x-section class="flex h-full">
                <x-places-map :items="$voivodeships" :voivodeship="$voivodeship" :markers="$places" :latitude="$latitude" :longitude="$longitude" scale="7"/>
            </x-section>

            <x-section class="bg-gray-200 rounded py-4">
                <x-h2-title
                    see-more-status="false"
                    class="flex"
                    main-route="main.index">
                    Gazetki promocyjne, województwo {{$voivodeship->name}}
                </x-h2-title>

                <x-cities-list
                    main-route="main.index.gps"
                    :items="$places"
                />
            </x-section>

    </div>


</x-layout>
