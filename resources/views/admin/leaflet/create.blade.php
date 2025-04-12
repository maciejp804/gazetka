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
        <form action="{{route('admin.leaflets.add')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <x-form.input name="title" label="Tytuł" />
            <x-form.input name="slug" label="Slug" />
            <x-form.select
                name="shop_id"
                label="Sieć handlowa"
                :options="$shops->pluck('name', 'id')"
                :selected="old('shop_id')"
            />
            <x-form.input type="datetime-local" name="valid_from" label="Ważny od" />
            <x-form.input type="datetime-local" name="valid_to" label="Ważny do" />
            <x-form.input type="datetime-local" name="display_from" label="Wyświetlaj od" />
            <x-form.input type="datetime-local" name="display_to" label="Wyświetlaj do" />
            <div class="my-4">
                <x-form.input type="file" name="image" label="Okładka" />
            </div>
            <x-form.select
                name="status"
                label="Status"
                :options="[
        'published' => 'Aktywny',
        'archive' => 'Archiwum',
        'draft' => 'Szkic',
    ]"
                :selected="old('status')"
            />

            <div class="flex flex-col sm:flex-row justify-between">
                <x-form.checkbox name="require_age_verification" label="18+" :checked="old('require_age_verification')"/>
                <x-form.checkbox name="for_all_stores" label="Dla wszstkich sklepów?" :checked="1"/>
                <x-form.checkbox name="pinned" label="Wyróżniony" :checked="old('pinnned')"/>
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
                :selected="old('priority')"
            />


            <x-form.textarea type="textarea" name="description_short" label="Zajawka" :value="old('description_short')" maxlength="600"/>
            <x-form.textarea type="textarea" name="description_long" label="Opis" :value="old('description_long')"  maxlength="1000"/>


            <x-form.submit label="Dodaj gazetkę"/>
        </form>
    </div>

</x-layout-panel>
