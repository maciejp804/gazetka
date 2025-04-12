<x-layout-panel>

    <x-admin.header-back/>

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
    <div class="flex flex-col w-full 1xl:w-356 mx-auto">
        {{ $pages->links() }}
        <div class="container flex bg-white p-2 border-gray-300 rounded border">
            <!-- Lewa część: Wyszukiwarka produktów -->
            <div class="w-1/3 p-4">
                <ul>
                    @foreach($pageClicks as $pageClick)
{{--                        @dd($pageClick)--}}
                        <li class="border p-2 mb-2 relative">
                            <form action="{{route('admin.leaflets.page.product.destroy', [$leaflet, $pageClick] )}}" method="POST" onsubmit="return confirm('Na pewno chcesz usunąć?')" class="absolute top-1 right-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm p-1 rounded-full border border-gray-300">🗑️</button>
                            </form>
                            {{ $pageClick->leafletProduct->product->name }} -  zł {{ $pageClick->id }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Środkowa część: Strona gazetki -->
            <div class="w-1/3 bg-white border-gray-300">
                <div id="hover-box" class="border overflow-hidden">
                    <img  src="{{ Storage::url($pages[0]->image_path.'.webp') }}" alt="Cover" class="w-full ">
                </div>
            </div>

            <!-- Prawa część: Produkty przypisane do strony -->
            <div class="w-1/3 p-4">
                <div class="filter-box flex mr-2 w-full ">
                    <x-admin.search class="flex"
                              placeholder="Szukaj produktu np. masło, chleb"
                              input-id="search-input-products-desktop"
                              result-id="results-box-products-desktop"
                              data-search-type="admin-products"
                                    :leaflet_id="$leaflet->id"
                                    :page_id="$pages[0]->id"
                                    autofocus="true"
                    >

                    </x-admin.search>
                </div>
            </div>
        </div>
    </div>




    <script>
        const hoverBox = document.getElementById('hover-box');

        hoverBox.addEventListener('mousemove', function(e) {
            const rect = hoverBox.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            hoverBox.style.transformOrigin = `${(x / rect.width) * 100}% ${(y / rect.height) * 100}%`;
        });

        hoverBox.addEventListener('mouseenter', function() {
            hoverBox.style.transition = "transform 0.3s ease";
        });

        hoverBox.addEventListener('mouseleave', function() {
            hoverBox.style.transformOrigin = 'center';
        });


        document.addEventListener('keydown', function(event) {

            const currentPage = {{ $pages->currentPage() }}; // Bieżąca strona (przekazana z Laravel)
            const totalPages = {{ $pages->lastPage() }}; // Całkowita liczba stron
            const baseUrl = window.location.href.split('?')[0]; // Podstawowy URL bez parametrów

            // Funkcja do przejścia do następnej strony
            function nextPage() {
                if (currentPage < totalPages) {
                    window.location.href = baseUrl + `?page=${currentPage + 1}`;
                }
            }

            // Funkcja do przejścia do poprzedniej strony
            function prevPage() {
                if (currentPage > 1) {
                    window.location.href = baseUrl + `?page=${currentPage - 1}`;
                }
            }

            if (event.altKey && event.key === 'ArrowRight') {
                // Przechodzenie do następnej strony tylko jeśli wciśnięty jest Ctrl
                nextPage();
            }
            if (event.altKey && event.key === 'ArrowLeft') {
                // Przechodzenie do poprzedniej strony tylko jeśli wciśnięty jest Alt
                prevPage();
            }
        });

    </script>

</x-layout-panel>

