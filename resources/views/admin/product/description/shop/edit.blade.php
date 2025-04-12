<x-layout-panel>

    <x-admin.header-back/>

    <header class="bg-white shadow mb-6">
        <div class="flex justify-between mx-auto max-w-7xl">
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Product - {{  $product->name }}</h1>
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

        <form action="{{ route('admin.products.description.shop.updateShop', [$product, $shop]) }}" method="POST" >
            @csrf
            @method('PUT')
            <span class="px-3 py-2 flex">Nazwa: {{mb_ucfirst($product->name)}}</span>
            <span class="px-3 py-2 flex">Slug: {{$product->slug}}</span>
            <span class="px-3 py-2 flex">Kategoria: {{mb_ucfirst($product->category->name)}}</span>
            <span class="px-3 py-2 flex">Status: {{mb_ucfirst($product->status)}} (1-Aktywny, 0 - Nieaktywny)</span>
            <x-form.textarea type="textarea" name="excerpt" label="Wstęp" placeholder="Krótki wstęp..." :value="$product_description->excerpt"  maxlength="600"/>
            <x-form.input name="h1_title" label="H1" :value="$product_description->h1_title"/>
            <x-form.input name="meta_title" label="Meta Title" :value="$product_description->meta_title"/>
            <x-form.input name="meta_description" label="Meta Description" :value="$product_description->meta_description"/>
            <x-form.input name="meta_keywords" label="Meta Keywords" :value="$product_description->meta_keywords"/>
            <x-form.submit label="Edytuj"/>
        </form>


    </div>
</x-layout-panel>
