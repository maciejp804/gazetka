@props(['descriptions'])

<div class="flex flex-col w-full text-gray-500 font-normal text-sm">

{{--    <div class="grid grid-cols-6 px-2">--}}
{{--        <span class="font-bold py-2 col-span-5">Wartości odżywcze (%)</span>--}}
{{--        <span class="font-bold py-2 col-span-1">100g</span>--}}
{{--    </div>--}}
    <div class="grid grid-cols-6 px-2">
        <span class="font-bold py-2 col-span-6">Ważne parametry:</span>
    </div>

    @foreach($descriptions->content[0]['parameter'] as $key => $value)
        <div class="grid grid-cols-6 px-2 odd:bg-gray-100 even:bg-white py-2">
            <div class="col-span-3 flex items-center">
                <span class="font-semibold">{{mb_ucfirst($key)}}:</span>
            </div>
            <div class="col-span-3 flex items-center">
                <span>{{$value}}</span>
            </div>
        </div>
    @endforeach

</div>
