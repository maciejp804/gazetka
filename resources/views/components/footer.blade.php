<section class="mt-20">
    <x-newsletter class="absolute left-0 right-0 -mt-24 mx-4 lg:-mt-14"/>
    <div class="bg-gray-200 w-full">
        <div class="pt-32 lg:pt-24">
            <div x-data="{ expanded: null}" class=" mb-5 mx-5 lg:hidden">
                <div>
                    <a @click="expanded = expanded == 0 ? null : 0 " class="flex justify-between w-full font-semibold cursor-pointer pb-2 border-b">
                        <span>Gazetki promocyjne</span>
                        <template x-if="expanded != 0">
                            <i class="fa fa-angle-down self-center"></i>
                        </template >
                        <template x-if="expanded == 0">
                            <i class="fa fa-angle-up self-center"></i>
                        </template >
                    </a>
                    <ul x-show="expanded == 0" x-collapse.duration.500ms class="flex flex-col gap-y-2 my-2 ml-2 border-b">
                        <x-footer.li :ref="route('subdomain.index', ['subdomain' => 'biedronka'])">Gazetka Biedronka</x-footer.li>
                        <x-footer.li :ref="route('subdomain.index', ['subdomain' => 'lidl'])">Gazetka Lidl</x-footer.li>
                        <x-footer.li :ref="route('subdomain.index', ['subdomain' => 'pepco'])">Gazetka Pepco</x-footer.li>
                        <x-footer.li :ref="route('subdomain.index', ['subdomain' => 'kaufland'])">Gazetka Kaufland</x-footer.li>
                        <x-footer.li :ref="route('subdomain.index', ['subdomain' => 'dino'])">Gazetka Dino</x-footer.li>
                        <x-footer.li :ref="route('subdomain.index', ['subdomain' => 'netto'])">Gazetka Netto</x-footer.li>

                    </ul>
                </div>
                <div>
                    <a @click="expanded =  expanded == 1 ? null : 1" class="flex justify-between w-full font-semibold cursor-pointer pb-2 border-b">
                        <span>Kupony rabatowe</span>
                        <template x-if="expanded !=1">
                            <i class="fa fa-angle-down self-center"></i>
                        </template >
                        <template x-if="expanded == 1">
                            <i class="fa fa-angle-up self-center"></i>
                            <div x-text="item"></div>
                        </template >

                    </a>
                    <ul x-show="expanded == 1" x-collapse.duration.500ms class="flex flex-col gap-y-2 my-2 ml-2 border-b">
                        <x-footer.li :ref="route('main.retailers.category', ['category' => 'moda'])">Moda - kupony</x-footer.li>
                        <x-footer.li :ref="route('main.retailers.category', ['category' => 'dom'])">Dom -  kupony</x-footer.li>
                        {{--                    <x-footer.li >Kebab King kupony</x-footer.li>--}}
                        {{--                    <x-footer.li >Salad story kupony</x-footer.li>--}}
                        {{--                    <x-footer.li >Starbucks kupony</x-footer.li>--}}
                    </ul>
                </div>
                <div>
                    <a @click="expanded =  expanded == 2 ? null : 2" class="flex justify-between w-full font-semibold cursor-pointer pb-2 border-b">
                        <span>GazetkaPromocyjna.com.pl</span>
                        <template x-if="expanded != 2">
                            <i class="fa fa-angle-down self-center"></i>
                        </template >
                        <template x-if="expanded == 2">
                            <i class="fa fa-angle-up self-center"></i>
                        </template >
                    </a>
                    <ul x-show="expanded == 2" x-collapse.duration.500ms class="flex flex-col gap-y-2 my-2 ml-2 border-b">
                        <x-footer.li :ref="route('main.leaflets')">Gazetki</x-footer.li>
                        <x-footer.li :ref="route('main.retailers')">Sklepy</x-footer.li>
                        <x-footer.li :ref="route('main.products')">Produkty</x-footer.li>
                        <x-footer.li :ref="route('main.vouchers')">Kupony</x-footer.li>
                        <x-footer.li :ref="route('main.blogs')">Blog</x-footer.li>
                        <x-footer.li :ref="route('main.maps')">Lokalizacje</x-footer.li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="hidden lg:flex 2lg:w-265 justify-around m-auto">
            <div class="flex flex-col">
                <span class="flex justify-between w-full font-semibold cursor-pointer pb-2 border-b">
                    Gazetki promocyjne
                </span>
                <ul  class="flex flex-col gap-y-2 my-2 ml-2 border-b">
                    <x-footer.li :ref="route('subdomain.index', ['subdomain' => 'biedronka'])">Gazetka Biedronka</x-footer.li>
                    <x-footer.li :ref="route('subdomain.index', ['subdomain' => 'lidl'])">Gazetka Lidl</x-footer.li>
                    <x-footer.li :ref="route('subdomain.index', ['subdomain' => 'pepco'])">Gazetka Pepco</x-footer.li>
                    <x-footer.li :ref="route('subdomain.index', ['subdomain' => 'kaufland'])">Gazetka Kaufland</x-footer.li>
                    <x-footer.li :ref="route('subdomain.index', ['subdomain' => 'dino'])">Gazetka Dino</x-footer.li>
                    <x-footer.li :ref="route('subdomain.index', ['subdomain' => 'netto'])">Gazetka Netto</x-footer.li>

                </ul>
            </div>
            <div class="hidden lg:flex flex-col">
                <span class="flex justify-between w-full font-semibold cursor-pointer pb-2 border-b">
                    Kupony rabatowe
                </span>
                <ul  class="flex flex-col gap-y-2 my-2 ml-2 border-b">
                    <x-footer.li :ref="route('main.vouchers.category', ['category' => 'moda'])">Moda - kupony</x-footer.li>
                    <x-footer.li :ref="route('main.vouchers.category', ['category' => 'dom'])">Dom -  kupony</x-footer.li>
{{--                    <x-footer.li >Kebab King kupony</x-footer.li>--}}
{{--                    <x-footer.li >Salad story kupony</x-footer.li>--}}
{{--                    <x-footer.li >Starbucks kupony</x-footer.li>--}}

                </ul>
            </div>
            <div class="hidden lg:flex flex-col">
                <span class="flex justify-between w-full font-semibold cursor-pointer pb-2 border-b">
                    GazetkaPromocyjna.com.pl
                </span>
                <ul  class="flex flex-col gap-y-2 my-2 ml-2 border-b">
                    <x-footer.li :ref="route('main.leaflets')">Gazetki</x-footer.li>
                    <x-footer.li :ref="route('main.retailers')">Sklepy</x-footer.li>
                    <x-footer.li :ref="route('main.products')">Produkty</x-footer.li>
                    <x-footer.li :ref="route('main.vouchers')">Kupony</x-footer.li>
                    <x-footer.li :ref="route('main.blogs')">Blog</x-footer.li>
                    <x-footer.li :ref="route('main.maps')">Lokalizacje</x-footer.li>

                </ul>
            </div>
        </div>
        <div class="pb-5 mt-5 mx-5">
{{--            <ul class="flex justify-center gap-x-4 my-5">--}}
{{--                <x-footer.li-image >--}}
{{--                    <img class="flex w-20" src="https://hoian.pl/assets/image/pro/image 7.png" alt="Google Play">--}}
{{--                </x-footer.li-image>--}}
{{--                <x-footer.li-image >--}}
{{--                    <img class="flex w-20" src="https://hoian.pl/assets/image/pro/image 8.png" alt="App Gallery">--}}
{{--                </x-footer.li-image>--}}
{{--                <x-footer.li-image >--}}
{{--                    <img class="flex w-20" src="https://hoian.pl/assets/image/pro/image 9.png" alt="App Store">--}}
{{--                </x-footer.li-image>--}}
{{--            </ul>--}}
            <ul class="flex justify-center gap-x-6 border-b">
                <x-header.link href="#" svg='facebook' />
                <x-header.link href="#" svg='instagram' />
                <x-header.link href="#" svg='pinterest' />
            </ul>
            <ul class="my-5 mx-auto text-center gap-3 flex flex-col font-semibold border-b lg:flex-row lg:justify-center">
                <x-footer.li :ref="route('main.about')">O GazetkaPromocyjna</x-footer.li>
                <x-footer.li :ref="route('main.statute')">Regulamin</x-footer.li>
                <x-footer.li :ref="route('main.privacy')">Polityka prywatności</x-footer.li>
                <x-footer.li :ref="route('main.cookies')">Polityka cookies</x-footer.li>
{{--                <x-footer.li>Pomoc</x-footer.li>--}}
                <x-footer.li :ref="route('main.contact')">Kontakt</x-footer.li>

{{--                <x-footer.li ref="{{route('main.leaflets')}}">Gazetki</x-footer.li>--}}
{{--                <x-footer.li ref="{{route('main.retailers')}}">Sklepy</x-footer.li>--}}
{{--                <x-footer.li ref="{{route('main.products')}}">Produkty</x-footer.li>--}}
{{--                <x-footer.li ref="{{route('main.blogs')}}">Blog</x-footer.li>--}}
{{--                <x-footer.li ref="{{route('main.vouchers')}}" >Kupony</x-footer.li>--}}
{{--                <x-footer.li >Kontakt</x-footer.li>--}}
{{--                <x-footer.li >Pomoc</x-footer.li>--}}
            </ul>
            <ul class="my-5 mx-auto text-center">
                <p class="text-1xs text-gray-500">
                    @php echo date('Y'); @endphp © Gazetkapromocyjna.com.pl. Wszelkie prawa
                    zastrzeżone
                </p>
            </ul>
        </div>
    </div>
</section>
