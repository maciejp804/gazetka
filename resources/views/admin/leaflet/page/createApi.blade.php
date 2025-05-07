<x-layout-panel>

    <x-admin.header-back/>

    <header class="bg-white shadow mb-6">
        <div class="flex justify-between mx-auto max-w-7xl">
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Leaflets</h1>
            </div>
        </div>
    </header>
    <x-admin.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <p class="font-bold mb-2">Wystąpiły błędy:</p>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <form action="{{ route('admin.leaflets.page.add.api', $leaflet) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-3 mb-2 text-center">
                <span class="text-lg text-gray-700">{{ $leaflet->shop->name }}</span>
                <span class="text-lg text-gray-700">{{ $leaflet->title }}</span>
                <span class="text-lg text-gray-700">{{ $leaflet->id }}</span>
            </div>

            <!-- Dodawanie nowych stron -->

            <x-form.input name="base" label="Link bazowy (bez numeru strony):" :required="true" placeholder="https://leclerc.pl/wp-content/uploads/2025/05/calosc_S02_Strona_"/>
            <x-form.input name="ext" label="Rozszerzenie pliku (np. .jpg, -scaled.jpg):" :required="true" placeholder=".jpg"/>
            <x-form.input type="number" name="pad" label="Liczba cyfr w numerze strony (np. 2 dla 01, 1 dla 1):" :required="true" value="2"/>
            <x-form.input type="number" name="pages" label="Liczba stron:" :required="true" />

            <x-form.submit label="Rozpocznij pobieranie" />
        </form>

    </div>

</x-layout-panel>
