<x-layout>
    <x-slot:slug>
        {{  $slug }}
    </x-slot:slug>

    <x-slot:h1Title>
        {!! $h1Title !!}
    </x-slot:h1Title>
    <x-h1-title :h1Title="$h1Title"/>
    <x-breadcrumbs>ABC Zakupowicza</x-breadcrumbs>
    <x-ad-1/>
    <div class="flex">

        {{-- Reklama pionowa po lewej stronie --}}
        <x-ad-3-vertical site="justify-end"/>

        <div class="w-full 1xl:min-w-265 1xl:w-265 m-auto flex flex-col">
            <x-section class="flex flex-col gap-y-4 mb-10">

                    <x-blog-categories :blogCategory="$blogCategory" :sum="$sum"/>


                <x-h2-title class="flex" link="{{route('main.blogs_category')}}">Porównania</x-h2-title>
                <div class="grid grid-cols-6 gap-x-3 gap-y-6 p-2 rounded">
                    @for($i=0; $i<4; $i++)
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

                <x-h2-title class="flex" link="{{route('main.blogs_category')}}">Aktualności</x-h2-title>
                <div class="grid grid-cols-6 gap-x-3 gap-y-6">
                    @for($i=0; $i<4; $i++)
                        @switch($i)
                            @case(0)
                                <x-blogs-item-big/>
                                @break
                            @default
                                <x-blogs-item-small/>
                                @break
                        @endswitch
                    @endfor
                </div>
            </x-section>
            <x-ad-4-horizontal/>
            <x-section>
                <x-swiper-vouchers swiper-class="vouchers-swiper-promo" title="Polecane kupony rabatowe" :link="route('main.coupons')"/>
            </x-section>

            <x-section>
                <x-swiper-leaflets-promo title="Zobacz polecane gazetki" :link="route('main.leaflets')"/>
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

