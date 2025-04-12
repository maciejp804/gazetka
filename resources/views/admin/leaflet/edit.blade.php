<x-layout-panel>

    <x-admin.header-back/>

    <header class="bg-white shadow mb-6">
        <div class="flex justify-between mx-auto max-w-7xl">
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Leaflet</h1>
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
        <form action="{{route('admin.leaflets.update', $leaflet)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <x-form.input name="title" label="Tytuł" :value="$leaflet->title"/>
            <x-form.input name="slug" label="Slug" :value="$leaflet->slug"/>
            <x-form.select
                name="shop_id"
                label="Sieć handlowa"
                :options="$shops->pluck('name', 'id')"
                :selected="$leaflet->shop_id"
            />
            <x-form.input type="datetime-local" name="valid_from" label="Ważny od" :value="$leaflet->valid_from"/>
            <x-form.input type="datetime-local" name="valid_to" label="Ważny do" :value="$leaflet->valid_to"/>
            <x-form.input type="datetime-local" name="display_from" label="Wyświetlaj od" :value="$leaflet->display_from"/>
            <x-form.input type="datetime-local" name="display_to" label="Wyświetlaj do" :value="$leaflet->display_to"/>
            <div class="my-4">
                <label class="block mb-1 font-medium">Okładka</label>
                @if($leaflet->cover->path)
                    <img src="{{ asset_from_storage($leaflet->cover->webp_path, 'webp') }}" alt="" class="w-20 h-20 mt-2 rounded object-cover">
                    <span>{{$leaflet->cover->webp_path}}</span>
                @endif
            </div>
            <x-form.select
                name="status"
                label="Status"
                :options="[
        'published' => 'Aktywny',
        'archive' => 'Archiwum',
        'draft' => 'Szkic',
    ]"
                :selected="$leaflet->status"
            />

            <div class="flex flex-col sm:flex-row justify-between">
                <x-form.checkbox name="require_age_verification" label="18+" :checked="$leaflet->require_age_verification"/>
                <x-form.checkbox name="for_all_stores" label="Dla wszstkich sklepów?" :checked="$leaflet->for_all_stores"/>
                <x-form.checkbox name="pinned" label="Wyróżniony" :checked="$leaflet->pinned"/>
            </div>
            <x-form.select
                name="priority"
                label="Piorytet wyróżnienia"
                :options="[
        '5' => 'Bardzo wysoki - 5',
        '4' => 'Wysoki - 4',
        '3' => 'Średni - 3',
        '2' => 'Niski - 2',
        '1' => 'Domyślny - 1',
        '0' => 'Brak - 0'
    ]"
                :selected="$leaflet->priority"
            />


            <x-form.textarea type="textarea" name="description_short" label="Zajawka" :value="$leaflet->description_short" maxlength="600"/>
            <x-form.textarea type="textarea" name="description_long" label="Opis" :value="$leaflet->description_long"  maxlength="1000"/>


            <x-form.submit label="Edytuj sieć handlową"/>
        </form>
        <form action="{{ route('admin.leaflets.destroy', $leaflet) }}" method="POST" onsubmit="return confirm('Na pewno chcesz usunąć?')" class="flex justify-end">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-lg text-red-600 hover:underline">Usuń</button>
        </form>


    </div>
</x-layout-panel>
