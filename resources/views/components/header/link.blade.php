@props(['link' => 'a', 'type' => false, 'svg' => null, 'sizeSvg' => '5', 'sizeLi' => 'h-11.25 w-11.25'])

<li class="flex justify-center rounded-3xl bg-white-50 {{ $sizeLi }}">
            @if($link === 'button')
                @if($svg === 'close' || $svg === 'bar')
                    <button @click="mobileMenuIsOpen = !mobileMenuIsOpen" type="button" class = "flex justify-center align-middle {{ $sizeLi }}">
                        @else
                    <button type="button" class = "flex justify-center align-middle {{ $sizeLi }}">
                    @endif
            @else
                <a {{$attributes->merge(['class' => 'flex'])}}>
            @endif
                    @if($svg !== null)
                        <x-header.svg :svg="$svg" :size="$sizeSvg"/>
                    @else
                        PL
                    @endif


        @if($link === 'button')
               </button>
        @else
               </a>
        @endif
</li>
