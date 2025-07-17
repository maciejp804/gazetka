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
                            <form action="{{route('admin.leaflets.hotspots.deleteHotSpot',[$leaflet, $hotSpot])}}" method="POST" class="absolute top-1 right-1">
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

                        <div class="grid grid-cols-12 gap-2 items-center">
                            <div class="col-span-11">
                                <x-form.input label="URL" name="url" type="text"/>
                            </div>
                            <div class="col-span-1 flex justify-end items-center">
                                <button type="button" id="fetch-product" class="text-xl text-blue-500 hover:text-red-700" title="Pobierz dane">
                                    <i class="fa-solid fa-rotate"></i>
                                </button>
                            </div>
                        </div>

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
                    <input type="hidden" id="image_width_import" name="image_width_import">
                    <input type="hidden" id="image_height_import" name="image_height_import">
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

            // Wypełnij ukryte pola importu obrazka
            document.getElementById('image_width_import').value = canvas.width;
            document.getElementById('image_height_import').value = canvas.height;

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

            console.log(rectangles);
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
            // Zamiast dotychczasowego drawRectangles(), użyj poniższego:
            function drawRectangles() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                // 1) Najpierw narysuj wszystkie prostokąty, które NIE są zaznaczone:
                rectangles.forEach(rect => {
                    if (rect === selectedRect) return; // pomiń, to narysujemy później
                    const px = convertCoordinates(
                        rect.x, rect.y, rect.width, rect.height,
                         image.width,
                         image.height,
                        false
                    );
                    rect._px = px;

                    ctx.fillStyle = 'rgba(135, 206, 250, 0.5)';   // nieaktywne: niebieskie tło
                    ctx.fillRect(px.pixelX, px.pixelY, px.pixelWidth, px.pixelHeight);
                    ctx.strokeStyle = 'black';
                    ctx.lineWidth = 1;
                    ctx.strokeRect(px.pixelX, px.pixelY, px.pixelWidth, px.pixelHeight);

                    if (rect.product) {
                        ctx.fillStyle = 'black';
                        ctx.font = "14px Arial";
                        ctx.fillText(rect.product.name, px.pixelX + 5, px.pixelY + 15);
                    }
                });

                // 2) Jeśli jest zaznaczony prostokąt, narysuj go TERAZ (ostatnim):
                if (selectedRect) {
                    const rect = selectedRect;
                    const px = convertCoordinates(
                        rect.x, rect.y, rect.width, rect.height,
                        image.width,
                        image.height,
                        false
                    );
                    rect._px = px;

                    ctx.fillStyle = 'rgba(144, 238, 144, 0.7)';   // zaznaczony: zielonkawe tło
                    ctx.fillRect(px.pixelX, px.pixelY, px.pixelWidth, px.pixelHeight);
                    ctx.strokeStyle = 'black';
                    ctx.lineWidth = 1;
                    ctx.strokeRect(px.pixelX, px.pixelY, px.pixelWidth, px.pixelHeight);

                    // uchwyt w prawym dolnym rogu dla zaznaczonego
                    ctx.fillStyle = 'red';
                    ctx.fillRect(px.pixelX + px.pixelWidth, px.pixelY + px.pixelHeight, 15, 15);
                    ctx.strokeStyle = 'black';
                    ctx.lineWidth = 1;
                    ctx.strokeRect(px.pixelX + px.pixelWidth, px.pixelY + px.pixelHeight, 15, 15);

                    if (rect.product) {
                        ctx.fillStyle = 'black';
                        ctx.font = "14px Arial";
                        ctx.fillText(rect.product.name, px.pixelX + 15, px.pixelY + 15);
                    }
                }

                console.log("Tablica prostokątów po rysowaniu:", rectangles);
            }


            // Funkcja do sprawdzania, czy kliknięto na prostokąt
            function isMouseOnRectangle(x, y, rect) {
                const px = rect._px;
                return x >= px.pixelX && x <= px.pixelX + px.pixelWidth && y >= px.pixelY && y <= px.pixelY + px.pixelHeight;
            }

            // Funkcja do sprawdzania, czy kliknięto w uchwyt
            function isMouseOnResizeHandle(x, y, rect) {
                const handleSize = 10;
                const px = rect._px;
                return x >= px.pixelX + px.pixelWidth - handleSize && x <= px.pixelX + px.pixelWidth + handleSize &&
                    y >= px.pixelY + px.pixelHeight - handleSize && y <= px.pixelY + px.pixelHeight + handleSize;
            }

            function activateRectangleForProduct(dataId) {
                // Znajdź indeks prostokąta po id (porównując typy luźno)
                const index = rectangles.findIndex(r => r.id == dataId);
                if (index !== -1) {
                    selectedRect = rectangles[index];
                    // Usuń go z tablicy za pomocą splice i dodaj na koniec
                    rectangles.splice(index, 1);
                    rectangles.push(selectedRect);
                    drawRectangles();
                    openHotspotForm(selectedRect);
                } else {
                    console.warn('Nie znaleziono prostokąta dla produktu ID:', dataId);
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

            // ... (początek Twojego pliku, bez zmian) ...

            canvas.addEventListener('mousedown', (e) => {
                const rectBounds = canvas.getBoundingClientRect();
                const clickX = e.clientX - rectBounds.left;
                const clickY = e.clientY - rectBounds.top;

                // 1) Jeśli Shift+klikamy, usuwamy hotspot i od razu zwracamy:
                if (e.shiftKey) {
                    deleteRectangle(clickX, clickY);
                    selectedRect = null;
                    return;
                }

                // 2) Sprawdzamy, czy kliknięto w istniejący prostokąt → otwieramy formularz
                for (let i = rectangles.length - 1; i >= 0; i--) {
                    const r = rectangles[i];
                    if (isMouseOnRectangle(clickX, clickY, r)) {
                        selectedRect = r;
                        // przenosimy ten rect na wierzch, żeby rysować go ostatnim:
                        rectangles = rectangles.filter(r2 => r2 !== r);
                        rectangles.push(r);
                        drawRectangles();
                        openHotspotForm(r);
                        // *** UWAGA: nie zwracamy od razu, bo chcemy też sprawdzić drag/resize ***
                        //    jednak w tym momencie setujemy, że będzie to kliknięcie w hotspot,
                        //    więc nie chcemy przejść dalej do rysowania nowego prostokąta.
                    break;
                    }
                }

                // 3) Resetujemy stany (na wszelki wypadek)
                isDrawing = false;
                isDragging = false;
                isResizing = false;

                // 4) Sprawdzamy, czy kliknięcie trafiło w uchwyt (resize), albo w wnętrze prostokąta (drag):
                for (let i = rectangles.length - 1; i >= 0; i--) {
                    const r = rectangles[i];
                    if (isMouseOnResizeHandle(clickX, clickY, r)) {
                        // Klik w uchwyt → zaczynamy RESIZE
                        selectedRect = r;
                        isResizing = true;
                        return;
                    }
                    else if (isMouseOnRectangle(clickX, clickY, r)) {
                        // Klik w prostokąt (ale nie w formularz, bo to już wyłapaliśmy w kroku 2)
                        selectedRect = r;
                        // Obliczamy przesunięcie (offset) względem lewego-górnego rogu prostokąta
                        offsetX = clickX - r._px.pixelX;
                        offsetY = clickY - r._px.pixelY;
                        isDragging = true;
                        // przenosimy ten rect na wierzch:
                        rectangles = rectangles.filter(r2 => r2 !== r);
                        rectangles.push(r);
                        drawRectangles();
                        openHotspotForm(r);
                        return;
                    }
                }

                // 5) Jeśli nie kliknięto w żaden prostokąt ani uchwyt → start rysowania nowego
                selectedRect = null;
                startX = clickX;
                startY = clickY;
                isDrawing = true;
                drawRectangles();
                document.getElementById('hotspot-form').style.display = 'none';
            });


            canvas.addEventListener('mousemove', (e) => {
                const rectBounds = canvas.getBoundingClientRect();
                currentX = e.clientX - rectBounds.left;
                currentY = e.clientY - rectBounds.top;

                // ** 1. Drag (przeciąganie) istniejącego hotspotu **
                if (isDragging && selectedRect) {
                    // 1) Obliczamy nowe pikselowe X/Y względem lewego-górnego rogu canvasa:
                    const newPixelX = currentX - offsetX;
                    const newPixelY = currentY - offsetY;

                    // 2) Przeliczamy te piksele na procenty względem wymiaru obrazka:
                    const percent = convertCoordinates(
                        newPixelX,               // x w px
                        newPixelY,               // y w px
                        selectedRect._px.pixelWidth,   // szerokość w px
                        selectedRect._px.pixelHeight,  // wysokość w px
                        image.width,             // oryginalna szerokość obrazka w px
                        image.height,            // oryginalna wysokość obrazka w px
                        true                     // zwracamy procenty
                    );

                    // 3) Ustawiamy wartości procentowe w rect.x / rect.y:
                    selectedRect.x = percent.percentageX;
                    selectedRect.y = percent.percentageY;

                    // 4) Odświeżamy rysowanie i formularz:
                    openHotspotForm(selectedRect);
                    drawRectangles();
                    return;
                }


                // ** 2. Resize (zmiana rozmiaru) istniejącego hotspotu **
                if (isResizing && selectedRect) {
                    const px = selectedRect._px;
                    const newWidth = currentX - px.pixelX;
                    const newHeight = currentY - px.pixelY;
                    // przeliczamy na procenty, bo zmieniamy proporcje
                    const percent = convertCoordinates(
                        px.pixelX,
                        px.pixelY,
                        newWidth,
                        newHeight,
                        image.width,
                        image.height,
                        true
                    );
                    selectedRect.width = Math.max(percent.percentageWidth, 0);
                    selectedRect.height = Math.max(percent.percentageHeight, 0);

                    drawRectangles();
                    openHotspotForm(selectedRect);
                    return;
                }

                // ** 3. Drawing (rysowanie nowego prostokąta) **
                if (isDrawing) {
                    drawRectangles();
                    const widthPx = currentX - startX;
                    const heightPx = currentY - startY;
                    ctx.fillStyle = 'rgba(135, 206, 250, 0.5)';
                    ctx.fillRect(startX, startY, widthPx, heightPx);
                    ctx.strokeStyle = 'black';
                    ctx.strokeRect(startX, startY, widthPx, heightPx);
                }
            });


            canvas.addEventListener('mouseup', () => {
                // Jeżeli tworzyliśmy nowy prostokąt (isDrawing), dodajemy go w % do tablicy
                if (isDrawing) {
                    const widthPx = currentX - startX;
                    const heightPx = currentY - startY;
                    if (Math.abs(widthPx) > 3 && Math.abs(heightPx) > 3) {
                        const percent = convertCoordinates(
                            Math.min(startX, currentX),
                            Math.min(startY, currentY),
                            Math.abs(widthPx),
                            Math.abs(heightPx),
                            image.width,
                            image.height,
                            true
                        );
                        rectangles.push({
                            x: percent.percentageX,
                            y: percent.percentageY,
                            width: percent.percentageWidth,
                            height: percent.percentageHeight,
                            image_width: image.width,
                            image_height: image.height
                        });
                        console.log("Dodano nowy prostokąt w %:", rectangles[rectangles.length - 1]);
                        drawRectangles();
                    }
                }
                // wyłączamy wszystkie tryby
                isDragging = false;
                isResizing = false;
                isDrawing = false;
            });


            canvas.addEventListener('mouseout', () => {
                isDragging = false;
                isResizing = false;
                isDrawing = false;
            });



            const productItems = [...document.querySelectorAll('#product-list .product')];
            productItems.forEach(item => {
                item.addEventListener('click', () => {
                    const dataId = item.getAttribute('data-id');
                    activateRectangleForProduct(dataId);
                });
                item.addEventListener('dragstart', e => {
                    e.dataTransfer.setData("productId", item.dataset.productId);
                    e.dataTransfer.setData("page_id", item.dataset.pageId);
                    e.dataTransfer.setData("productName", item.dataset.productName);
                    e.dataTransfer.setData("valid_from", item.dataset.valid_from);
                    e.dataTransfer.setData("valid_to", item.dataset.valid_to);
                });
            });

            canvas.addEventListener('dragover', e => e.preventDefault());
            canvas.addEventListener('drop', e => {
                e.preventDefault();
                const rectBounds = canvas.getBoundingClientRect();
                const dropX = e.clientX - rectBounds.left;
                const dropY = e.clientY - rectBounds.top;
                const productId = e.dataTransfer.getData("productId");
                const page_id = e.dataTransfer.getData("page_id");
                const productName = e.dataTransfer.getData("productName");
                const valid_from = e.dataTransfer.getData("valid_from");
                const valid_to = e.dataTransfer.getData("valid_to");
                if (selectedRect && isMouseOnRectangle(dropX, dropY, selectedRect)) {
                    selectedRect.product = { id: productId, page_id: page_id, name: productName, valid_from: valid_from, valid_to: valid_to };
                    console.log("Produkt przypisany:", selectedRect.product);
                    drawRectangles();
                    selectedRect = null;
                }
            });

            drawRectangles();
        });

        document.getElementById('fetch-product').addEventListener('click', function () {
            const url = document.getElementById('url').value;

            if (!url) {
                alert('Podaj URL produktu!');
                return;
            }

            fetch('{{ route('admin.leaflets.hotspots.fetch.data', ['leaflet' => $leaflet]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ url: url })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) return alert(data.error);

                    document.getElementById('price').value = data.price || '';
                    document.getElementById('promo_price').value = data.promo_price || '';
                    document.getElementById('url').value = data.final_url || url;
                })
                .catch(() => alert('Błąd podczas pobierania danych'));
        });





    </script>

</x-layout-panel>
