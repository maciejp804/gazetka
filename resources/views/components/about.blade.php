<div {{ $attributes->merge(['class' => 'lg:flex justify-between w-full']) }} >
    <div class="flex-col lg:w-1/2 p-4">
        <x-h2-title see-more-status="false" class="flex">O nas</x-h2-title>
        <ul class="text-sm text-gray-700 ">
            <li class="mt-3">
                <h3 class="font-semibold text-base">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi quam eros,
                    venenatis eu libero non, sodales tristique neque. Duis luctus rhoncus risus, ac aliquet purus finibus
                    id.
                </h3>
            </li>
            <li class="mt-3">
                        <span>
                            Integer condimentum sem turpis, volutpat mattis nisl porttitor in. Sed vulputate at mi a viverra. Praesent elementum dui in lectus sodales lobortis. Cras sed felis vitae ligula accumsan vestibulum quis aliquet magna. Praesent sit amet nisi vulputate, sollicitudin arcu a, varius justo. Nunc venenatis vestibulum varius. Nullam pellentesque, enim eget finibus dignissim, lorem tellus ultricies ante, sed dignissim metus risus nec massa.
                        </span>
            </li>
        </ul>
    </div>

    <ul class="flex flex-col text-sm text-gray-700 lg:w-1/2 p-4 justify-between">
        <li class="mt-3 flex justify-between gap-x-4 bg-white rounded-xl p-3">
            <span class="flex text-3xl text-blue-550 font-semibold w-1/5 justify-center self-center">2 k</span>
            <div class="w-4/5">
                <h3 class="font-semibold text-base">Lorem ipsum dolor sit amet lorem ipsum</h3>
                <span>Vestibulum rutrum ultricies mi, eget sollicitudin risus.</span>
            </div>
        </li>
        <li class="mt-3 flex justify-between gap-x-4 bg-white rounded-xl p-3">
            <span class="flex text-4xl text-blue-550 font-semibold w-1/5 justify-center self-center">25</span>
            <div class="w-4/5">
                <h3 class="font-semibold text-base">What is the estimated delivery time?</h3>
                <span>Suspendisse ac fermentum mauris, nec fringilla erat.</span>
            </div>
        </li>
        <li class="mt-3 flex justify-between gap-x-4 bg-white rounded-xl p-3">
            <span class="flex text-4xl text-blue-550 font-semibold w-1/5 justify-center self-center">199</span>
            <div class="w-4/5">
                <h3 class="font-semibold text-base">Ultricies mi, eget sollicitudin</h3>
                <span>Nulla dapibus ligula vel arcu pellentesque.</span>
            </div>
        </li>
    </ul>
</div>

