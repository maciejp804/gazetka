@props(['blogs','title' => 'Brak', 'mainRoute' => 'main.index', '$swiperClass'])
<x-h2-title class="flex" :main-route="$mainRoute">{!! $title !!}</x-h2-title>
<div class="w-full">
<div class="swiper {{$swiperClass}}">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper h-75 mb-10">
        @foreach($blogs as $item)
            <div class="swiper-slide">
                <a href="{{route('main.blogs.article', ['category' => $item->category->slug, 'article' => $item->slug])}}">
                    <div class="w-full h-40 rounded overflow-hidden">
                        <picture>
                            <source srcset="{{ Storage::url($item->image.'.webp') }}" type="image/webp">
                            <source srcset="{{ Storage::url($item->image.'.jpg')}}" type="image/jpeg">
                            <img
                                fetchpriority="high"
                                decoding="async"
                                src="{{ Storage::url($item->image.'.jpg') }}"
                                alt="{{$item->title}}"
                                class="object-cover w-full h-full">
                        </picture>
                    </div>
                    <div class="text-xs text-gray-600 pt-2">
                        <span>{{monthReplace($item->updated_at, 'excerpt')}}</span>
                    </div>
                    <h3 class="text-black font-bold text-sm py-2">
                        {{$item->title}}
                    </h3>
                    <div class="text-xs text-gray-600 overflow-hidden">
                        <span>{{mb_substr($item->excerpt, 0, 100)}}...</span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>

    <!-- If we need navigation buttons -->
    <x-button-next
        class="button-next-{{$swiperClass}}-{{$buttonClass}}"
        size="w-4 h-4"
        colour="gray-500"
    />
    <x-button-prev
        class="button-prev-{{$swiperClass}}-{{$buttonClass}}"
        size="w-4 h-4"
        colour="gray-500"
    />
</div>
</div>
<x-see-more class="lg:hidden" :main-route="$mainRoute">Zobacz wszystkie</x-see-more>
