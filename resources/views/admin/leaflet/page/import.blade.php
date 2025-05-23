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
        <h2 class="mt-6 text-xl font-semibold">Aktualne strony w gazetce</h2>
        <form method="GET" action="{{ route('admin.leaflets.pages.filter') }}" class="mb-6">
            <input type="hidden" name="target_leaflet" value="{{ $leaflet->id }}">

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium">Sieć handlowa</label>
                    <select name="shop_id" class="w-full border rounded">
                        <option value="">-- Wszystkie --</option>
                        @foreach($shops as $shop)
                            <option value="{{ $shop->id }}" @selected(request('shop_id') == $shop->id)>{{ $shop->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Produkt (nazwa / EAN)</label>
                    <input type="text" name="product" value="{{ request('product') }}" class="w-full border rounded">
                </div>

                <div class="flex items-end">
                    <x-form.submit label="Filtruj strony" />
                </div>
            </div>
        </form>

        @if($filteredPages->count())
            <form method="POST" action="{{ route('admin.leaflets.pages.import', $leaflet) }}">
                @csrf
                <ul class="space-y-2">
                    @foreach($filteredPages as $page)
                        <li class="border p-3 rounded flex items-center justify-between">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="selected_pages[]" value="{{ $page->id }}">
                                <span>{{ $page->title ?? 'Strona #' . $page->id }}</span>
                            </label>
                            <img src="{{ Storage::url($page->image_path . '.webp') }}" class="w-16 h-auto rounded shadow">
                        </li>
                    @endforeach
                </ul>

                <x-form.submit label="➕ Dodaj wybrane strony" class="mt-4" />
            </form>
        @else
            <p class="text-sm text-gray-500 mt-4">Brak pasujących stron do wyświetlenia.</p>
        @endif

    </div>


    @vite(['resources/js/sort/sortOrder.js'])

    <script>
        document.getElementById('select-all').addEventListener('change', function () {
            document.querySelectorAll('.bulk-checkbox').forEach(cb => cb.checked = this.checked);
        });
    </script>


</x-layout-panel>
