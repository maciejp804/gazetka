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
    {{-- Reklama pozioma pod header --}}
    <div class="hidden 3xs:flex 3xs:w-full 3xs:min-h-25 2xs:min-h-70 my-5 mx-auto justify-center md:min-h-75">
        <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
        <x-admanager
            slot-name="homepage_header"
            :overrides="['page' => 'main.blogs']"
        />
    </div>

    <div class="flex justify-center">

        {{-- Reklama pionowa po lewej stronie --}}
        <div class="hidden mt-5 justify-end xl:flex xl:min-w-40 2xl:min-w-75 h-full sticky top-10">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_sidebar_left"
                :overrides="['page' => 'main.blogs']"
            />
        </div>

        <div class="w-full 1xl:min-w-265 1xl:w-265  flex flex-col px-2 xs:px-4">
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


        </div>

        {{-- Reklama pionowa po prawej stronie --}}
        <div class="hidden mt-5 justify-start xl:flex xl:min-w-40 2xl:min-w-75 h-full sticky top-10">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_sidebar_right"
                :overrides="['page' => 'subdomain.product']"
            />
        </div>

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
