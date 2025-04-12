<x-layout-panel>

    <x-admin.header-back/>

    <header class="bg-white shadow mb-6">
        <div class="flex justify-between mx-auto max-w-7xl">
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Leaflets</h1>
            </div>
            <div class="flex items-center w-1/3">
                <input type="text" id="search-leaflets" placeholder="Szukaj gazetki..."
                       class="w-full border border-gray-200 focus:border-gray-200
                       placeholder-gray-400 focus:outline-none focus:ring-0 bg-white-50 rounded-3xl px-4 py-2 shadow" />
            </div>
            <div class="flex items-center px-4">
                <x-buttons.primary-a :url="route('admin.leaflets.create')">Dodaj gazetkę</x-buttons.primary-a>
            </div>
        </div>
    </header>
    <x-admin.breadcrumbs :breadcrumbs="$breadcrumbs"/>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div id="leaflet-results" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
          <x-admin.leaflet-item :items="$leaflets"/>
        </div>
    </div>
    <script>
        document.getElementById('search-leaflets').addEventListener('input', function () {
            const query = this.value;

            fetch(`/panel/leaflets/search?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById('leaflet-results');
                    container.innerHTML = '';

                    if (data.length === 0) {
                        container.innerHTML = '<p class="text-gray-500 col-span-4 text-center">Brak wyników</p>';

                    } else {
                        container.innerHTML = data.html;
                    }

                                    });
        });
    </script>


</x-layout-panel>
