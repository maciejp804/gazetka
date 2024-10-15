@props(['inserts', 'index', 'insertData'])


    <div class="absolute top-0 left-0 w-full h-full z-10 pointer-events-none">
        <div class="sub-swiper h-full w-full">
            <div class="sub-swiper-wrapper swiper-wrapper flex">
                <x-insert-slide-empty data="1"/>
                <x-insert-slide :index="$index" :inserts="$inserts" :insertData="$insertData" data="2"/>
                <x-insert-slide-empty data="3"/>
            </div>

        </div>
    </div>

