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

    <div class="flex flex-col gap-y-4">

        {{-- Reklama pionowa po lewej stronie --}}
{{--        <x-ad-3-vertical site="justify-end"/>--}}
        <x-breadcrumbs class="mt-3" :breadcrumbs="$breadcrumbs"/>
        <x-div-1060 class="2lg:flex-row">
            <div class="flex flex-col gap-y-4 w-full 2lg:w-4/5">
                <x-header-blog>{{$h1_title}}</x-header-blog>
                <x-excert-blog/>
                <x-section>
                    <x-blog-author class="mb-3"/>
                    <div class="flex justify-between">
                        <div class="swiper-slide px-2 lg:px-4 py-2 border bg-gray-200 hover:bg-gray-100 rounded !w-auto">
                            <a class="text-xs lg:text-sm" href="{{route('main.blogs_category', ['category' => 'porady'])}}">Porady (10)</a>
                        </div>
                        <div class="flex self-center text-xs">
                            <span>20.01.2015   | aktualizacja:  05.01.2024 </span>
                        </div>
                    </div>
                </x-section>
                <x-section>
                    <img src="https://hoian.pl/assets/image/blog/zdjecia-rossmann.jpg" alt="Post Image" class="rounded object-cover">
                </x-section>
                <x-section>
                    <x-body-blog/>
                </x-section>
            </div>
            <div class="hidden 2lg:flex flex-col w-1/5 gap-y-4">
                <span class="font-semibold text-gray-700 text-sm">Poleceane w kategorii</span>
                @for($i=0; $i<=4; $i++)
                    <div>
                        <a href="/abc-zakupowicza/porady/chleb" class="flex gap-2">
                            <picture class="flex aspect-square w-32 ">
                                <source srcset="https://hoian.pl/assets/image/blog/rossmann-150.png" type="image/png">
                                <img class="object-cover rounded" src="https://hoian.pl/assets/image/blog/rossmann-150.png" alt="Jak wywołać zdjęcia w Rossmannie i zaoszczędzić pieniądze?" loading="lazy" decoding="async">
                            </picture>
                            <div class="flex flex-col">
                                <span class="text-xs">Jak wywołać zdjęcia w Rossmannie i zaoszczędzić pieniądze?</span>
                                <span class="text-1xs">20 STY 2015</span>
                            </div>
                        </a>
                    </div>
                @endfor

            </div>

        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
{{--        <x-ad-3-vertical site="justify-start"/>--}}

    </div>
</x-layout>

