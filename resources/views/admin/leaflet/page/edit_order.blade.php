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
        <div class="mt-4">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" id="select-all">
                <span>Zaznacz wszystko</span>
            </label>
        </div>
        {{-- Formularz sortowania + masowego usuwania --}}
        <form action="{{ route('admin.leaflets.page.update.order', $leaflet) }}" method="POST" id="bulk-delete-form">
            @csrf
            @method('PUT')

            {{-- Lista stron --}}
            <ul id="sortable-pages" class="space-y-4 mt-4">
                @foreach($leaflet->pages as $page)
                    <li data-id="{{ $page->id }}" class="flex justify-between items-center p-2 border rounded shadow cursor-pointer gap-4">
                        <div class="flex items-center gap-3 flex-1">
                            <input type="checkbox" name="selected_pages[]" value="{{ $page->id }}" class="bulk-checkbox">
                            <img src="{{ Storage::url($page->image_path . '.webp') }}" class="w-24 rounded shadow" alt="">
                            <span class="text-sm">{{ $page->title ?? 'Strona ' . ($loop->iteration) }}</span>
                        </div>

                        <input type="hidden" name="pages[]" value="{{ $page->id }}">
                        <input type="hidden" name="sort_order[]" value="{{ $loop->index }}">
                    </li>
                @endforeach
            </ul>

            {{-- Akcje --}}
            <div class="flex justify-between items-center mt-6">
                <div>
                    <x-form.submit label="💾 Zapisz" onclick="return confirm('Na pewno zmienić zaznaczone strony?')"/>
                </div>

            </div>
        </form>

        {{-- Zaznacz wszystko --}}

    </div>


    @vite(['resources/js/sort/sortOrder.js'])

    <script>
        document.getElementById('select-all').addEventListener('change', function () {
            document.querySelectorAll('.bulk-checkbox').forEach(cb => cb.checked = this.checked);
        });
    </script>


</x-layout-panel>
