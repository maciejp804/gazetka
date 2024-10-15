@props(['id', 'question', 'answer'])
<div class="my-4 w-full" >
    <div>
        <a @click="expanded = expanded == {{$id}} ? null : {{$id}} " class="flex w-full font-semibold gap-x-3 p-2 border border-gray-100 rounded cursor-pointer">
            <img src="http://165.232.144.14/static/assets/image/pro/icon.png" class="flex w-4 h-4 self-center float-left">
            <div class="flex justify-between w-full">
                <span class="text-sm text-left">{{$question}}</span>
                <template x-if="expanded != {{$id}}">
                    <i class="fa fa-angle-down self-center"></i>
                </template >
                <template x-if="expanded == {{$id}}">
                    <i class="fa fa-angle-up self-center"></i>
                </template >
            </div>

        </a>
        <div x-show="expanded == {{$id}}" x-collapse.duration.500ms >
            <p class="mt-2 text-sm">{{$answer}}</p>
        </div>
    </div>
</div>
