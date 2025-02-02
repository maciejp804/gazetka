@props(['insert', 'index'])
<div class="swiper-slide pointer-events-auto">
    <div class="swiper-zoom-container">
        <div class="swiper-zoom-target flex h-full ">
            <div class="w-full relative">
                @if($insert)
                    @foreach($insert->clicks as $page)
                        <a class="bg-white/20 absolute rounded hover:bg-white/50 transition duration-500 ease-out z-50"
                           href="{{ $page->url }}"
                           target="_blank"
                           style="top:{{($page->y / 600) * 100 }}%; left:{{($page->x / 300) * 100}}%; width:{{($page->width / 300 ) * 100}}%; height:{{($page->height / 600) *100}}%; display: block;"
                        >
                            <div class="absolute top-2 left-1 opacity-100 z-60 bg-white p-1 rounded-full">
                                <x-header.svg svg="share"  class="animate-pulse"/>
                            </div>

                        </a>
                    @endforeach

                    <img src="{{ $insert->image_path }}" class="slide-image swiper-lazy image-insert aspect-auto h-full"  loading="lazy" alt="Reklama"/>


                    <div class="swiper-lazy-preloader"></div>
                @endif
            </div>
        </div>
    </div>
</div>
