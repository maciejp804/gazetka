<x-layout-panel>

<x-admin.header-back/>

<header class="bg-white shadow mb-6">
    <div class="flex justify-between mx-auto max-w-7xl">
        <div class="px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Product</h1>
        </div>
    </div>
</header>
<x-admin.breadcrumbs :breadcrumbs="$breadcrumbs"/>
<div class="flex flex-col max-w-3xl mx-auto bg-white p-6 rounded shadow">
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
        @php
            $contentBlocks = old('content', $product_description->content ?? []);
        @endphp
        <form action="{{ route('admin.products.description.shop.updateShopContent', [$product, $shop]) }}" method="POST" >
            @csrf
            @method('PUT')
        <div id="content-wrapper">
            @foreach($contentBlocks as $index => $block)
                <div class="content-block border rounded p-4 mb-4 relative">
                    <button type="button" onclick="openModal({{ $index }})" class=" px-4 py-2 bg-blue-600 text-white rounded my-2">
                        Edytuj zdjęcie
                    </button>
                    <img src="{{Storage::url($block['image'].'.webp')}}" alt="image">
                    <input type="text" name="content[{{ $index }}][image]" class="w-full mb-2 hidden" placeholder="Zdjęcie" value="{{ $block['image'] ?? '' }}">
                    <input type="text" name="content[{{ $index }}][h2_title]" class="w-full mb-2" placeholder="Tytuł H2" value="{{ $block['h2_title'] ?? '' }}">
                    <input type="text" name="content[{{ $index }}][h3_title]" class="w-full mb-2" placeholder="Tytuł H3" value="{{ $block['h3_title'] ?? '' }}">
                    <textarea name="content[{{ $index }}][body]" class="w-full h-32" placeholder="Treść">{{ $block['body'] ?? '' }}</textarea>
                    <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-600 text-sm">🗑️</button>
                </div>

            @endforeach
        </div>
            <x-form.submit label="Edytuj Parametry"/>
            <input type="hidden" id="content-counter" value="{{ count($contentBlocks) }}">
            <button type="button" onclick="addContentBlock()" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">➕ Dodaj blok treści</button>
        </form>
        @foreach($contentBlocks as $index => $block)
        <div id="modal-{{ $index }}" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 items-center justify-center">
            <form method="POST" action="{{route('admin.products.description.shop.content.update.image', [$product, $shop,$index])}}" enctype="multipart/form-data" class="bg-white p-4 rounded shadow">
                @csrf
                @method('PUT')
                <input type="file" name="image" required class="block mb-2">
                <x-form.submit label="Zapisz nowe zdjęcie" />
            </form>
        </div>
        @endforeach

        <script>
            function addContentBlock() {
                let index = parseInt(document.getElementById('content-counter').value);
                const wrapper = document.getElementById('content-wrapper');

                const div = document.createElement('div');
                div.className = "content-block border rounded p-4 mb-4 relative";
                div.innerHTML = `
            <input type="text" name="content[${index}][image]" class="w-full mb-2 hidden" placeholder="Ścieżka do obrazka">
            <input type="text" name="content[${index}][h2_title]" class="w-full mb-2" placeholder="Tytuł H2">
            <input type="text" name="content[${index}][h3_title]" class="w-full mb-2" placeholder="Tytuł H3">
            <textarea name="content[${index}][body]" class="w-full h-32" placeholder="Treść"></textarea>
            <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-600 text-sm">🗑️</button>
        `;
                wrapper.appendChild(div);
                document.getElementById('content-counter').value = index + 1;
            }
        </script>

        <script>
            function openModal(index) {
                document.getElementById('modal-' + index).classList.remove('hidden');
                document.getElementById('modal-' + index).classList.add('flex');
            }

            function closeModal(index) {
                document.getElementById('modal-' + index).classList.add('hidden');
                document.getElementById('modal-' + index).classList.remove('flex');
            }
        </script>



</div>
</x-layout-panel>
