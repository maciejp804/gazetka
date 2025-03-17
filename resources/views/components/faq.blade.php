@props(['items'])
{{--@dd($items)--}}

<section class="flex 2lg:w-265 m-auto justify-center my-5">
  <div class="flex flex-col w-full">
      <x-h2-title see-more-status="false" class="flex">Najczęściej zadawane pytania</x-h2-title>
      <div class="flex flex-col lg:flex-row lg:justify-between">
          <div class="lg:w-2/3"  x-data="{ expanded: null}">
              @foreach($items->faq as $item)
                  <x-faq-item :loop="$loop->index" :question="$item['question']" :answer="$item['answer']"/>
              @endforeach
          </div>
          <div class="bg-gray-100 p-4 max-h-60 mx-7 mb-7">
              <div class="flex flex-col text-center gap-y-6">
                  <div class="flex justify-center">
                      <img src="{{asset('assets/images/statics/ask.png')}}" class="img-fluid" alt="image">
                  </div>
                  <div class="flex flex-col gap-y-6">
                      <div>
                                <span>
                                    <b>Masz pytania?</b>
                                </span>
                      </div>
                      <div>
                          <span>Napisz lub zadzwoń do nas</span>
                      </div>
                      <div class="m-auto">
                          <a href="{{route('main.contact')}}" class="flex self-center bg-orange-500 rounded-3xl px-4 py-2 text-white font-semibold text-sm text-center" >Napisz do nas</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
