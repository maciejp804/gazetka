<header class="flex border-b border-gray-100 h-21 w-full">
    <div class="w-full max-w-7xl 1xl:max-w-8xl m-auto">
        <div class="py-4 px-2">
            <div class="flex justify-between items-center w-full">
                <div class="flex w-2/5">
                    <a href="{{route('main.index')}}" class="lg:w-1/3">
                        <img src="https://hoian.pl/assets/image/Logo.png" alt="logo-image" class="w-28">
                    </a>
                    <div class="hidden lg:flex w-full">
                        <ul class="flex justify-around self-center w-full ">
                            <li class="flex border-b-2 border-white text-gray-500 transition duration-300 ease-in hover:border-blue-550 hover:text-gray-700">
                                <a href="{{route('main.leaflets')}}">
                                    <p class="text-lg">Gazetki</p>
                                </a>
                            </li>
                            <li class="flex border-b-2 border-white text-gray-500 transition duration-300 ease-in hover:border-blue-550 hover:text-gray-700">
                                <a href="{{route('main.retailers')}}">
                                    <p class="text-lg">Sklepy</p>
                                </a>
                            </li>
                            <li class="flex border-b-2 border-white text-gray-500 transition duration-300 ease-in hover:border-blue-550 hover:text-gray-700">
                                <a href="{{route('main.products')}}">
                                    <p class="text-lg">Produkty</p>
                                </a>
                            </li>
                            <li class="flex border-b-2 border-white text-gray-500 transition duration-300 ease-in hover:border-blue-550 hover:text-gray-700">
                                <a href="{{route('main.vouchers')}}">
                                    <p class="text-lg">Kupony</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="hidden lg:flex self-center justify-end lg:w-3/5 h-12">
                    <div class="filter-box flex mr-2 w-5/12 ">
                        <x-search :border="true" class="flex"
                                  input-id="search-input-products-desktop"
                                  result-id="results-box-products-desktop"
                                  data-search-type="products-retailers"
                                  >
                            <x-loupe-button href="#"/>
                        </x-search>

                    </div>
                    <div class="filter-box hidden lg:flex mr-2 w-3/12">
                        <x-search class="flex" :placeholder="$place" input-id="search-input-location"
                                  result-id="results-box-location"
                                  data-search-type="places"
                                  >
                            <x-location-button class="" href="#"/>
                        </x-search>
                    </div>
                    <ul class="hidden lg:flex justify-end w-3/12">
{{--                        <x-header.link href="#" svg='heart' />--}}
{{--                        <x-header.link href="#" svg='brightness' />--}}
{{--                        <x-header.link href="#" class="items-center text-blue-550 font-bold"/>--}}
                        @auth
                            <x-header.link href="{{ route('dashboard') }}" svg='user' />
                        @else
                            <x-header.link href="{{ route('login') }}" svg='user' />
                        @endauth
                    </ul>
                </div>




                {{-- Mobile Menu--}}
                <div class="flex w-3/5 justify-end lg:hidden z-30">
                    <ul x-data="{ mobileMenuIsOpen: false }" @click.away="mobileMenuIsOpen = false" class="flex gap-2">
                        <div class="filter-box flex lg:hidden w-4/5">
                            <x-search class="flex" :placeholder="$place" input-id="search-input-location-2"
                                      result-id="results-box-location-2"
                                      data-search-type="places"
                            >
                                <x-location-button/>
                            </x-search>
                        </div>
                        <x-header.link link="button" svg='bar'/>

                        <!-- Mobile Menu Modal Window -->
                        <div  x-cloak x-show="mobileMenuIsOpen"
                              x-transition:enter="transition ease-out duration-300"
                              x-transition:enter-start="opacity-0 scale-90"
                              x-transition:enter-end="opacity-100 scale-100"
                              x-transition:leave="transition ease-in duration-300"
                              x-transition:leave-start="opacity-100 scale-100"
                              x-transition:leave-end="opacity-0 scale-90"
                              class="fixed top-0 left-0 right-0 bottom-0 z-10 bg-white">
                            <div class="absolute top-0 left-0 right-0 bottom-0">
                                <div class="flex justify-between items-center py-2 px-4">
                                    <a href="{{route('main.index')}}">
                                        <img src="https://hoian.pl/assets/image/Logo.png" alt="logo-image" class="w-28">
                                    </a>
                                    <x-header.link link="button" svg='close'/>
                                </div>

                                <div class="navbar-collapse" id="navbarContent01">
                                    <div class="megamenu-content div_q9whqo">
                                        <div class="mainwrap">
                                            <ul class="flex w-80 m-auto gap-2 justify-center">
{{--                                                <li>--}}
{{--                                                    <x-header.link href="#" svg='location' />--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <x-header.link href="#" svg='heart' />--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <x-header.link href="#" svg='brightness' />--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <x-header.link href="#" class="items-center text-blue-550 font-bold"/>--}}
{{--                                                </li>--}}
                                                <li>
                                                    @auth
                                                        <x-header.link href="{{ route('dashboard') }}" svg='user' />
                                                    @else
                                                        <x-header.link href="{{ route('login') }}" svg='user' />
                                                    @endauth
                                                </li>

                                            </ul>
                                            <ul class="flex flex-col mt-8 mx-4">
                                                <li class="px-4 py-2 border-b">
                                                    <a href="{{route('main.leaflets')}}" class="link-title a_d99cny">
                                                        <span class="sp-link-title span_tr1l77">Gazetki</span>
                                                    </a>
                                                </li>
                                                <li class="px-4 py-2 border-b">
                                                    <a href="{{route('main.retailers')}}" class="link-title a_3cgpxm">
                                                        <span class="sp-link-title span_c5t2wg">Sklepy</span>
                                                    </a>
                                                </li>
                                                <li class="px-4 py-2 border-b">
                                                    <a href="{{route('main.products')}}" class="link-title a_b70zm8">
                                                        <span class="sp-link-title span_zhao3d">Produkty</span>
                                                    </a>
                                                </li>
                                                <li class="px-4 py-2 border-b">
                                                    <a href="{{route('main.blogs')}}" class="link-title a_b70zm8">
                                                        <span class="sp-link-title span_zhao3d">Blog</span>
                                                    </a>
                                                </li>
                                                <li class="px-4 py-2 border-b">
                                                    <a href="{{route('main.maps')}}" class="link-title a_b70zm8">
                                                        <span class="sp-link-title span_zhao3d">Lokalizacje</span>
                                                    </a>
                                                </li>
                                                <li class="px-4 py-2 border-b">
                                                    <a href="{{route('main.vouchers')}}" class="link-title a_qpoaqp">
                                                        <span class="sp-link-title span_376j45">Kupony</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="absolute bottom-0 w-full">
{{--                                                <ul class="flex justify-center gap-x-4 my-5 w-80 m-auto">--}}
{{--                                                    <li class="flex w-20"><a href="#"><img class="flex w-20" src="https://hoian.pl/assets/image/pro/image 7.png" alt="Google Play"></a></li>--}}
{{--                                                    <li class="flex w-20"><a href="#"><img class="flex w-20" src="https://hoian.pl/assets/image/pro/image 8.png" alt="App Gallery"></a></li>--}}
{{--                                                    <li class="flex w-20"><a href="#"><img class="flex w-20" src="https://hoian.pl/assets/image/pro/image 9.png" alt="App Store"></a></li>--}}
{{--                                                </ul>--}}
                                                <p class="text-1xs text-gray-500 text-center pb-5">
                                                    @php echo date('Y'); @endphp © Gazetkapromocyjna.com.pl. Wszelkie prawa
                                                    zastrzeżone
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</header>

