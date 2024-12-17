@props(['id', 'items', 'placeholder' => 'Typ'])

<div {{ $attributes->merge(['class' => 'w-full h-12']) }}>
    <div class="flex flex-col w-full relative h-full">
        <select name="search" id="{{ $id }}" class="w-full border border-gray-200 text-gray-400 bg-white-50 rounded-3xl text-sm/[24px] focus:ring-0 focus:border-gray-200 h-full">
            <option value="all" selected disabled class="text-gray-400">{{$placeholder}}</option>
            <option value="all">Wszystkie</option>
            @foreach($items as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
</div>
