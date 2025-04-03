<x-layout-panel>

    <x-header-back/>

    <header class="bg-white shadow mb-6">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Vouchers</h1>
        </div>
    </header>
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
            <h1 class="text-xl font-bold mb-6">Dodaj nowy sklep</h1>

            <form action="{{route('vouchers.store.add')}}" method="POST" enctype="multipart/form-data" >
                @csrf

                <x-form.input name="name" label="Nazwa sklepu" />
                <x-form.input name="program_id" label="Program ID (6-cyfr - 000001)" />
                <div class="my-4">
                    <label class="block mb-1 font-medium">Logo (120x40)</label>
                    <input type="file" name="image" class="block w-full border border-gray-300 p-2 rounded" />
                </div>
                <x-form.select
                    name="shop_id"
                    label="Sklep z gazetkami"
                    :options="$shops->pluck('name', 'id')"
                    :selected="old('id')"
                />
                <x-form.select
                    name="category_id"
                    label="Kategoria"
                    :options="$categories->pluck('name', 'id')"
                    :selected="old('category_id')"
                />
                <x-form.select
                    name="status"
                    label="Status"
                    :options="['active' => 'Aktywny', 'draft' => 'Szkic']"
                    :selected="old('status', 'active')"
                />

                <x-form.submit label="Dodaj sklep" />
            </form>
        </div>
    </div>


</x-layout-panel>
