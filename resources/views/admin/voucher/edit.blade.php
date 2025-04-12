<x-layout-panel>

    <x-admin.header-back/>

    <header class="bg-white shadow mb-6">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Voucher</h1>
        </div>
    </header>
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <form action="{{ route('admin.vouchers.update', $voucher) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <x-form.input name="title" label="Tytuł" :value="$voucher->title"/>
        <x-form.input name="excerpt" label="Zajawka" :value="$voucher->excerpt"/>
        <x-form.input name="body" label="Opis" :value="$voucher->body"/>
        <x-form.input name="url" label="URL" :value="$voucher->url"/>
        <x-form.input name="code" label="Kod kuponu" :value="$voucher->code"/>
        <x-form.input name="conditions" label="Warunki" :value="$voucher->conditions"/>

        <x-form.select
            name="voucher_store_id"
            label="Sklep"
            :options="$stores->pluck('name', 'id')"
            :selected="$voucher->voucher_store_id"
        />
        <div class="flex justify-between">
            <x-buttons.primary-a :url="route('admin.vouchers.store.create')">Dodaj</x-buttons.primary-a>
{{--            <x-buttons.primary-a :url="route('vouchers.edit', ['voucher' => $voucher])">Edytuj</x-buttons.primary-a>--}}
        </div>

        <x-form.select
            name="category_id"
            label="Kategoria"
            :options="$categories->pluck('name', 'id')"
            :selected="$voucher->category_id"
        />

        <x-form.select
            name="status"
            label="Status"
            :options="[
        'active' => 'Aktywny',
        'expired' => 'Wygasły',
        'draft' => 'Szkic',
    ]"
            :selected="$voucher->status"
        />


        <x-form.checkbox name="is_featured" label="Wyróżniony" :checked="$voucher->is_featured"/>

        <x-form.input type="datetime-local" name="valid_from" label="Ważny od" :value="$voucher->valid_from"/>
        <x-form.input type="datetime-local" name="valid_to" label="Ważny do" :value="$voucher->valid_to"/>

        <div class="my-4">
            <label class="block mb-1 font-medium">Obrazek (120x120)</label>
            <input type="file" name="image" class="block w-full border border-gray-300 p-2 rounded" />
            @if($voucher->image)
                <img src="{{ asset('storage/'.$voucher->image.'.webp') }}" alt="" class="w-20 h-20 mt-2 rounded object-cover">
            @endif
        </div>

        <x-form.submit label="Aktualizuj kupon"/>
    </form>
    <form action="{{ route('admin.vouchers.destroy', $voucher) }}" method="POST" onsubmit="return confirm('Na pewno chcesz usunąć?')" class="flex justify-end">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-lg text-red-600 hover:underline">Usuń</button>
    </form>
</div>
</x-layout-panel>
