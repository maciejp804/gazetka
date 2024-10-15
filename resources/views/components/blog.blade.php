<x-h2-title class="flex">{{ $title }}</x-h2-title>
            <div class="owl-carousel trending-leaflets">
                @for($i=0; $i<10; $i++)
                    <div class="col-md-3 items hover_eff">
                        <div class="tred-pro image_container_s">
                            <div class="tr-pro-img member">
                                <a href="#">
                                    <img class="rounded-xl" src="http://165.232.144.14/media/blogs/5_ltC1WKM.png" alt="pro-img1">
                                </a>
                            </div>
                            <div class="pro-icn"></div>
                        </div>
                        <div class="px-4">
                            <div class="text-xs text-gray-600 pt-2">
                                <span>Jan. 8, 2024</span>
                            </div>
                            <h3 class="text-black font-bold text-sm py-2">
                                <a  href="#">Lorem ipsum dolor sit amet consectetur</a></h3>
                            <div class="text-xs text-gray-600 font-semilight">
                                <span class="old-price span_doglm7">Dolor sit amet, consectetur adipiscing elit. Ut posuere, urna nec vehicula.</span>
                            </div>
                        </div>
                    </div>
                @endfor

        </div>

<x-see-more class="lg:hidden" href="#">Zobacz wszystkie</x-see-more>
