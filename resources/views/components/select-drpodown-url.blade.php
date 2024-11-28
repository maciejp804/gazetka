@props(['items', 'category' => 'Wszystkie'])
<div {{ $attributes->merge(['class' => 'w-full h-12']) }}>
            <div class="flex relative justify-between w-full border border-gray-200 text-gray-400 bg-white-50 rounded-3xl text-sm/[24px] focus:ring-0 focus:border-gray-200 h-full px-3 py-2" x-data="{ show: false}" @click.away="show = false">
                <button @click = "show = ! show" class="flex justify-between w-full">
                    <span class="flex self-center">
                        @if($category != 'Wszystkie')
                            {{$category}}
                        @else
                            Wszystkie
                        @endif
                        </span>
                    <x-header.svg svg="chevron-down" size="h-2.5 w-2.5" colour="fill-black"/>

                </button>

                <div x-show="show" class="absolute top-12 left-0 border border-gray-200 text-gray-400 bg-white rounded-md w-full" style="display: none; z-index: 1000">
                    <a class="flex px-3 pb-0.5 text-gray-400 hover:bg-[#1967d2] hover:text-white rounded-t-md
                    {{ Request::is('produkty') ? 'bg-blue-400 text-white' : 'bg-white' }}
                    " href="/produkty">Wszystkie</a>
                    @foreach($items as $item)
                        <a class="flex px-3 pb-0.5 text-gray-400 hover:bg-[#1967d2] hover:text-white
                                           {{ Request::is('produkty/'.$item->slug) ? 'bg-blue-400 text-white' : 'bg-white' }}

                                          @if($loop->last == true)
                                            rounded-b-md
                                          @endif
                                          @if($item->name === '')
                                          new
                                          @endif
                                        " href="{{route('main.products.category', ['category' => $item->slug])}}">{{$item->name}}</a>
                    @endforeach
                </div>
            </div>
</div>
