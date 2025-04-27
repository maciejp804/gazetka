<x-layout>
     <x-slot:place>
        {{  $place }}
    </x-slot:place>
    <x-slot:meta_title>
        {{  $meta_title }}
    </x-slot:meta_title>
    <x-slot:meta_description>
        {{  $meta_description }}
    </x-slot:meta_description>


    <x-breadcrumbs class="mt-3" :breadcrumbs="$breadcrumbs"/>
    <x-ad-1 class="my-5"/>

    <div class="flex">

        {{-- Reklama pionowa po lewej stronie --}}
        <x-ad-3-vertical site="justify-end"/>

        <div class="w-full 1xl:min-w-265 1xl:w-265 m-auto flex flex-col px-2 xs:px-4">
            <x-h1-title :h1Title="$h1_title"/>
            <x-section class="flex flex-col gap-y-4 mb-10">

                <x-blog-categories
                    :blogCategory="$blogCategories"
                    :sum="$sum"
                />

                <div class="grid grid-cols-6 gap-x-3 gap-y-6 p-2 rounded">
                @foreach($blogs as $blog)
{{--                    @dd()--}}
                                @if($loop->first)
                                    <x-blogs-item-big :item="$blog" :blog="$blogCategory"/>
                                @else
                                    <x-blogs-item-small :item="$blog"/>
                                @endif
                @endforeach
                </div>
                {{ $blogs->links('custom-paginator') }}
            </x-section>
            <x-ad-4-horizontal/>
            <x-section>
                <x-swiper-vouchers
                    button-class="1"
                    swiper-class="vouchers-swiper-promo"
                    title="Polecane kupony rabatowe"
                    :items="$vouchers"
                    main-route="main.vouchers"/>
            </x-section>

            <x-section>
                <x-h2-title class="flex" main-route="main.leaflets">Zobacz polecane gazetki</x-h2-title>
                <x-swiper-leaflets-promo
                    button-class="1"
                    title="Zobacz polecane gazetki"
                    :leaflets="$leaflets"
                    data-container-id="leaflet-swiper"
                    main-route="main.leaflets"/>
            </x-section>

            <x-ad-1 class="my-5"/>
        </div>

        {{-- Reklama pionowa po prawej stronie --}}
        <x-ad-3-vertical site="justify-start"/>

    </div>

    @push('scripts')
{{--        <script>--}}
{{--            window.addEventListener('load', function() {--}}
{{--                document.getElementById('skeleton-slider').classList.add('hidden');--}}
{{--                document.getElementById('actual-slider').classList.remove('hidden');--}}
{{--            });--}}
{{--        </script>--}}
    @endpush
</x-layout>
