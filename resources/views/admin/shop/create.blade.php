<x-layout-panel>
    <x-admin.header-back />

    <header class="bg-white shadow mb-2">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Nowa sieć handlowa</h1>
        </div>
    </header>

    <x-admin.breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <form action="{{route('admin.shops.add')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-form.input name="name" label="Nazwa sieci (biernik)"/>
            <x-form.input name="name_genitive" label="Nazwa sieci (dopiełniacz)"/>
            <x-form.input name="name_locative" label="Nazwa sieci (miejscownik)"/>
            <x-form.input name="slug" label="Slug"/>
            <x-form.select
                name="category_id"
                label="Kategoria"
                :options="$categories->pluck('name', 'id')"
                :selected="old('category_id')"
            />
            <div class="my-4">
                <label class="block mb-1 font-medium">Obrazek (100x100)</label>
                <input type="file" name="image" class="block w-full border border-gray-300 p-2 rounded" />

            </div>

            <x-form.select
                name="status"
                label="Status"
                :options="[
                    'active' => 'Aktywny',
                    'inactive' => 'Nieaktywny',
                    'draft' => 'Szkic'
                    ]"
                :selected="old('status')"
            />

            <x-form.submit label="Utwórz nową sieć"/>
        </form>
    </div>
</x-layout-panel>
