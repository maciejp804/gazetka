<x-layout-panel>
    <x-admin.header-back />


    <header class="bg-white shadow mb-2">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Sieć handlowa {{$shop->name}}</h1>
        </div>

    </header>

    <x-admin.breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <div class="flex flex-col max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <form action="{{route('admin.shops.update', $shop)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <x-form.input name="name" label="Nazwa sieci (biernik)" :value="$shop->name"/>
            <x-form.input name="name_genitive" label="Nazwa sieci (dopiełniacz)" :value="$shop->name_genitive"/>
            <x-form.input name="name_locative" label="Nazwa sieci (miejscownik)" :value="$shop->name_locative"/>
            <x-form.input name="slug" label="Slug" :value="$shop->slug"/>
            <x-form.select
                name="category_id"
                label="Kategoria"
                :options="$categories->pluck('name', 'id')"
                :selected="$shop->category_id"
            />
            <div class="my-4">
                <label class="block mb-1 font-medium">Obrazek (100x100)</label>
                <input type="file" name="image" class="block w-full border border-gray-300 p-2 rounded" />
                @if($shop->image)
                    <img src="{{ asset_from_storage($shop->image, 'webp') }}" alt="" class="w-20 h-20 mt-2 rounded object-cover">
                    <span>{{$shop->image}}</span>
                @endif
            </div>
            <x-form.select
                name="status"
                label="Status"
                :options="[
        'active' => 'Aktywny',
        'inactive' => 'Nieaktywny',
        'draft' => 'Szkic',
    ]"
                :selected="$shop->status"
            />

            <x-form.submit label="Edytuj sieć handlową"/>
        </form>
        <form action="{{ route('admin.shops.destroy', $shop) }}" method="POST" onsubmit="return confirm('Na pewno chcesz usunąć?')" class="flex justify-end">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-lg text-red-600 hover:underline">Usuń</button>
        </form>


    </div>
</x-layout-panel>
