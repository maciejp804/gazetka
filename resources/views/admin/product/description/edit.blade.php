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

        <form action="{{ route('admin.products.description.update', $product) }}" method="POST" >
            @csrf
            @method('PUT')

            <x-form.input name="name" label="Nazwa" :value="$product->name"/>
            <x-form.input name="slug" label="Slug" :value="$product->slug"/>
            <x-form.select
                name="category"
                label="Kategoria"
                :options="$categories->pluck('name', 'id')"
                :selected="$product->category_id"
            />

            <x-form.textarea type="textarea" name="excerpt" label="Wstęp" placeholder="Krótki wstęp..." :value="$product->descriptions->excerpt"  maxlength="600"/>
            <x-form.select
                name="status"
                label="Status"
                :options="[
        '1' => 'Aktywny',
        '0' => 'Nieaktywny',
        '2' => 'Szkic',

    ]"
                :selected="$product->status"
            />
            <x-form.input name="h1_title" label="H1" :value="$product->descriptions->h1_title"/>
            <x-form.input name="meta_title" label="Meta Title" :value="$product->descriptions->meta_title"/>
            <x-form.input name="meta_description" label="Meta Description" :value="$product->descriptions->meta_description"/>
            <x-form.input name="meta_keywords" label="Meta Keywords" :value="$product->descriptions->meta_keywords"/>
            <x-form.input name="manufacturer" label="Producent" :value="$product->manufacturer"/>
            <x-form.input name="sku" label="Kod" :value="$product->sku"/>
            <x-form.submit label="Edytuj"/>
        </form>


    </div>
</x-layout-panel>
