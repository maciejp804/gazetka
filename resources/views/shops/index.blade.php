

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{asset('js/html2canvas.min.js')}}"></script>
<x-layout-panel>
    <div class="min-h-full">
        <x-header-back/>

        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Shops</h1>
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 bg-gray-600">
                <div class="flex w-full">
                    <section id="leafletGenerated">
                        @if($shop == 'home-you')
                            <x-back-end.home-you.one :data="$data" :image="$image"/>
                        @endif

                            @if($shop == 'lidl')
                                <x-back-end.lidl.one :data="$data" :image="$image"/>
                            @endif


                    </section>
                    <section class="w-116">
                        <div class="w-full pl-2 flex flex-col ">

                            <form id="data_generator" class="flex" enctype="multipart/form-data">
                                <div class="flex flex-col gap-4 w-full">
                               <input type="hidden" id="store" name="store" required="required" value="{{$shop}}" />

                                    <label class="text-white" for="filename">Numer strony:</label>
                                    <input type="text" id="filename" name="filename" class="text-black w-auto" placeholder="Wprowadź numer strony">
                                    <div id="error-filename"></div>
                                    <label class="text-white" for="url">Link do strony:</label>
                                    <input type="url" id="url" name="url" class="text-black" placeholder="Wprowadź link strony">
                                    <div id="error-url"></div>
                                    <label class="text-white" for="affUrl">Link strony afiliacyjnej:</label>
                                    <input type="url" id="affUrl" name="affUrl" required class="text-black w-auto" placeholder="Wprowadź link afiliacyjny">
                                    <label class="text-white" for="productId">ID produktu (RTVEUROAGD):</label>
                                    <input type="text" id="productId" name="productId" required class="text-black w-auto" placeholder="Wprowadź ID produktu">
                                    <div id="error-productId"></div>
                                    <label for="photoInput" id="photoLabel" class="cursor-pointer text-white flex leading-3 p-4 border-2 mb-2 hover:bg-green-600 hover:text-red-600 hover:font-extrabold hover:border-green-200 hover:border-b-green-950 hover:border-r-pink-950 w-40 justify-center transition-all duration-700">Wybierz zdjęcie</label>
                                    <input type="file" id="photoInput" name="photo" class="hidden">
                                    <div id="error-photoInput"></div>
                                    <div id="inputPhoto" class="text-white">Nie wybrano pliku</div>
                                </div>
                            </form>
                            <div class="w-full">
                                <button class="text-white flex leading-3 p-4 border-2 mb-2 hover:bg-green-600 hover:text-red-600 hover:font-extrabold hover:border-green-200 hover:border-b-green-950 hover:border-r-pink-950 w-40 justify-center transition-all duration-700" id="generator">Generator</button>
                                <button class="text-white flex leading-3 p-4 border-2 mb-2 hover:bg-yellow-400 w-40 justify-center transition-all duration-700 hover:text-black hover:border-red-500" id="captureButton">Pobierz obraz</button>
                            </div>

                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>

    <script>

        let store = document.getElementById('filename').value;

        document.getElementById('photoInput').addEventListener('change', function() {
            var label = document.getElementById('inputPhoto');
            if (this.files && this.files[0]) {
                label.textContent = this.files[0].name;
            }
        });

        document.getElementById('captureButton').addEventListener('click', function() {
            let errorStatus = 0;
            let filename = document.getElementById('filename').value;
            if (filename === ''){
                document.getElementById('error-filename').innerHTML = '<p class="text-red-600 text-xs">*Wprowadź numer strony</p>';
                errorStatus = 1;
            }

            if(errorStatus === 1){
                return false;
            }

            html2canvas(document.getElementById('leafletCanvas'), {
                scale: 2,
                useCORS: true,
                proxy: 'http://gazetka-zaplecze.local/proxy'
            }).then(canvas => {
                // Konwertuj obraz na dane URL
                var imageDataURL = canvas.toDataURL('image/jpeg');

                // Utwórz element linku pobierania
                var downloadLink = document.createElement('a');
                downloadLink.href = imageDataURL;
                downloadLink.download = filename + '.jpg'; // Nazwa pliku do pobrania

                // Kliknij link, aby pobrać obraz
                downloadLink.click();
            });
        });

        document.getElementById('generator').addEventListener('click', function() {
            console.log("generator");
            let errorStatus = 0;
            let filename = document.getElementById('filename').value;
            if (filename === ''){
                document.getElementById('error-filename').innerHTML = '<p class="text-red-600 text-xs">*Wprowadź numer strony</p>';
                errorStatus = 1;
            }
            let store = document.getElementById('store').value;
            let productId = document.getElementById('productId').value;
            let url = document.getElementById('url').value;
            let photoInput = document.getElementById('photoInput').value;
            console.log('url ' + url + ' photoInput ' + photoInput + ' store ' + store);
            if (url === '' && store === 'media-expert' ){
                document.getElementById('error-url').innerHTML = '<p class="text-red-600 text-xs">*Wprowadź link strony</p>';
                errorStatus = 1;
            } else if (productId === '' && store === 'rtveuroagd' ){
                document.getElementById('error-productId').innerHTML = '<p class="text-red-600 text-xs">*Wprowadź ID produktu</p>';
                errorStatus = 1;
            }

            if(photoInput === '' && store === 'rtveuroagd'){
                document.getElementById('error-photoInput').innerHTML = '<p class="text-red-600 text-xs">*Wczytaj plik</p>';
                errorStatus = 1;
            }

            if(errorStatus === 1){
                return false;
            }

            generator();

        })
        function generator(){
            let formData = new FormData(); // Utwórz obiekt FormData

// Dodaj wszystkie pola formularza do obiektu FormData
            formData.append('store', $('#store').val());
            formData.append('filename', $('#filename').val());
            formData.append('url', $('#url').val());
            formData.append('affUrl', $('#affUrl').val());
            formData.append('productId', $('#productId').val());
            formData.append('photo', $('#photoInput')[0].files[0]); // Dodaj przesłany plik



            $.ajax({
                type: 'POST',
                url: '/generator',
                data: formData,
                processData: false, // Ustawienie processData na false jest konieczne, aby uniknąć przetwarzania danych formularza przez jQuery
                contentType: false, // Ustawienie contentType na false jest konieczne, aby przesłać dane w formie FormData
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                success: function(response) {
                    console.log('sukces');
                    $('#leafletGenerated').html(response);
                },
                error: function(xhr, status, error) {
                    console.error(error + ' ' + xhr + ' obsługa błędów'); // Obsługa błędów
                }
            });
        }

    </script>


</x-layout-panel>
