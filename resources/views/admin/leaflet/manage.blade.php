<x-layout-panel>

    <x-admin.header-back/>

    <header class="bg-white shadow mb-6">
        <div class="flex justify-between mx-auto max-w-7xl">
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Leaflet - {{$leaflet->shop->name . ' ' . $leaflet->title .' (' . $leaflet->valid_from .' - '. $leaflet->valid_to .')'}}</h1>
            </div>
        </div>
    </header>
    <x-admin.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mx-4">
        @foreach($manage as $item)
            <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-between hover:shadow-md transition">
                <div class="flex justify-center">
                    <i class="{{$item['logo']}} text-2xl"></i>
                </div>
                <div class="text-center mt-2">
                    <h2 class="font-semibold text-lg">{{$item['label']}}</h2>
                </div>
                <div class="text-center mt-2">
                    <h2 class="font-normal text-gray-700 text-sm">{{$item['description']}}</h2>
                </div>
                <div class="mt-4 text-center">
                    <x-buttons.primary-a :url="$item['url']">Zarządzaj</x-buttons.primary-a>
                </div>
            </div>
        @endforeach
    </div>
</x-layout-panel>
