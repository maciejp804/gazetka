@props(['id', 'items'])
<div {{ $attributes->merge(['class' => 'w-full h-12']) }}>
    <div class="flex w-full relative h-full">
        <select type="text" name="search" id="{{$id}}" class="w-full border border-gray-200 text-gray-400 bg-white-50 rounded-3xl text-sm/[24px] focus:ring-0 focus:border-gray-200">
            <option value="all" selected>Wszystkie</option>
            @foreach($items as $item)
                <option value="{{$item['value']}}"><a href="#">{{$item['name']}}</a></option>
            @endforeach
        </select>
    </div>
</div>
