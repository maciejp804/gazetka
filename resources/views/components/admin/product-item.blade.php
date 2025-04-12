@props(['items'])
@foreach($items as $item)
    @php
        $image = data_get($item, 'image');
        $name = data_get($item, 'name', 'Bez tytułu');
        $id = data_get($item, 'id');
        $slug = data_get($item, 'slug');
        $imagePath = $image ? $image . '.webp' : null;
        $exists = $imagePath && Storage::disk('public')->exists($imagePath);
    @endphp

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="aspect-[12/12] bg-gray-100 flex items-center justify-center relative">
            @if($exists)
                <img src="{{ Storage::url($imagePath) }}" alt="Okładka" class="w-full h-full object-cover">
            <div class="absolute inset-0 flex items-center justify-center">
                <form action="{{ route('admin.products.upload.image', $id) }}" method="POST" enctype="multipart/form-data" class="flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 bg-opacity-50 border border-dashed border-gray-300 relative group overflow-hidden">
                    @csrf
                    <label for="upload-offer-{{ $id }}" class="cursor-pointer flex flex-col items-center justify-center text-gray-500 text-1xs group-hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Edytuj zdjęcie
                    </label>
                    <input id="upload-offer-{{ $id }}" type="file" name="image" class="hidden" onchange="this.form.submit()">
                </form>
            </div>

            @else
                <form action="{{ route('admin.products.upload.image', $id) }}" method="POST" enctype="multipart/form-data" class="flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 border border-dashed border-gray-300 relative group overflow-hidden">
                    @csrf
                    <label for="upload-offer-{{ $id }}" class="cursor-pointer flex flex-col items-center justify-center text-gray-500 text-1xs group-hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Dodaj zdjęcie
                    </label>
                    <input id="upload-offer-{{ $id }}" type="file" name="image" class="hidden" onchange="this.form.submit()">
                </form>
            @endif
        </div>
        <div class="p-4 space-y-2">
            <h3 class="font-semibold text-lg text-center">{{ $name }}</h3>
            <div class="flex justify-center items-center mt-2">
                <x-buttons.primary-a :url="route('admin.products.manage', ['product' => $slug])">Zarządzaj</x-buttons.primary-a>
            </div>
        </div>
    </div>
@endforeach
