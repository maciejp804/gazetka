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
    <div class="flex flex-col w-full 1xl:w-356 mx-auto py-4">
        {{ $pages->links() }}
        <div class="container flex bg-white p-2 border-gray-300 rounded border mb-2">
            <!-- Lewa część: Wyszukiwarka produktów -->
            <div class="w-1/3 p-4 relative">
                <ul id="product-list">
                    @foreach($pages[0]->hotSpots as $hotSpot)
{{--                        @dd($hotSpot)--}}
                        <li class="flex border rounded-xl
                        @if(empty($hotSpot->product->image))
                        border-orange-400
                        @endif
                        p-2 mb-2 relative">
                            <form action="{{route('admin.leaflets.hotspots.deleteHotSpot',[$leaflet, $hotSpot])}}" method="POST" onsubmit="return confirm('Na pewno chcesz usunąć?')" class="absolute top-1 right-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm p-1 rounded-full border border-gray-300">🗑️</button>
                            </form>

                                <div class="product" id="product-{{ $hotSpot->id }}" draggable="true"
                                     data-id="{{ $hotSpot->id }}"
                                     data-product-id="{{ $hotSpot->product_id }}"
                                     data-status="{{ $hotSpot->status }}"
                                     data-valid_from="{{ $hotSpot->valid_from }}"
                                     data-valid_to="{{ $hotSpot->valid_to }}"
                                     data-product-name="{{ $hotSpot->product->name }}"
                                     data-page-id="{{ $hotSpot->page->id }}"
                                >
                                    {{ $hotSpot->product->name }} -  zł {{ $hotSpot->id }}
                                </div>

                        </li>
                    @endforeach

                </ul>
{{--                @dd($pages[0])--}}
                <form action="{{route('admin.leaflets.hotspots.deletePage',['leaflet' => $leaflet, 'page' => $pages[0]])}}" method="POST" onsubmit="return confirm('Na pewno chcesz usunąć?')" class="absolute bottom-0 right-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm rounded-full border border-gray-300 p-2 text-red-600 hover:underline">Skasuj produkty</button>
                </form>
            </div>

            <!-- Środkowa część: Strona gazetki -->
            <div class="w-1/3 bg-white border-gray-300">
                <div id="image-container" class="border overflow-hidden relative">
                    <img src="{{ Storage::url($pages[0]->image_path.'.webp') }}" alt="Cover" class="w-full z-10 pointer-events-none"  id="leaflet-image">
                    <!-- Canvas na rysowanie hotspotów -->
                    <canvas id="hotspot-canvas" class="absolute top-0 left-0 z-20"></canvas>
                </div>
            </div>

            <!-- Prawa część: Produkty przypisane do strony -->
            <div class="w-1/3 p-4">
                <div class="filter-box flex mr-2 w-full">
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

                <!-- Formularz do edycji danych hotspotu -->
                <div id="hotspot-form" style="display:none;">
                    <form id="hotspot-form-fields" action="" method="POST">
                        @csrf

                        <div id="method-container"></div> <!-- Laravel method will be inserted dynamically -->

                        <input type="hidden" id="hotspot-id" name="id">
                        <input type="hidden" id="image_width" name="image_width">
                        <input type="hidden" id="image_height" name="image_height">
                        <input type="hidden" id="image" name="image">
                        <input type="number" id="product_id" name="product_id" hidden="hidden" required>
                        <input type="number" id="page_id" name="page_id" hidden="hidden" required>

                        <x-form.input label="URL" name="url" type="text"/>
                        <x-form.input label="Cena" name="price" type="text"/>
                        <x-form.input label="Cena promocyjna" name="promo_price" type="text"/>
                        <x-form.select label="Status" name="status"
                                       :options="[
                                        'visible' => 'Visible',
                                        'hidden' => 'Hidden',
                                        'archived' => 'Archived']"
                                       />
                        <x-form.select label="Priorytet" name="priority"
                                       :options="[
                                        'low' => 'Low',
                                        'medium' => 'Medium',
                                        'high' => 'High']"
                        />



                        <x-form.input label="Data ważności od" name="valid_from" type="datetime-local"/>
                        <x-form.input label="Data ważności do" name="valid_to" type="datetime-local"/>

                        <input type="number" id="x" name="x" hidden="hidden">
                        <input type="number" id="y" name="y" hidden="hidden">
                        <input type="number" id="width" name="width" hidden="hidden">
                        <input type="number" id="height" name="height" hidden="hidden">
                        <x-form.submit label="Zapisz"/>
                    </form>
                </div>

            </div>
        </div>
        <div class="flex justify-around bg-white border border-gray-300 p-2">
            <div>
                <form action="{{route('admin.leaflets.hotspots.import',['leaflet' => $leaflet])}}" method="POST" enctype="multipart/form-data">
                    @csrf

                        <x-form.input-file type="file" name="file" id="import" required="required" label="Import"/>
                    <!-- Przycisk do dodania stron -->
                    <x-form.submit label="Importuj strony" />
                </form>
            </div>
            <div class="flex flex-col justify-between">
                <form action="{{route('admin.leaflets.hotspots.export', $leaflet)}}" method="GET" class="flex">
                    @csrf
                    <!-- Przycisk do dodania stron -->
                    <x-form.submit label="Exportuj strony" />
                </form>
                <form action="{{route('admin.leaflets.hotspots.delete', $leaflet)}}" method="POST" onsubmit="return confirm('Na pewno chcesz usunąć?')" class="flex">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm rounded-full border border-gray-300 p-2 text-red-600 hover:underline">Skasuj wszystko</button>
                </form>
            </div>

        </div>
    </div>





    <script>

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

            if (event.ctrlKey && event.key === 'ArrowRight') {
                // Przechodzenie do następnej strony tylko jeśli wciśnięty jest Ctrl
                nextPage();
            }
            if (event.ctrlKey && event.key === 'ArrowLeft') {
                // Przechodzenie do poprzedniej strony tylko jeśli wciśnięty jest Alt
                prevPage();
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            const canvas = document.getElementById("hotspot-canvas");
            const ctx = canvas.getContext("2d");
            const image = document.getElementById("leaflet-image");

            canvas.width = image.width;
            canvas.height = image.height;

            let isDrawing = false;
            let isDragging = false;
            let isResizing = false;
            let isDeleting = false;
            let selectedRect = null;
            let startX = 0;
            let startY = 0;
            let currentX = 0;
            let currentY = 0;
            let offsetX = 0;
            let offsetY = 0;
            let rectangles = @json($pages[0]->hotSpots);
            let image_path = "{{$pages[0]->image_path}}";

            // Funkcja do konwersji współrzędnych
            function convertCoordinates(x, y, width, height, originalWidth, originalHeight, toPercentage = true) {
                if (toPercentage) {
                    // Konwertowanie współrzędnych na procenty (z pikseli na procenty)
                    const percentageX = (x / originalWidth) * 100;
                    const percentageY = (y / originalHeight) * 100;
                    const percentageWidth = (width / originalWidth) * 100;
                    const percentageHeight = (height / originalHeight) * 100;
                    return { percentageX, percentageY, percentageWidth, percentageHeight };
                } else {
                    // Konwertowanie współrzędnych z procentów na piksele (z procentów na piksele)
                    const pixelX = (x / 100) * originalWidth;
                    const pixelY = (y / 100) * originalHeight;
                    const pixelWidth = (width / 100) * originalWidth;
                    const pixelHeight = (height / 100) * originalHeight;
                    return { pixelX, pixelY, pixelWidth, pixelHeight };
                }
            }


            // Funkcja rysująca wszystkie prostokąty
            function drawRectangles() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);  // Czyści canvas

                rectangles.forEach(rect => {

                    // Podświetlamy zaznaczony prostokąt
                    ctx.fillStyle = rect === selectedRect ? 'rgba(144, 238, 144, 0.7)' : 'rgba(135, 206, 250, 0.5)';
                    ctx.fillRect(rect.x, rect.y, rect.width, rect.height);
                    ctx.strokeStyle = 'black'; // Kolor obramowania
                    ctx.lineWidth = 1;
                    ctx.strokeRect(rect.x, rect.y, rect.width, rect.height);

                    // Rysowanie uchwytu w prawym dolnym rogu (tylko dla istniejących prostokątów)
                    if (rect === selectedRect) {
                        ctx.fillStyle = 'red';
                        ctx.fillRect(rect.x + rect.width , rect.y + rect.height , 15, 15);  // Uchwyt w prawym dolnym rogu
                        ctx.strokeStyle = 'black';
                        ctx.lineWidth = 1;
                        ctx.strokeRect(rect.x + rect.width , rect.y + rect.height , 15, 15);
                    }

                    // Rysowanie przypisanego produktu (jeśli istnieje)
                    if (rect.product) {
                        ctx.fillStyle = 'black';
                        ctx.font = "14px Arial";
                        ctx.fillText(rect.product.name, rect.x + 5, rect.y + 15); // Wyświetlanie nazwy produktu
                    }
                });

                console.log("Tablica prostokątów po rysowaniu:", rectangles); // Logowanie po każdym rysowaniu
            }

            // Funkcja do sprawdzania, czy kliknięto na prostokąt
            function isMouseOnRectangle(x, y, rect) {
                return x >= rect.x && x <= rect.x + rect.width && y >= rect.y && y <= rect.y + rect.height;
            }

            // Funkcja do sprawdzania, czy kliknięto w uchwyt
            function isMouseOnResizeHandle(x, y, rect) {
                const handleSize = 10;
                return x >= rect.x + rect.width - handleSize && x <= rect.x + rect.width + handleSize &&
                    y >= rect.y + rect.height - handleSize && y <= rect.y + rect.height + handleSize;
            }

            // Funkcja do aktywowania prostokąta po kliknięciu na produkt
            function activateRectangleForProduct(dataId) {
                selectedRect = rectangles.find(rect => rect.id ==dataId);
                if (selectedRect) {
                    rectangles = rectangles.filter(rect => rect !== selectedRect);
                    rectangles.push(selectedRect);

                    // updateHotspotInDatabase(selectedRect.id, { status: 'visible' });
                    drawRectangles();  // Rysowanie po zmianie statusu
                    openHotspotForm(selectedRect);  // <- otwieramy formularz!
                }
            }

            // Funkcja do dodawania produktu do prostokąta
            function addProductToRectangle(product, rect) {
                rect.product = product;
                drawRectangles();
                console.log("Produkt przypisany do prostokąta:", rectangles); // Logowanie po przypisaniu produktu
            }

            // Funkcja do usuwania prostokąta
            function deleteRectangle(x, y) {
                const initialLength = rectangles.length;
                rectangles = rectangles.filter(rect => !isMouseOnRectangle(x, y, rect));  // Usuwamy prostokąt, na który kliknięto
                if (rectangles.length < initialLength) {
                    console.log("Prostokąt usunięty. Nowa tablica:", rectangles); // Logowanie po usunięciu
                    drawRectangles(); // Rysujemy ponownie zaktualizowane prostokąty
                }
            }

            // Funkcja do aktywowania formularza edycji po kliknięciu na prostokąt
            function openHotspotForm(rect) {

                const form = document.getElementById('hotspot-form-fields');
                const methodContainer = document.getElementById('method-container');
                const formId = document.getElementById('hotspot-id');

                const rectUrl = rect.url || ''; // pełny link afiliacyjny
                let finalUrl = rectUrl;

                try {
                    const parsed = new URL(rectUrl);
                    const targetUrl = parsed.searchParams.get('url');
                    if (targetUrl) {
                        finalUrl = decodeURIComponent(targetUrl);
                    }
                } catch (e) {
                    console.warn('Nieprawidłowy URL:', rectUrl);
                }





                // Sprawdzamy, czy prostokąt ma przypisane ID
                if (rect.id) {
                    // Jeśli ID istnieje, to ustawiamy metodę PUT (aktualizacja)
                    form.action = '{{route('admin.leaflets.hotspots.update', ['leaflet' => $leaflet->id])}}';
                    form.method = 'POST';
                    methodContainer.innerHTML = `<input type="hidden" name="_method" value="PUT">`;
                    // Ustawiamy ID w formularzu
                    formId.value = rect.id;
                } else {
                    // Jeśli ID nie istnieje, to ustawiamy metodę POST (tworzenie)
                    // form.action = '/createHotSpot';
                    form.method = 'POST';

                    methodContainer.innerHTML = '';

                    formId.value = '';  // Brak ID dla nowego prostokąta
                }


                // Wypełniamy formularz danymi przypisanymi do prostokąta
                document.getElementById('hotspot-id').value = rect.id;
                document.getElementById('page_id').value = rect.product && rect.product.page_id ? rect.product.page_id : rect.page_id || '';
                document.getElementById('product_id').value = rect.product ? rect.product.id : '';
                document.getElementById('image_width').value = image.width;
                document.getElementById('image_height').value = image.height;
                document.getElementById('image').value = image_path;
                document.getElementById('status').value = rect.status || 'hidden';
                document.getElementById('priority').value = rect.priority || 'low';
                document.getElementById('price').value = rect.price || '';
                document.getElementById('promo_price').value = rect.promo_price || '';
                document.getElementById('url').value = finalUrl;

                // Wypełnianie formularza danymi
                document.getElementById('valid_from').value = rect.product && rect.product.valid_from ? rect.product.valid_from : rect.valid_from || '';
                document.getElementById('valid_to').value = rect.product && rect.product.valid_to ? rect.product.valid_to : rect.valid_to || '';
                document.getElementById('x').value = rect.product && rect.product.x ? Math.round(rect.product.x) : Math.round(rect.x) || '';
                document.getElementById('y').value = rect.product && rect.product.y ? Math.round(rect.product.y) : Math.round(rect.y) || '';
                document.getElementById('width').value = rect.product && rect.product.width ? Math.round(rect.product.width) : Math.round(rect.width) || '';
                document.getElementById('height').value = rect.product && rect.product.height ? Math.round(rect.product.height) : Math.round(rect.height) || '';

                // Pokazujemy formularz
                document.getElementById('hotspot-form').style.display = 'block';
            }

            // Słuchacz do mousedown, aby otworzyć formularz lub podświetlić prostokąt
            canvas.addEventListener('mousedown', (e) => {
                const rect = canvas.getBoundingClientRect();
                const clickX = e.clientX - rect.left;
                const clickY = e.clientY - rect.top;

                let clickedOnRectangle = false;  // Zmienna do śledzenia, czy kliknięto na prostokąt

                // Sprawdzamy, czy kliknięto na prostokąt
                for (let i = rectangles.length - 1; i >= 0; i--) {
                    const rectItem = rectangles[i];
                    if (isMouseOnRectangle(clickX, clickY, rectItem)) {
                        selectedRect = rectItem;  // Zaznaczamy prostokąt
                        openHotspotForm(selectedRect);  // Otwórz formularz z danymi prostokąta
                        clickedOnRectangle = true;  // Ustawiamy flagę, że kliknięto na prostokąt
                        drawRectangles();  // Rysujemy wszystkie prostokąty bez podświetlenia

                        break;
                    }
                }

                // Jeśli kliknięto poza prostokąt, ukryj formularz i resetuj zaznaczenie
                if (!clickedOnRectangle) {
                    document.getElementById('hotspot-form').style.display = 'none';
                    selectedRect = null;  // Resetujemy zaznaczenie
                    drawRectangles();  // Rysujemy wszystkie prostokąty bez podświetlenia
                }
            });

            // Słuchacz dla mousedown - początek rysowania lub edycji
            canvas.addEventListener('mousedown', (e) => {
                const rect = canvas.getBoundingClientRect();
                currentX = e.clientX - rect.left;
                currentY = e.clientY - rect.top;

                selectedRect = null;  // Resetujemy zaznaczony prostokąt
                isDragging = false;
                isResizing = false;

                // Sprawdzamy, czy kliknięto na jakiś prostokąt lub uchwyt (od tyłu do przodu)
                for (let i = rectangles.length - 1; i >= 0; i--) {
                    const rectItem = rectangles[i];
                    if (isMouseOnResizeHandle(currentX, currentY, rectItem)) {
                        selectedRect = rectItem;
                        isResizing = true;  // Jeśli kliknięto na uchwyt, zaczynamy zmianę rozmiaru
                        break;
                    } else if (isMouseOnRectangle(currentX, currentY, rectItem)) {
                        selectedRect = rectItem;
                        isDragging = true;  // Jeśli kliknięto na prostokąt, zaczynamy przeciąganie
                        offsetX = currentX - selectedRect.x;  // Oblicz offset w poziomie
                        offsetY = currentY - selectedRect.y;  // Oblicz offset w pionie
                        break;
                    }
                }

                if (!isDragging && !isResizing) {
                    isDrawing = true;
                    startX = currentX;
                    startY = currentY;
                }
            });

            // Słuchacz dla mousemove - rysowanie lub przeciąganie
            canvas.addEventListener('mousemove', (e) => {
                const rect = canvas.getBoundingClientRect();
                currentX = e.clientX - rect.left;
                currentY = e.clientY - rect.top;

                if (isDrawing) {
                    const width = Math.round(currentX - startX);
                    const height = Math.round(currentY - startY);

                    // Rysowanie wszystkich prostokątów na canvasie
                    drawRectangles();

                    ctx.fillStyle = 'rgba(135, 206, 250, 0.5)';
                    ctx.fillRect(startX, startY, width, height);
                    ctx.strokeStyle = 'black';
                    ctx.lineWidth = 1;
                    ctx.strokeRect(startX, startY, width, height);
                }

                if (isDragging && selectedRect) {
                    selectedRect.x = currentX - offsetX;
                    selectedRect.y = currentY - offsetY;

                    // Zaktualizuj formularz po przesunięciu prostokąta
                    openHotspotForm(selectedRect);

                    drawRectangles();
                }

                if (isResizing && selectedRect) {
                    const deltaX = Math.round(currentX - (selectedRect.x + selectedRect.width));
                    const deltaY = Math.round(currentY - (selectedRect.y + selectedRect.height));

                    selectedRect.width += deltaX;
                    selectedRect.height += deltaY;

                    // Prevent negative width or height
                    if (selectedRect.width < 0) selectedRect.width = 0;
                    if (selectedRect.height < 0) selectedRect.height = 0;

                    openHotspotForm(selectedRect);
                    drawRectangles();
                }
            });

            // Słuchacz dla mouseup - zakończenie rysowania lub przeciągania
            canvas.addEventListener('mouseup', () => {
                if (isDrawing) {
                    const width = currentX - startX;
                    const height = currentY - startY;
                    if (Math.abs(width) > 0 && Math.abs(height) > 0) {
                        rectangles.push({ x: Math.min(startX, currentX), y: Math.min(startY, currentY), width: Math.abs(width), height: Math.abs(height) });
                        console.log("Nowy prostokąt dodany:", rectangles); // Logowanie po dodaniu nowego prostokąta
                    }
                    isDrawing = false;
                    drawRectangles(); // Redraw after adding a new rectangle
                }

                isDragging = false;
                isResizing = false;
            });

            // Słuchacz dla mouseout - kończy rysowanie, gdy kursor wyjdzie z canvas
            canvas.addEventListener('mouseout', () => {
                isDrawing = false;
                isDragging = false;
                isResizing = false;
            });

            // Logika przeciągania produktów z listy po prawej stronie
            const productList = document.getElementById('product-list');
            const productItems = productList.querySelectorAll('.product');

            productItems.forEach((item) => {

                item.addEventListener('click', (e) => {
                    const dataId = item.getAttribute('data-id');
                    activateRectangleForProduct(dataId);
                });

                item.addEventListener('dragstart', (e) => {
                    const productId = item.getAttribute('data-product-id');
                    const page_id = item.getAttribute('data-page-id');
                    const productName = item.getAttribute('data-product-name');
                    const valid_from = item.getAttribute('data-valid_from');
                    const valid_to = item.getAttribute('data-valid_to');
                    e.dataTransfer.setData("productId", productId); // Przechowujemy ID produktu w drag-and-drop
                    e.dataTransfer.setData("page_id", page_id); // Przechowujemy ID produktu w drag-and-drop
                    e.dataTransfer.setData("productName", productName); // Przechowujemy nazwę produktu
                    e.dataTransfer.setData("valid_to", valid_to); // Przechowujemy ID valid_to w drag-and-drop
                    e.dataTransfer.setData("valid_from", valid_from); // Przechowujemy nazwę valid_from
                });
            });

            // Umożliwiamy przeciąganie produktu na canvas
            canvas.addEventListener('dragover', (e) => {
                e.preventDefault(); // Aby umożliwić upuszczenie
            });

            canvas.addEventListener('drop', (e) => {
                e.preventDefault();
                const rect = canvas.getBoundingClientRect();
                const dropX = e.clientX - rect.left;
                const dropY = e.clientY - rect.top;

                const productId = e.dataTransfer.getData("productId");
                const page_id = e.dataTransfer.getData("page_id");
                const productName = e.dataTransfer.getData("productName");
                const valid_to = e.dataTransfer.getData("valid_to");
                const valid_from = e.dataTransfer.getData("valid_from");


                // Sprawdzamy, czy upuszczono na zaznaczony prostokąt
                if (selectedRect && isMouseOnRectangle(dropX, dropY, selectedRect)) {
                    const product = {
                        id: productId,
                        page_id: page_id,
                        name: productName,
                        valid_from: valid_from,
                        valid_to: valid_to
                    };
                    addProductToRectangle(product, selectedRect);
                    selectedRect = null; // Reset selected rectangle after dropping
                }
            });

            // Dodanie możliwości usuwania prostokąta po kliknięciu z wciśniętym klawiszem Shift
            canvas.addEventListener('mousedown', (e) => {
                if (e.shiftKey) {
                    const rect = canvas.getBoundingClientRect();
                    const clickX = e.clientX - rect.left;
                    const clickY = e.clientY - rect.top;
                    deleteRectangle(clickX, clickY);
                }
            });

            console.log("Początkowa tablica prostokątów:", rectangles); // Logowanie początkowego stanu tablicy
            drawRectangles(); // Initial draw in case there are any pre-existing rectangles
        });

    </script>

</x-layout-panel>
