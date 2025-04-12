<x-layout-panel>

    <x-admin.header-back/>

    <header class="bg-white shadow mb-6">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Voucher</h1>
        </div>
    </header>

<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <form action="{{ route('admin.vouchers.add') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <x-form.input name="title" label="Tytuł"/>
        <x-form.input name="excerpt" label="Zajawka" />
        <x-form.input name="body" label="Opis" />
        <x-form.input name="url" label="URL"/>
        <x-form.input name="code" label="Kod kuponu" />
        <x-form.input name="conditions" label="Warunki" />

        <x-form.select
            name="voucher_store_id"
            label="Sklep"
            :options="$stores->pluck('name', 'id')"
            :selected="old('voucher_store_id')"
        />
        <div class="flex justify-between">
            <x-buttons.primary-a :url="route('admin.vouchers.store.create')">Dodaj</x-buttons.primary-a>
{{--            <x-buttons.primary-a :url="route('vouchers.edit', ['voucher' => $voucher])">Edytuj</x-buttons.primary-a>--}}
        </div>

        <x-form.select
            name="category_id"
            label="Kategoria"
            :options="$categories->pluck('name', 'id')"
            :selected="old('category_id')"
        />

        <x-form.select
            name="status"
            label="Status"
            :options="[
        'active' => 'Aktywny',
        'expired' => 'Wygasły',
        'draft' => 'Szkic',
    ]"
            :selected="old('status')"
        />


        <x-form.checkbox name="is_featured" label="Wyróżniony" :checked="old('is_featured', $voucher->is_featured ?? false)" />

        <x-form.input type="datetime-local" name="valid_from" label="Ważny od" />
        <x-form.input type="datetime-local" name="valid_to" label="Ważny do" />

        <div class="my-4">
            <label class="block mb-1 font-medium">Obrazek (120x120)</label>
            <input type="file" name="image" class="block w-full border border-gray-300 p-2 rounded" />
        </div>

        <x-form.submit label="Dodaj kupon"/>
    </form>
</div>
</x-layout-panel>
