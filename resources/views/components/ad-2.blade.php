@props(['justify'])
<div class="w-full">
    <div class="hidden 2xl:flex {{ $justify }}">
        <img src="https://placehold.co/300x600?text=Ads+300+x+600" alt="ad">
    </div>
    <div class="hidden 1xl:flex 2xl:hidden {{ $justify }}">
        <img src="https://placehold.co/160x600?text=Ads+160+x+600" alt="ad">
    </div>
</div>
