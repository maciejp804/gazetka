<div {{ $attributes->merge(['class' => '']) }}>
    <div class="flex justify-center">
        <div class="bg-white flex 2lg:w-265 rounded shadow-2xl">
            <div class="p-2 w-full">
                <div class="flex flex-col gap-y-2 relative lg:flex-row lg:self-center">
                    <div class="absolute top-[4%] right-[4%] w-14 lg:w-24 lg:relative lg:flex lg:right-0 lg:top-0 lg:p-4 lg:self-center">
                        <img src="https://hoian.pl/assets/image/pro/promotion 1.png" alt="photo">
                    </div>
                    <div class="flex flex-col relative gap-y-2">
                        <span class="text-gray-700 font-semibold text-sm">Newsletter</span>
                        <span>
                      <b>Warto wiedzieć więcej!</b>
                    </span>
                        <p class="mt-2 text-gray-700 text-sm">Bądź na bieżąco, sprawdzaj promocje, dowiaduj się o najnowszych ofertach specjalnych</p>

{{--                        <img class="absolute top-[4%] right-[4%] w-14 hidden" src="https://hoian.pl/assets/image/pro/promotion 1.png" alt="photo">--}}
                    </div>
                    <div class="flex lg:w-1/2">
                        <div class="flex w-full justify-center items-center mx-auto lg:w-10/12">
                            <form class="flex w-full h-11 relative" action="" method="post" id="subscribe-form">
                                <x-header.svg svg="envelope" class="absolute left-4 self-center flex" colour="fill-gray-400" size="h-4 w-4"/>
                                <input type="email" name="email" placeholder="Twój e-mail" class="w-full pl-8 rounded-3xl border-gray-400 bg-gray-200 text-sm" required="">
                                <button type="submit" class="absolute right-1 flex self-center bg-orange-500 rounded-3xl px-4 py-2 text-white font-semibold text-sm">Zapisz się</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
