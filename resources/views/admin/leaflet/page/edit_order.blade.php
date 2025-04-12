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
        <h2 class="mt-6">Aktualne strony w gazetce</h2>
        <form action="{{route('admin.leaflets.page.update.order', $leaflet)}}" method="POST">
            @csrf
            @method('PUT')

            <!-- Wyświetlanie przypisanych stron z możliwością przeciągania -->
            <ul id="sortable-pages" class="space-y-4">
                @foreach($leaflet->pages as $page)
                    <li data-id="{{ $page->id }}" class="flex justify-between items-center p-2 border rounded shadow cursor-pointer">
                        <span>{{ $page->title }}</span>
                        <img src="{{Storage::url($page->image_path.'.webp')}}" class="w-1/4" alt="sd">
                        <input type="hidden" name="pages[]" value="{{ $page->id }}">
                        <input type="hidden" name="sort_order[]" value="{{ $loop->index }}">
                    </li>
                @endforeach
            </ul>
            <x-form.submit label="Zapisz kolejność" />
        </form>
    </div>

    @vite(['resources/js/sort/sortOrder.js'])

    <script>


    </script>


</x-layout-panel>
