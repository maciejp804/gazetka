<x-layout>
    <x-slot:slug>
        {{  $slug }}
    </x-slot:slug>
    <x-slot:page_title>
        {{  $page_title }}
    </x-slot:page_title>
    <x-slot:meta_description>
        {{  $meta_description }}
    </x-slot:meta_description>


    <x-breadcrumbs class="mt-3" :breadcrumbs="$breadcrumbs"/>
    <x-ad-1 class="my-5"/>

    <div class="flex">

        {{-- Reklama pionowa po lewej stronie --}}
        <x-ad-3-vertical site="justify-end"/>

        <div class="w-full 1xl:min-w-265 1xl:w-265 m-auto flex flex-col">
            <x-section class="flex flex-col gap-y-4 mb-10">

                <x-blog-categories :blogCategory="$blogCategory" :sum="$sum"/>

                <x-h2-title class="flex" see-more-status="false">Porady</x-h2-title>
                <div class="grid grid-cols-6 gap-x-3 gap-y-6 p-2 rounded">
                    @for($i=0; $i<8; $i++)
                        @switch($i)
                            @case(0)
                                <x-blogs-item-big />
                                @break
                            @default
                                <x-blogs-item-small />
                                @break
                        @endswitch
                    @endfor
                </div>

                <x-ad-4-horizontal/>
            </x-section>

            <x-section>
                <x-swiper-vouchers
                    swiper-class="vouchers-swiper-promo"
                    title="Polecane kupony rabatowe"
                    :items="$vouchers"
                    main-route="main.vouchers"/>
            </x-section>

            <x-section>
                <x-h2-title class="flex" :link="route('main.leaflets')">Zobacz polecane gazetki</x-h2-title>
                <x-swiper-leaflets-promo
                    button-class="1"
                    title="Zobacz polecane gazetki"
                    :leaflets="$leaflets"
                    main-route="main.leaflets"/>
            </x-section>

            <x-ad-1/>
        </div>

        {{-- Reklama pionowa po prawej stronie --}}
        <x-ad-3-vertical site="justify-start"/>

    </div>

    <div class="flex-col mx-4 xl:m-auto">
        <x-descripton :items="$descriptions"/>
        <x-faq/>
    </div>
    @push('scripts')
        <script>
            window.addEventListener('load', function() {
                const swiperElement = document.querySelector('.swiperCategory');
                swiperElement.classList.remove('hidden');
                swiperElement.classList.add('flex');
            });
        </script>
    @endpush
</x-layout>
