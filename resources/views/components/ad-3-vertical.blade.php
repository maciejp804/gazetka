@props(['site'])
<div {{$attributes->merge(['class' => 'w-full'])}}>
    <div class="hidden 3xl:flex {{$site}}">
        <img src="https://placehold.co/300x600?text=Ads+300+x+600" alt="ad">
    </div>
    <div class="hidden 1xl:flex 3xl:hidden {{$site}}">
        <img src="https://placehold.co/160x600?text=Ads+160+x+600" alt="ad">
    </div>
</div>
