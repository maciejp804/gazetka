<x-layout>
     <x-slot:place>
        {{  $place }}
    </x-slot:place>
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
            <x-section class="flex flex-col">

                <x-blog-categories :blogCategory="$blogCategory" :sum="$sum"/>

                @foreach($blogs as $blog)

                    @if($blog->blogs->count() > 0)
                    <x-h2-title class="flex"  main-route="main.blogs.category" :category="$blog->slug">{{$blog->name}}</x-h2-title>
                    <div class="grid grid-cols-6 gap-x-3 gap-y-6 p-2 rounded">
                       @foreach($blog->blogs as $item)
                            @if($loop->first)
                                <x-blogs-item-big :item="$item" :blog="$blog"/>
                            @else
                                <x-blogs-item-small :item="$item" :blog="$blog"/>
                            @endif
                        @endforeach
                    </div>
                    <x-ad-4-horizontal/>
                    @endif
                @endforeach
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

            <x-ad-1 class="my-5"/>
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

