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
        <form action="{{ route('admin.leaflets.page.add', $leaflet) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Dodawanie nowych stron -->
            <div>

                <x-form.input-file type="file" name="files[]" id="pages" multiple="multiple" required="required" label="Wybierz strony:"/>
                <p>Możesz dodać kilka plików (np. obrazy - jpg, png, webp).</p>
            </div>

            <!-- Podgląd ikon (miniatur) stron -->
            <p>Podgląd ikon:</p>
            <div id="file-preview-container" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300'">
                <!-- Tutaj będą wyświetlane podglądy miniatur -->
            </div>
            <!-- Przycisk do dodania stron -->
            <x-form.submit label="Dodaj strony" />
        </form>

    </div>

    <script>
        document.getElementById('pages').addEventListener('change', function(event) {
            const filePreviewContainer = document.getElementById('file-preview-container');
            filePreviewContainer.innerHTML = '';  // Clear existing previews

            const files = event.target.files;

            // Iteracja po wybranych plikach
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Tworzymy miniaturkę
                    const img = document.createElement('img');
                    img.src = e.target.result;  // Źródło obrazu to wynik odczytu pliku
                    img.classList.add('w-1/4', 'my-2');  // Dodaj klasy CSS dla obrazków
                    filePreviewContainer.appendChild(img);
                };

                // Odczytujemy plik jako URL
                reader.readAsDataURL(file);
            });
        });

    </script>


</x-layout-panel>
