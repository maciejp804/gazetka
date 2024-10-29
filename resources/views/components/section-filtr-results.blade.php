@props(['adsStatus' => false])
<div class="w-full">
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2">
        @for($i=1; $i<=12; $i++)
            <div class="flex m-auto w-36 2xs:w-44 1xs:w-48 xs:w-52 sm:w-48 md:w-60 lg:w-44 2lg:w-52 xl:w-56 1xl:w-48">
                {{ $slot }}
            </div>
        @if($adsStatus === true)
                @switch($i)
                    @case(5)
                        <x-ad-1 class="hidden lg:grid lg:col-span-5"/>
                        @break

                    @case(3)
                        <x-ad-1 class="hidden sm:grid sm:col-span-3 lg:hidden"/>
                        @break
                    @case(2)
                    @case(6)
                    @case(12)
                        <x-ad-1 class="col-span-2 sm:hidden"/>
                        @break
                @endswitch
        @endif
        @endfor
    </div>
</div>
