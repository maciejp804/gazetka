<x-layout :main_domain>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <x-slot:place>
        {{ $place }}
    </x-slot:place>
    <x-slot:page_title>
        {{  $page_title }}
    </x-slot:page_title>
    <x-slot:meta_description>
        {{  $meta_description }}
    </x-slot:meta_description>

    <x-breadcrumbs class="mt-3" :breadcrumbs="$breadcrumbs"/>

    <div class="flex">

        {{-- Reklama pionowa po lewej stronie --}}
{{--        <x-ad-3-vertical site="justify-end"/>--}}

        <x-div-1060 class="mt-4">
                <div class="flex flex-col md:flex-row w-full">
                    <div class="flex flex-col w-full mb-5 md:mb-0 md:w-2/5 px-4 ">
                        <h1 class="flex w-full mb-5 text-2xl font-semibold text-gray-500">Kontakt</h1>
                        <div class="flex w-full mb-5">
                            <div class="w-1/2">
                                Gazetka Promocyjna<br/>
                                Kartuska 39<br/>
                                60-471 Poznań<br/>
                            </div>
                            <div class="w-1/2">
                                NIP: 7811623810<br/>
                                REGON: 639733819<br/>
                            </div>
                        </div>

                        <h2 class="flex w-full mb-5 text-2xl font-semibold text-gray-500">Szybki kontakt</h2>
                        <div class="flex w-full">
                            <span>Możesz nas złapać od poniedziałku do piątku w godzinach 8.00 - 16.00.<br/>
                                Nasz mail to:
                                <a href="mailto:kontakt@gazetkapromocyjna.com.pl" class="underline font-semibold">kontakt@gazetkapromocyjna.com.pl</a>
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col w-full md:w-3/5">
                        <h2 class="mx-4 text-2xl font-semibold text-gray-500 mb-4">Skontaktuj się z nami!</h2>
                        <p class="mx-4 text-base font-semibold text-gray-500">Wypełnij poniższy formularz, a my skontaktujemy się z Tobą w najbliższym czasie.</p>
                        <div class="contact-page">
                            <form action="/send-contact" method="POST" class="flex flex-col">
                                @csrf
                                <div class="form-group mx-4 my-2 grid grid-cols-6">
                                    <label class="col-span-2 text-gray-500 flex items-center" for="name">Imię i nazwisko:</label>
                                    <input class="col-span-4 w-full border border-gray-200 text-gray-400 bg-white-50 rounded-3xl text-sm/[24px] focus:ring-0 focus:border-gray-200 h-full"
                                           type="text" id="name" name="name" value="{{ old('name') }}" required>
                                </div>

                                <div class="form-group mx-4 my-2 grid grid-cols-6">
                                    <label class="col-span-2 text-gray-500 flex items-center" for="email">Email:</label>
                                    <input class="col-span-4 w-full border border-gray-200 text-gray-400 bg-white-50 rounded-3xl text-sm/[24px] focus:ring-0 focus:border-gray-200 h-full"
                                           type="email" id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <p class="col-start-3 col-end-6 text-sm text-red-600 italic pl-2">{{__('validation.email')}}</p>
                                    @enderror
                                </div>


                                <div class="form-group mx-4 my-2 grid grid-cols-6">
                                    <label class="col-span-2 text-gray-500 flex items-center" for="phone">Telefon: (opcjonalnie)</label>
                                    <input class="col-span-4 w-full border border-gray-200 text-gray-400 bg-white-50 rounded-3xl text-sm/[24px] focus:ring-0 focus:border-gray-200 h-full"
                                           type="tel" id="phone" name="phone" value="{{ old('phone') }}">
                                </div>

                                <div class="form-group mx-4 my-2 grid grid-cols-6">
                                    <label class="col-span-2 text-gray-500 flex items-center" for="message">Wiadomość:</label>
                                    <textarea class="col-span-4 w-full border border-gray-200 text-gray-400 bg-white-50 rounded-3xl text-sm/[24px] focus:ring-0 focus:border-gray-200 h-full"
                                              id="message" name="message" rows="5" required></textarea>
                                    @error('message')
                                    <p class="col-start-3 col-end-6 text-sm text-red-600 italic pl-2">{{__('validation.message')}}</p>
                                    @enderror
                                </div>

                                <!-- Opcjonalnie: dodanie CAPTCHA -->
                                <div class="form-group mx-4 my-2 grid grid-cols-6">
                                  <div id="recaptcha" class="g-recaptcha col-span-6 flex justify-end" data-sitekey="6LcyQ9UqAAAAAPy-e2BApiVKvu3aJn0Q7KfrCx4d"></div>
                                    @error('g-recaptcha-response')
                                    <p class="col-start-4 col-end-6 text-sm text-red-600 italic pl-2">{{__('validation.recaptcha')}}</p>
                                    @enderror
                                </div>
                                <div class="flex justify-end mx-4 my-2">
                                    <button type="submit" class="flex bg-orange-500 rounded-3xl px-4 py-2 text-white font-semibold text-sm">Wyślij</button>
                                </div>

                            </form>

                            <p class="privacy-info mx-4 my-2">
                                Twoje dane są bezpieczne i przetwarzane zgodnie z naszą <a href="/polityka-prywatnosci" class="underline font-semibold">polityką prywatności</a>.
                            </p>
                        </div>

                    </div>
                </div>



        </x-div-1060>


        {{-- Reklama pionowa po prawej stronie --}}
{{--        <x-ad-3-vertical site="justify-start"/>--}}

    </div>


</x-layout>
