<style>
    body > div:last-child > span + img {
        display: inline !important;
    }
</style>
<div id="leafletCanvas" class="flex flex-col w-116 h-135 relative">
    <div class="w-full h-full flex flex-col bg-white">
        <div class="flex h-fit">
            <img src="{{asset('images/templates/'. ($data === ''  ? 'home-you' : $data['store']).'.png')}}" class="m-auto">
        </div>
        <div class="flex-col flex h-full m-1 border-2 border-red-600 rounded-xl bg-white">
            <div class="flex flex-wrap relative pt-3 justify-center">

                <img class="flex max-w-72" src="@if($image !== ''){{asset($image)}}@endif">
                <div class="absolute flex flex-col left-2 w-40 leading-none gap-2 pt-1">
                    @if($data!== '')
                        @foreach($data['attributes'] as $item)
                            <span class="span">{{$item['name']}}: {{$item['values']}}</span>
                        @endforeach
                    @endif
                </div>

            </div>
            <div class="absolute bottom-3 left-8 h-36 w-96 flex flex-wrap justify-center content-center border-t-amber-600 border-t">
                <div class="absolute flex justify-center left-0 top-0 w-full">
                    <h2 class="font-poppins text-gray-800 text-xl text-center pt-0 m-1 leading-none" id="h2_title" >@if($data!== ''){{mb_strtolower($data['h1Tag'])}}@endif</h2>
                </div>
                <span class="text-gray-800 text-center text-5xl font-semibold">@if($data!== ''){{$data['priceWhole']}}.{{$data['priceRest']}}@endif zł</span>

            </div>
            <div class="absolute bottom-44 right-6 bg-white h-12 w-40 rounded-xl flex flex-wrap justify-center content-center border border-red-500">
                <span class="text-gray-800 text-center text-xl mt-0">KUP ONLINE</span>
            </div>
            <div class="absolute bottom-4 left-0 w-full flex flex-col space-y-2">

                @if($data!== '')
                    @if($data['prices'] !== null)
                        @foreach($data['prices'] as $item)
                            <span class="pl-4 flex flex-wrap w-full text-gray-700 leading-3 ">{{$item['label']}}: {{$item['price']}} zł</span>
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
