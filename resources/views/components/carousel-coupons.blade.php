@props(['title'])
<x-h2-title class="flex">{{ $title }}</x-h2-title>
<div class="container">
    <div class="owl-carousel trending-coupons owl-theme owl-loaded owl-drag">
        @for($i=0; $i<10; $i++)
            <x-voucher/>
{{--            <div class="border-1 border-dashed border-gray-200 rounded p-2">--}}
{{--                <div class="flex">--}}
{{--                    <div class="flex self-center w-1/3">--}}
{{--                        <div>--}}
{{--                            <a href="https://tc.tradetracker.net/?c=20096&amp;m=1183634&amp;a=222077&amp;r=&amp;u=https%3A%2F%2Fwkruk.pl%2F" rel="nofollow">--}}
{{--                                <img src="//gazetkapromocyjna.com.pl/static/images/vouchers/offers/offer-2023-11-21-9157.png" alt="pro-img1">--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="flex flex-col w-2/3 px-2 gap-y-2">--}}
{{--                        <div class="w-11 flex">--}}
{{--                            <img src="//gazetkapromocyjna.com.pl/static/images/vouchers/logo/20096_45x100.jpg" alt="pro-img1">--}}
{{--                        </div>--}}

{{--                        <h3 class="font-semibold text-sm">--}}
{{--                            <a href="https://tc.tradetracker.net/?c=20096&amp;m=1183634&amp;a=222077&amp;r=&amp;u=https%3A%2F%2Fwkruk.pl%2F" rel="nofollow">--}}
{{--                                15% zniżki na biżuterię ze srebra w sklepie W.KRUK!--}}
{{--                            </a>--}}
{{--                        </h3>--}}
{{--                        <span class="text-xs text-gray-400">29 WRZ - 9 PAŹ 2917 </span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        @endfor
    </div>
</div>
<x-see-more class="lg:hidden" href="#">Zobacz wszystkie</x-see-more>
