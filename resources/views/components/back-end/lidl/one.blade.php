<style>
    body > div:last-child > span + img {
        display: inline !important;
    }
</style>
<div id="leafletCanvas" class="flex flex-col w-96 h-135 relative">
    <div class="w-full h-full flex flex-col bg-white">
        {{--<div class="flex h-fit">
            <img src="{{asset('assets/image/templates/'.$chain.'-header.png')}}">
        </div> --}}
        <div class="flex-col flex h-full w-full">
            <div class="flex ml-4 h-12">
            <div class="flex flex-col bg-gradient-to-r from-blue-600 to-blue-800 w-4/12 leading-3 text-white text-center justify-center text-sm font-lidlSemibold">
                <span>OD SOBOTY,</span>
                <span>15.02</span>
            </div>
            <div class="flex flex-col bg-gradient-to-r from-red-700 to-red-400 leading-6 text-white text-center justify-center w-8/12 font-lidlSemibold">
                <span>Dziecko</span>
            </div>
            </div>
            <div class="flex h-1/3 mt-3">
                <div class="flex flex-wrap justify-start ml-4 w-4/12 h-full bg-red-500">
                    <img class="flex flex-col z-50 h-fit" src="{{asset('images/templates/lidl-header3.png')}}">

                </div>
                <div class="flex flex-wrap relative justify-end w-8/12 h-fit">

                    <img class="flex align-bottom" src="@if($data !== ''){{asset($data['imageUrl'])}}@endif">


                </div>
            </div>
            <div class="flex h-2/3 mt-3">
                <div class="flex flex-wrap relative justify-start h-fit">
                    <img class="flex align-bottom" src="@if($image !== ''){{asset($image)}}@endif">
                </div>
                <div class="flex flex-wrap justify-start w-4/12 bg-red-500 bg-opacity-75 absolute">
                    <div class=" flex justify-center w-full">
                        <h2 class="text-white font-extrabold text-xl text-center pt-0 m-1 leading-none font-lidl" id="h2_title" > @if($data!== ''){{$data['h1Tag']}}@endif</h2>
                    </div>
                    <div class="flex flex-col leading-none pt-1 text-white pl-1 pr-1 text-xs font-lidl fill-blue-550">
                        @if($data!== '')
                            {!! $data['attributes'] !!}
                        @endif
                    </div>
                </div>
            </div>
          <div class="absolute bottom-1/2 right-2 h-16 w-26 flex flex-wrap bg-red-500 content-center p-2">
                 <span class="text-white text-center text-4xl font-lidlSemibold">@if($data!== ''){{$data['priceWhole']}}.{{$data['priceRest']}}@endif zł</span>
                <span class="text-xs price-rtveuroagd">@if($data!== '' and $data['promoCode'] !== null)Kod do oferty: {{$data['promoCode']}}@endif</span>
            </div>
            <div class=" absolute bottom-12 right-2 h-6 w-28 flex flex-wrap justify-center content-center">
                <img class="flex" src="{{asset('/images/templates/lidl-logo-online.png')}}">

            </div>
            <div class="absolute bottom-5 left-0 w-full flex flex-col text-xs">

                @if($data!== '')
                    @if($data['prices'] !== null)
                        @foreach($data['prices'] as $item)
                            <span class="pl-2 pt-2 pb-2 flex flex-wrap w-full text-white leading-3 ">{{$item['price']}} zł: {{$item['label']}}</span>
                        @endforeach
                    @endif
                @endif

            </div>
            <div class="absolute flex flex-col bottom-8 left-2 w-11/12 leading-none gap-2 pt-1">
                        <span class="text-xs"></span>

            </div>
            <div class="absolute bottom-0 p-1 text-xs bg-red-500 w-full text-white font-lidl">
                <span>CZAS TRWANIA AKCJI: 15.02 - 23.02.2025 LUB DO WYCZERPANIA ZAPASÓW</span>
            </div>
        </div>
    </div>
</div>
